<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use App\Models\Article;
use App\Models\Story;
use App\Models\UProfile;
use Tinify\Source;
use Tinify\Tinify;

class ThumbnailController extends Controller
{
    public function index()
    {
        $stories = Story::with(['user', 'slugs'])
            ->whereIn('ownerable_id', values: [2436])
            ->paginate(100);
        // $perPage = 20;
        // $page = 14;
        $profileData = UProfile::with('uindie')
            ->whereHas('uindie', function ($query) {
                $query->whereNotNull('display_photo');
            })
            // ->skip(($page - 1) * $perPage)
            // ->take($perPage)
            ->get();
        return view('admin.thumbnail.thumbnailmaker', ['stories' => $stories, 'profileData' => $profileData]);
    }
    // public function articleThumbnails()
    // {
    //     $featuredArticle = Article::has('asset')->with('asset', 'latestSlug')
    //         ->where([
    //             ['featured', 1],
    //             ['published', 'published']
    //         ])
    //         ->orderBy('date', 'desc')->first();

    //     $latestArticles = Article::has('asset')->with('asset', 'latestSlug')
    //         ->where([
    //             ['published', 'published'],
    //             ['id', '<>', $featuredArticle->id]
    //         ])
    //         ->latest()->take(6)->get();
    // }

    public function updateThumbnails(Request $request)
    {

        $ids = $request->ids;
        $images = $request->images;
        $pictures = [];
        $merged = collect($ids)->combine($images)->all();
        foreach ($merged as $id => $images) {
            $pictures[] = $this->PictureFinder($id, $images);
        }

        return back()->with('success', $pictures);
    }
    private function PictureFinder($id, $imagePath)
    {
        // Full path of the original image
        $source = public_path($imagePath);

        // Check if source image exists
        if (!file_exists($source)) {
            return null;
        }

        // Extract directory and filename
        $directory = dirname($imagePath); // stories
        $filename  = basename($imagePath); // image.jpg

        // Thumbnail directory (inside stories)
        $thumbnailDir = public_path($directory . '/thumbnails');

        // Create thumbnails folder if it doesn't exist
        if (!file_exists($thumbnailDir)) {
            mkdir($thumbnailDir, 0755, true);
        }
        // Destination file path
        $destination = $thumbnailDir . '/' . $filename;

        // Copy only if file does not already exist
        if (!file_exists($destination)) {
            // Stories
            // Image::make($source)->resize(400, null, function ($constraint) {
            //     $constraint->aspectRatio();
            //     $constraint->upsize();
            // })->save($destination, 80);
            // Profiles
            Image::make($source)->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destination, 80);
            try {
                Source::fromFile($destination)->toFile($destination);
            } catch (\Exception $e) {
                Log::warning('TinyPNG failed: ' . $e->getMessage());
            }
        }
        // $updated = Story::where('id', $id)->update([
        //     'thumbnail' => $filename
        // ]);
        return file_exists($destination) ? "SUCCESS - " . $filename : null;
    }
}
