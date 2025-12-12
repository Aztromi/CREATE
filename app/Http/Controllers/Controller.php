<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Str;

use App\Models\Slug;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function slugHandler($class, $ownerInst, $value, $process)
    {
        $baseSlug = Str::slug($value);
        $checkExist = Slug::where([
            ['ownerable_type', '=', $class],
            ['value', '=', $baseSlug]
        ])->first();

        if ($process == 'add') {
            $slug = $checkExist
                ? $this->slugGenerator($class, $baseSlug)
                : $baseSlug;

            $ownerInst->slugs()->create([
                'value' => $slug
            ]);
        }
        else if ($process == 'edit') {
            $slug = '';

            if ($checkExist) {
                if ($checkExist->ownerable_id == $ownerInst->id) {
                    $checkExist->touch(); // update timestamp
                    return;
                } else {
                    $slug = $this->slugGenerator($class, $baseSlug);
                }
            } else {
                $slug = $baseSlug;
            }

            if (!empty($slug)) {
                $ownerInst->slugs()->create([
                    'value' => $slug
                ]);
            }
        }
    }

    public function slugGenerator($class, $baseSlug){
        $suffix = 0;
        $uniqueSlug = $baseSlug;

        do{
            $currentSlug = $suffix > 0 ? $baseSlug . '-' . str_pad($suffix, 2, '0', STR_PAD_LEFT) : $baseSlug;

            $exists = Slug::where([
                ['value', '=', $currentSlug],
                ['ownerable_type', '=', $class],
            ])->exists();

            if($exists){
                $suffix++;
            }
            else{
                $uniqueSlug = $currentSlug;
            }

        } while($exists);

        return $uniqueSlug;
    }
}
