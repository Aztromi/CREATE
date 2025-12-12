<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    
    // foreach ($request->file('permits') as $file) {
    //     $originalFilename = $file->getClientOriginalName();
    //     $extension = $file->getClientOriginalExtension();
    //     $currentDate = now()->format('Ymd_His');
    //     $randomString = Str::random(12);
    //     $filename = $currentDate . '_permit_' . $randomString . '.' . $extension;

    //     $file->storeAs($path, $filename);

    //     $fUpload = new UploadedRequirement();
    //     $fUpload->type = 'goverment-document';
    //     $fUpload->file = $filename;
    //     $user->uploadedRequirements()->save($fUpload);
    // }

    public function articleContentImageUpload(Request $request)
    {

        if ($request->hasFile('file')) {
            $publicPath = 'folder_articles';
            $storePath = 'articles_content';
            $image = $request->file('file');
            if ($image) {
                $filename = md5(time()).'.'.$image->getClientOriginalExtension();
                $resize = Image::make($image);
                $resize->resize(800, null, function ($constraint) {
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
