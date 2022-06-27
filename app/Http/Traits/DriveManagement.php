<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


trait DriveManagement {

    public function putOnDrive(){
        return true;
    }

    public function getMetaData($itemId){
        //get drive meta data gdrive file or directory
        //error but it work
        return Storage::cloud()->getAdapter()->getMetadata($itemId);
    }

    public function formatSharedLink($path)
    {
        return "https://drive.google.com/file/d/"
            . explode('/', $path)[1] .
            "/view?usp=sharing";        
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

    public function formatUrlPart($name){
        return Str::slug($name);
    }
} 