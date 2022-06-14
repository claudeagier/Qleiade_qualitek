<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use App\Models\FileModel;
use App\Models\Wealth;
use Illuminate\Support\Facades\Storage;


trait FileManagement {

    public function putOnDrive(){
        return true;
    }

    public function getMetaData($itemId){
        //get drive meta data gdrive file or directory
        //error but it work
        return Storage::cloud()->getAdapter()->getMetadata($itemId);
    }

    protected function listDirectory($dir = null){
        $nameList = [];
        // not recursive
        $idList = Storage::cloud()->directories($dir);

        foreach ($idList as $id) {
            $meta = $this->getMetaData($id);
            if($meta['type'] == 'dir'){
                $name = $meta['name'];
                $path = $meta['path'];
            }
            $nameList[$name] = $path;
        }

        return $nameList;
    }

    protected function listFilesInDirectory($dir = null){
        $nameList = [];

        // not recursive
        $idList = Storage::cloud()->files($dir);

        foreach ($idList as $id) {
            $meta = $this->getMetaData($id);
            if($meta['type'] == 'file'){
                $name = $meta['filename'];
                $path = $meta['path'];
            }
            $nameList[$name] = $path;
        }

        return $nameList;
    }

    public function getDirectoryId($name, $dir = null){
        return $this->listDirectory($dir)[$name];
    }

    public function getFileId($filename, $dir = null){
        return $this->listFilesInDirectory($dir)[$filename];
    }

    public function formatUrlPart($Name){
        return strtolower(str_replace(' ', '_', trim($Name)));
    }
} 