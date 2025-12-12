<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\MessageContent;
use App\Models\MessageParticipant;
use App\Models\UProfile;
use App\Models\User;

use App\Events\NewMessageSent;

use Auth;

class MessageController extends Controller
{
    public function index(Request $request){
        $group_id = $request->query('group_id');
        return view('dashboard.content.messages', ['group_id' => $group_id]);
    }

    public function indexAdmin(Request $request){
        $group_id = $request->query('group_id');
        return view('admin.messages', ['group_id' => $group_id]);
    }

    public function getMessageList(Request $request){

        if(!Auth::check()){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $toSearch = null;

        if( $request->has('searchVal') && strlen(trim($request->input('searchVal'))) > 0 ) {
            if( !(Auth::user()->isAdminOG() || Auth::user()->isCreative()) ) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $toSearch = trim($request->input('searchVal'));
        }
        
        $userID = Auth::id();
        
        $messages = [];

        if($toSearch) {
            
            $chatData = DB::table('message_participants as p1')
                ->select(
                    'p1.group_id',
                    'p2.participant_id as other_participant_id',
                    'p1.notify',
                    'mc.message',
                    'mc.created_at as datetime'
                )
                ->join('message_participants as p2', 'p1.group_id', '=', 'p2.group_id')
                ->join(DB::raw('(SELECT group_id, COUNT(*) as p_count FROM message_participants GROUP BY group_id) as group_counts'), 'group_counts.group_id', '=', 'p1.group_id')
                
                ->leftJoin(DB::raw('(SELECT group_id, MAX(id) as max_id FROM message_contents GROUP BY group_id) as latest_messages'), 'latest_messages.group_id', '=', 'p1.group_id')
                ->leftJoin('message_contents as mc', 'mc.id', '=', 'latest_messages.max_id')
                ->where('p1.participant_id', '=', $userID)
                ->where('p2.participant_id', '!=', $userID)
                ->where('group_counts.p_count', '=', 2);
                
            $users = User::approvedVerifiedUnverified()
                ->with('profile')
                ->select('users.*', 'chats.group_id', 'chats.notify', 'chats.message as latest_message', 'chats.datetime as message_datetime')
                ->where('users.id', '!=', $userID)
                ->when($toSearch, function ($query, $searchTerm) {
                    return $query->whereHas('profile', function ($profileQuery) use ($searchTerm) {
                        $profileQuery->whereRaw("
                            (CASE
                                -- If display_name column is 'first_name', search the first_name column
                                WHEN display_name = 'first_name' THEN first_name
                                -- If display_name column is 'last_name', search the last_name column
                                WHEN display_name = 'last_name' THEN last_name
                                -- If display_name column is 'other_name', search the other_name column
                                WHEN display_name = 'other_name' THEN other_name
                                -- If display_name column is 'company_name', search the company_name column
                                WHEN display_name = 'company_name' THEN company_name
                                -- Otherwise (the fallback), search a combination of first_name and last_name
                                ELSE CONCAT(first_name, ' ', last_name)
                            END) LIKE ?
                        ", ["%{$searchTerm}%"]); // Safely bind the search term

                    });
                })
                ->leftJoinSub($chatData, 'chats', function ($join) {
                    $join->on('chats.other_participant_id', '=', 'users.id');
                })
                ->orderByDesc('chats.datetime')
                ->orderBy('users.name')
                ->get();
                
            foreach ($users as $user) {
                if ($user->group_id) {
                    $messages[] = [
                        'group_id' => $user->group_id,
                        'recipient_id' => 0,
                        'message' => $user->latest_message ?? 'Click to start a conversation...',
                        'notify' => $user->notify,
                        'co_participant' => $user->profile->dispName,
                        'datetime' => $user->message_datetime
                    ];
                } else {
                    $messages[] = [
                        'group_id' => 0,
                        'recipient_id' => $user->id,
                        'message' => 'Click to start a conversation...',
                        'notify' => 0,
                        'co_participant' => $user->profile->dispName,
                        'datetime' => null
                    ];
                }
            }
        } else {

            $messageGroups = MessageContent::whereHas('participants', function ($query) use ($userID) {
                $query->where('participant_id', $userID);
            })
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('message_contents')
                    ->groupBy('group_id');
            })
            ->with(['participants.profile', 'participants.user'])
            ->latest()
            ->get();
            
            foreach ($messageGroups as $group) {
                $co_participant_models = $group->participants->where('participant_id', '!=', $userID);
                $my_participation = $group->participants->where('participant_id', $userID)->first();

                $messages[] = [
                    'group_id' => $group->group_id,
                    'recipient_id' => 0,
                    'message' => $group->message,
                    'notify' => $my_participation ? $my_participation->notify : 0,
                    
                    'co_participant' => $co_participant_models->pluck('profile.dispName')->implode(', '),
                    
                    'datetime' => $group->created_at
                ];
            }
        }
        
        return response()->json($messages, 200);
    }
    
    public function sendMessage(Request $request) {
        
        if(!Auth::check()) {
            return response()->json('Unauthorized', 401);
        }

        if ($response = $this->validateMessage($request)) {
            return $response;
        }

        //For existing Message group, send group_id, else, send recipient_id instead
        $group_id = $request->input('group_id', '');
        $recipient_id = $request->input('recipient_id', '');
        $message = $request->input('message');
        $sender_id = Auth::id();

        $newMessage = null;
        
        try {
            DB::transaction(function () use (&$newMessage, &$group_id, $recipient_id, $sender_id, $message) {
                
                $group_id = $this->checkAndGetGroupID($group_id, $recipient_id);

                if(!$group_id) {
                    throw new \Exception('Not found');
                }

                // Save message
                $newMessage = MessageContent::create([
                    'group_id'  => $group_id,
                    'sender_id' => $sender_id,
                    'message'   => $message,
                    'status'    => 1
                ]);

                // Update notification flags for all other participants
                MessageParticipant::where([
                    'group_id' => $group_id,
                    'status'   => 1
                ])
                ->where('participant_id', '!=', $sender_id)
                ->update(['notify' => 1]);
                
            });

            if($newMessage) {
                broadcast(new NewMessageSent($newMessage))->toOthers();
            }

        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 404);
        }

            
        
