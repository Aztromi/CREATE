<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SectorList;
use App\Models\User;

use Auth;

class CategoryController extends Controller
{
    public function getCategories(Request $request)
    {
        $categories = SectorList::select('category', 'value', \DB::raw('"default" as list_state'))
            ->where('status', 'Active')
            ->orderBy('category', 'asc')
            ->orderBy('value', 'asc')
            ->get()
            ->groupBy('category');

        $others = '';

        if(Auth::check())
        {
            if(Auth::user()->isUser()){
                $user_id = Auth::id();
            }
            else{
                $user_id = $request->input('uID');
            }

            $user = User::with('profile.uindie.expertises')
                ->where('id', $user_id)
                ->first();

            if($user && $user->profile && $user->profile->uindie)
            {
                // Ternary to return blank collection if relation does not exist
                $qryExpertises = $user->profile->uindie->expertises();
                if($qryExpertises->exists()){
                    $expOthers = $qryExpertises
                        ->where('list_state', 'other')
                        ->select('category', 'value', 'list_state');
                }
                else{
                    $expOthers = collect();
                }

                $qrySectors = $user->profile->sectors();
                if($qrySectors){
                    $sectOthers = $qrySectors
                        ->where('list_state', 'other')
                        ->select('category', 'value', 'list_state');
                }
                else{
                    $sectOthers = collect();;
                }

                if($qryExpertises->get()->isNotEmpty() || $qrySectors->get()->isNotEmpty()){
                    $combined = $expOthers->union($sectOthers);

                    $others = $combined->distinct()
                        ->orderBy('value', 'asc')
                        ->get();
                }
                else{
                    $others = '';
                }
                
            }
        }
        else
        {
            abort(401);
        }

        return response()->json(['validated' => true, 'categoriesList' => $categories, 'others' => $others], 200);
    }
}
