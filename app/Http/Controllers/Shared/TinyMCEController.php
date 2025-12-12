<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use Auth;

class TinyMCEController extends Controller
{
    public function checkGateShared(){
        Gate::authorize('access-works-shared', Auth::user());
    }

    public function worksTinyMCEUpload(Request $request){
        $this->checkGateShared();

        if ($request->hasFile('file')) {
            $publicPath = 'folder_user-uploads/admin';
            $storePath = 'user_uploads_admin';
            $image = $request->file('file');
            if ($image) {
                $filename = md5(time()).'.'.$image->getClientOriginalExtension();
                $resize = Image::make($image);
                $resize->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                Storage::disk($storePath)->put($filename, (string) $resize->encode());

                return response()->json(['status' => 200, 'location' => asset($publicPath.'/'.$filename)], 200);
            }
        } else {
            header("HTTP/1.1 500 Server Error");
        }
     
    }
}
