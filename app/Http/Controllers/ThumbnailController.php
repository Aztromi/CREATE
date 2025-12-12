<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use App\Models\Article;
use App\Models\Story;

class ThumbnailController extends Controller
{
    public function index()
    {
        $stories = Story::with([
            'user',
            'slugs',
        ])->paginate(100);
        return view('admin.thumbnail.thumbnailmaker', ['stories' => $stories]);
    }

    public function updateThumbnails(Request $request)
    {
        $ids = $request->ids;
        Story::whereIn('id', $ids)->update([
            'thumbnail' => 'new-thumbnail.jpg'
        ]);
        return back()->with('success', 'Thumbnail updated!');
    }

    public function validateAndSave(Request $request)
    {

        $article_id = $request->input('article_id', '');
        $toEdit = $article_id == '' ? false : true;
        $updateMasthead = $toEdit == false ? true : ($request->input('masthead-change') == 1 ? true : false);

        if ($response = $this->validateForm($request, $updateMasthead)) {
            return $response;
        }

        $title = trim($request->input('title'));
        $subheader = trim($request->input('subheader')) ?: null;
        $banner_caption = trim($request->input('banner_caption')) ?: null;
        $author = trim($request->input('author')) ?: null;
        $article_content = trim($request->input('article-content'));
        $publish = $request->has('publish') && $request->input('publish') == 'on' ? "published" : "draft";
        $feature = $request->has('feature') && $request->input('feature') == 'on' ? 1 : 0;
        $industry = 7; //filler
        $tags = $request->input('cField', []);

        if ($toEdit) {
            //UPDATE
            $article = Article::find($article_id);

            $publish_date = $request->has('publish') && $article->date == null ? Carbon::today()->toDateString() : $article->date;

            $article->update([
                'name' => $title,
                'subheader' => $subheader,
                'date' => $publish_date,
                'featured' => $feature,
                'published' => $publish,
                'content' => $article_content,
                'banner_caption' => $banner_caption,
                'author' => $author,
                'industry' => $industry
            ]);

            $this->slugHandler(Article::class, $article, $title, 'edit');
        } else {
            //ADD
            $publish_date = $request->has('publish') ? Carbon::today()->toDateString() : null;

            $article = Article::create([
                'name' => $title,
                'subheader' => $subheader,
                'date' => $publish_date,
                'featured' => $feature,
                'published' => $publish,
                'content' => $article_content,
                'banner_caption' => $banner_caption,
                'author' => $author,
                'industry' => $industry
            ]);

            $this->slugHandler(Article::class, $article, $title, 'add');
        }

        $article->tags()->delete();

        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $val = explode("||", $tag);

                $article->tags()->create([
                    'category' => $val[0] ?? '',
                    'name' => $val[1] ?? '',
                    'type' => 'tag'
                ]);
            }
        }

        if ($updateMasthead) {
            $image = $request->file('masthead');

            $filename = $this->storeImage($image, 'articles_content', 1200, 1200);
            $filename_md = $this->storeImage($image, 'articles_content', 800, 800);
            $filename_sm = $this->storeImage($image, 'articles_content', 400, 400);

            $existingAsset = $article->asset;

            if ($existingAsset) {
                if (Storage::exists("articles_content/" . $existingAsset->path)) {
                    Storage::delete("articles_content/" . $existingAsset->path);
                }

                if (Storage::exists("articles_content/" . $existingAsset->medium_thumbnail)) {
                    Storage::delete("articles_content/" . $existingAsset->medium_thumbnail);
                }

                if (Storage::exists("articles_content/" . $existingAsset->small_thumbnail)) {
                    Storage::delete("articles_content/" . $existingAsset->small_thumbnail);
                }
            }

            $article->asset()->updateOrCreate([], [
                'path' => $filename,
                'medium_thumbnail' => $filename_md,
                'small_thumbnail' => $filename_sm,
                'type' => 'image',
                'source' => 'admin',
                'name' => 'Banner',
            ]);
        }



        return response()->json(['validated' => true, 'urlRedirect' => route('admin.article-list')], 200);
    }

    private function validateForm($request, $masthead_check)
    {
        $rules = [
            'title' => 'required|string|max:200',
            'subheader' => 'nullable|string|max:200',
            'banner_caption' => 'nullable|string|max:200',
            'author' => 'nullable|string|max:200',
            'article-content' => 'required|string',
            'publish' => 'nullable|in:on',
            'feature' => 'nullable|in:on',

            'cField' => 'required|array',
            // 'cField.*.category' => 'required|string|max:255',
            // 'cField.*.name' => 'required|string|max:255',
        ];

        $messages = [
            'title.required' => 'Required field. ',
            'title.string' => 'Only text values are allowed. ',
            'title.max' => 'Value has exceeded the limit. ',

            'subheader.string' => 'Only text values are allowed. ',
            'subheader.max' => 'Value has exceeded the limit. ',

            'banner_caption.string' => 'Only text values are allowed. ',
            'banner_caption.max' => 'Value has exceeded the limit. ',

            'author.string' => 'Only text values are allowed. ',
            'author.max' => 'Value has exceeded the limit. ',

            'article-content.required' => 'Required field. ',
            'article-content.string' => 'Only text values are allowed. ',

            'cField.required' => 'Please provide at least one category entry.',
            'cField.array' => 'The category entries must be submitted as an array.',
            // 'cField.*.category.required' => 'Each entry must have a category.',
            // 'cField.*.category.string' => 'The category must be a valid text.',
            // 'cField.*.category.max' => 'The category must not exceed 255 characters.',
            // 'cField.*.name.required' => 'Each entry must have a name.',
            // 'cField.*.name.string' => 'The name must be a valid text.',
            // 'cField.*.name.max' => 'The name must not exceed 255 characters.',
        ];

        if ($masthead_check) {
            $rules['masthead'] = 'required|image|mimes:jpeg,png,jpg';

            $messages += [
                'masthead.required' => 'Image is required.',
                'masthead.image' => 'The uploaded file must be an image.',
                'masthead.mimes' => 'The image must be of type: jpeg, png, jpg.',
            ];
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['validated' => false, 'errors' => $validator->errors()], 422);
        }

        return null;
    }

    public function storeImage($image, $path, $maxWidth, $maxHeight)
    {

        $img = Image::make($image->getRealPath());

        if ($img->width() > $maxWidth) {
            $img->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize(); // Prevent upsizing
            });
        }

        if ($img->height() > $maxHeight) {
            $img->crop($img->width(), $maxHeight);
        }

        $baseFilename = md5(time());
        $randomString = Str::random(3); // Generate a random 3-character string
        $filename = "{$baseFilename}{$randomString}." . $image->getClientOriginalExtension();

        Storage::put("{$path}/{$filename}", (string) $img->encode());

        return $filename;
    }
}
