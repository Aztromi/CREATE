<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class ApplicationRequestController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['admin.og', 'admin.super']);
    // }

    public function applicationRequests()
    {
        // $users = User::allUsers()->with('vLabel', 'profile')->orderBy('created_at', 'desc')->paginate(10);

        $users = User::allUsers()->with('vLabel', 'profile')->orderBy('created_at', 'desc')->get();
        
        return view('admin.registered-users.application-requests')
            ->with(compact('users', $users));
    }

    public function elevateToUnverified($id)
    {

    }

    // public function generateUserList(Request $request)
    // {

    //     $state = $request->input('state');
    //     $status = $request->input('option');
    //     // $searchVal = $request->input('searchVal');
        
    //     // // Check if "Select One" option is selected
    //     // if ($selectedOption === 'select_one') {
    //     //     return response()->json('');
    //     // }
        
    //     // Process the selected option and fetch the updated data for the data table


    //     // if($state == 'init')
    //     switch($status)
    //     {
    //         case 'pending':
    //             $users = User::with('vLabel', 'profile')->whereNotIn('verified', [-1, 0, 1])->paginate(10);
    //             break;
    //         case 'member':
    //             $users = User::with('vLabel', 'profile')
    //                 ->where([
    //                     ['verified', -1],
    //                     ['type', 'normal'],
    //                     ['approved', 1]
    //                 ])->paginate(10);
    //             break;
    //         case 'unverifired':
    //             $users = User::with('vLabel', 'profile')
    //                 ->where([
    //                     ['verified', 0],
    //                     ['type', 'normal'],
    //                     ['approved', 1]
    //                 ])->paginate(10);
    //             break;
    //         case 'verified':
    //             $users = User::with('vLabel', 'profile')
    //                 ->where([
    //                     ['verified', 1],
    //                     ['type', 'normal'],
    //                     ['approved', 1]
    //                 ])->paginate(10);
    //             break;
    //         default:
    //             $users = User::allUsers()->with('vLabel', 'profile')->paginate(10);
    //             break;
    //     }
            
        
    //     // Return the updated data table view
    //     return view('admin.registered-users.application-requests', ['users' => $users])->render();
    // }



    public function userApproval(Request $request)
    {
        $user = User::find($request->uID);

        if(!isset($user))
        {
            return response()->json(['errors' => 'Not found'], 422);
        }

        $user->approved = $request->newApproval;
        $user->save();

        return response()->json(['validated' => true, 'message' => 'Update successful!'], 200);
    }


    public function userStatus(Request $request)
    {
        $user = User::find($request->uID);
        $user->verified = $request->newStatus;
        $user->approved = 1;
        $user->save();

        // VERIFIED CHANGE
        if($request->newStatus == 0)
        {

        }
        else if($request->newStatus == 1)
        {

        }


        

        return response()->json(['validated' => true, 'message' => 'Update successful!'], 200);
    }

   


}