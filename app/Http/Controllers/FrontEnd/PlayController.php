<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\PGDXGame;
use App\Models\PGDXGameContact;



class PlayController extends Controller
{
    public function pgdx25Play()
    {
        $snake_leader = $this->leaderQuery('snake');
        $tetris_leader = $this->leaderQuery('tetris');

        return view('website.info_page.2025_pgdx.play', [
            'snake_leader' => $snake_leader,
            'tetris_leader' => $tetris_leader
        ]);
    }

    private function leaderQuery($game) {
        return PGDXGameContact::with('game')
            ->whereHas('game', function($query) use ($game){
                $query->where('game', $game);
            })
            ->where('status', 1)
            ->orderBy('score', 'desc')->take(5)->get()
            ->map(function($s){
                return [
                    'nickname' => $s->nickname,
                    'score' => $s->score,
                ];
            });
    }

    public function pgdx25PlaySelect($game = null)
    {
        switch($game) {
            case 'snake':
                return view('website.info_page.2025_pgdx.snake');
                break;
            case 'tetris':
                return view('website.info_page.2025_pgdx.tetris');
                // return redirect()->route('events.pgdx-2025.play');
                break;
            default:
                return redirect()->route('events.pgdx-2025.play');
                break;
        }
    }

    public function pgdx25GenerateID(Request $request) {

        $validator = Validator::make($request->all(), [
            'game' => 'required|string|in:snake,tetris'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $game = $request->input('game', '');

        // if(!in_array($game, ['snake','tetris'])){
        //     return '';
        // }

        $microTime = microtime(true);
        $hash = substr(md5($microTime), 0, 16);

        $newGame = PGDXGame::create([
            'game' => $game,
            'play_id' => $hash
        ]);

        return response()->json(['play_id' => $newGame->play_id], 200);
    }

    public function pgdx25SaveScore(Request $request) {

        $validator = Validator::make($request->all(), [
            'game' => 'required|string|in:snake,tetris',
            'play_id' => 'required|string',
            'score' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $gameType = $request->input('game', '');
        $play_id = $request->input('play_id', '');
        $score = (int) $request->input('score', '');

        $game = PGDXGame::where([
            'play_id' => $play_id,
            'game' => $gameType
        ])->first();

        if(!$game) {
            // NOT FOUND
            return response()->json(['status' => false], 200);
        }

        $topScores = PGDXGameContact::whereHas('game', function($query) use ($gameType){
                $query->where('game', $gameType);
            })
            ->where('status', 1)
            ->orderBy('score', 'desc')
            ->limit(3)
            ->pluck('score')
            ->push($score) // include the new score
            ->sortDesc()
            ->take(3);


        if (!$topScores->contains($score)) {
            return response()->json(['status' => false], 200);
        }
        
        $game->contact()->create([
            'score' => $score,
            'status' => 0
        ]);
        
        return response()->json(['status' => true], 200);
    }

    public function pgdx25SaveContact(Request $request) {

        $validator = Validator::make($request->all(), [
            'game-type' => 'required|string|in:snake,tetris',
            'game-play-id' => 'required|string',
            'nickname' => 'required|string|max:6',
            'firstname' => 'required|string|max:30',
            'lastname' => 'required|string|max:30',
            'email' => 'required|email',
            'contact_number' => [
                'required',
                'string'
                // ,'regex:/^(?:\+63|0)?9\d{9}$/'
            ]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $gameType = $request->input('game-type', '');
        $play_id = $request->input('game-play-id', '');
        $nickname = $request->input('nickname', '');
        $firstname = $request->input('firstname', '');
        $lastname = $request->input('lastname', '');
        $email = $request->input('email', '');
        $contact_number = $request->input('contact_number', '');

        $game = PGDXGame::where([
            'play_id' => $play_id,
            'game' => $gameType
        ])->first();

        if(!$game) {
            return response()->json(['status' => false], 200);
        }

        $contact = $game->contact()->first();

        if(!$contact) {
            return response()->json(['status' => false], 200);
        }

        $contact->update([
            'nickname' => $nickname,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'contact_number' => $contact_number,
            'status' => 1
        ]);

        return response()->json(['status' => true], 200);
    }
}
