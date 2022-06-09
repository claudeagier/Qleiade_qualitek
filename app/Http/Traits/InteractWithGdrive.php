<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Storage;

trait InteractWithGdrive {
    function getMetaData($itemId){
        //file or directory
        //error but it work
        return $metadata = Storage::cloud()->getAdapter()->getMetadata($itemId);
    }

    function put($file, $content, $config = []){
        try {
            //error but it work
            Storage::cloud()->getAdapter()->write($file, $content, $config);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return 'File was saved to Google Drive';
    }

    function lisFiles($dir){

    }
} 