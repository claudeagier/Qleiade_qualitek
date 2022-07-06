<?php

namespace App\Http\Traits;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Support\Facades\Toast;


trait ModalActions
{
    /**
     * @param Tag    $tag
     * @param Request $request
     *
     * @return Tag $tag
     */
    public function saveTag(Tag $tag, Request $request)
    {
        $request->validate([
            'tag.label' => "required|regex:/^[a-zA-Z0-9\s]+$/"
        ]);

        //Datas from request
        $tagData = $request->all('tag')['tag'];
        // format name code

        $tagData["name"] = Str::slug($tagData["label"]);

        //Create Tag model
        $tag->fill($tagData)
            ->save();

        Toast::success(__('Tag_was_saved'));

        return $tag;
    }

    /**
     * @param Tag $tag
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function removeTag(Tag $tag): void
    {
        $tag->delete();

        Toast::success(__('Tag_was_removed'));
    }
}
