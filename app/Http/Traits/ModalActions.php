<?php

namespace App\Http\Traits;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Support\Facades\Toast;


trait ModalActions {
        /**
     * @param Tag    $tag
     * @param Request $request
     *
     * @return Tag $tag
     */
    public function saveTag(Tag $tag, Request $request)
    {
        //TODO : ajouter un controle de date pour la date de validité
        //TODO : ajouter un controle sur l'unicité du nom ?
        // $request->validate([
        //     'tag.conformity_level' => [
        //         'numeric',
        //         'min:0',
        //         'max:100'
        //     ],
        //     "tag.processus" =>"required"
        // ]);

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
    public function removeTag(Tag $tag) :void
    {
        $tag->delete();

        Toast::success(__('Tag_was_removed'));
    }
}