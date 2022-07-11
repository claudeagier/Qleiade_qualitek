<?php

namespace App\Http\Traits;

use Illuminate\Support\Collection;

/**
 * util functions to manage attachments
 */
trait WithAttachments{
            
    /**
     * 
     * return true if only one of fields are null
     * 
     * @param  array $attachments
     * @return bool
     */
    public function isEmptyAttachment(array $attachments): bool
    {
        $isEmpty = true;
        if (!isset($attachments)) {
            return true;
        }
        foreach ($attachments as $attachment) {
            // dd($attachment);
            foreach ($attachment as $key => $value) {
                if (is_null($value)) {
                    $isEmpty = true;
                } else {
                    return false;
                }
            }
        }
        return $isEmpty;
    }
    
        
    /**
     * 
     * return true if editable
     * 
     * @param  array $query
     * @return bool
     */
    public function editAttachment(array $query): bool
    {
        $edit = true;
        if (isset($query['attachment'])) {
            foreach ($query['attachment'] as $attachment) {
                if ($this->isEmptyAttachment($attachment)) {
                    $edit = true;
                } else {
                    $edit = false;
                }
            }
        } else {
            $edit = true;
        }

        return $edit;
    }
}