        return response()->json('Sent', 200);
    }

    private function validateMessage($request) {
        $rules = [
            'message'       => 'required|string|max:200',
            'group_id'      => 'required_without:recipient_id|integer',
            'recipient_id'  => 'required_without:group_id|integer',
        ];

        $messages = [
            'message.required'          => 'Message is required.',
            'message.string'            => 'Only text values are allowed.',
            'message.max'               => 'Message has exceeded the limit.',
            
            'group_id.required_without' => 'Group ID is required.',
            'group_id.integer'          => 'Invalid Group ID.',

            'recipient_id.required_without' => 'Recipient ID is required.',
            'recipient_id.integer'      => 'Invalid Recipient ID.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'validated' => false,
                'errors'    => $validator->errors()
            ], 422);
        }

        return null;
    }

    public function getMessageEntries(Request $request){

        if(!Auth::check()){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if(!($request->filled('group_id') || $request->filled('recipient_id'))){
            return response()->json(['message' => 'No messages found'], 404);
        }

        $group_id = $request->input('group_id');
        $recipient_id = $request->input('recipient_id');
        $userID = Auth::id();
        
        $group_id = $this->checkAndGetGroupID($group_id, $recipient_id);
        
        if(!$group_id) {
            return response()->json('Not found', 404);
        }

        $messageGrab = MessageContent::whereHas('participants', function($query) use ($userID){
                $query->where('participant_id', $userID)->where('status', 1);
            })
            ->where('group_id', $group_id)
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->get();

        $messageDetails = [];
        if($messageGrab->isNotEmpty()){
            foreach($messageGrab as $message) {
                $co_participant = '';
                $senderType = '';
                if($message->sender_id <> $userID){
                    $co_participant = $message->senderDispName;
                    $senderType = 'co_participant';
                }
                else {
                    $senderType = 'user';
                }
                
                $messageDetails[] = [
                    'sender_type' => $senderType,
                    'sender_name' => $co_participant,
                    'message' => $message->message,
                    'datetime' => $message->created_at
                ];
            }
        }
        
        MessageParticipant::where([
                'group_id' => $group_id,
                'participant_id' => $userID
            ])
            ->update([
                'notify' => 0
            ]);

        $co_participants = MessageParticipant::where('group_id', $group_id)
            ->where('participant_id', '!=', $userID)
            ->get()
            ->map(function ($participant) {
                return $participant->participantDispName;
            })
            ->implode(', ');

        // if (empty($messageDetails)) {
        //     return response()->json(['message' => 'No messages found'], 404);
        // }

        return response()->json([
            'messageDetails' => $messageDetails,
            'co_participants' => $co_participants,
            'group_id' => $group_id
        ], 200);
    }


    // FROM ROUTE
    public function findOrCreateMessageGroup(User $recipient) {

        if(!Auth::check()) {
            return response()->json('Unauthorized', 401);
        }
        
        $group_id = $this->checkAndGetGroupID(0, $recipient->id);

        if(!$group_id) {
            return response()->json('Not found', 404);
        }

        if(Auth::user()->isUser()) {
            return redirect()->route('user.messages', ['group_id' => $group_id]);
        }
        elseif(Auth::user()->isAdminOG()) {
            return redirect()->route('admin.messages', ['group_id' => $group_id]);
        }
        else {
            return response()->json('Unauthorized', 401);
        }
        
    }

    private function checkAndGetGroupID($group_id, $recipient_id) {
        if (!Auth::check()) {
            return 0;
        }

        $sender_id = Auth::id();
        
        if (!empty($group_id)) {
            $isParticipant = MessageParticipant::where('group_id', $group_id)
                ->where('participant_id', $sender_id)
                ->exists();

            return $isParticipant ? $group_id : 0;
        }
        
        if (!empty($recipient_id)) {
            
            $existing_group_id = MessageParticipant::query()
                ->select('group_id')
                ->whereIn('participant_id', [$sender_id, $recipient_id])
                ->groupBy('group_id')
                ->havingRaw('COUNT(DISTINCT participant_id) = 2')
                ->where(function ($query) {
                    $query->selectRaw('count(*)')
                        ->from('message_participants as sub')
                        ->whereColumn('sub.group_id', 'message_participants.group_id');
                }, '=', 2)
                ->value('group_id');

            if ($existing_group_id) {
                return $existing_group_id;
            }
            
            try {
                return DB::transaction(function () use ($recipient_id, $sender_id) {
                    $new_group_id = $this->generateGroupID();
                    MessageParticipant::insert([
                        [
                            'group_id' => $new_group_id,
                            'participant_id' => $recipient_id,
                            'notify' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()
                        ],
                        [
                            'group_id' => $new_group_id,
                            'participant_id' => $sender_id,
                            'notify' => 0, 'status' => 1, 'created_at' => now(), 'updated_at' => now()
                        ]
                    ]);
                    return $new_group_id;
                });
            } catch (\Exception $e) {
                // Log the error if necessary: Log::error($e->getMessage());
                return 0;
            }
        }

        return 0;
    }

    private function generateGroupID() {
        do {
            $new_group_id = random_int(785, 214748364);
        } while (MessageParticipant::where('group_id', $new_group_id)->exists());

        return $new_group_id;
    }
}