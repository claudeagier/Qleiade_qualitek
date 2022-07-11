<?php

namespace App\Http\Traits;

use Illuminate\Support\Collection;

/**
 * util functions to manage attachments
 */
trait WithAttachments
{

    /**
     * 
     * return true if only one of fields are null
     * 
     * @param  mixed $attachments
     * @return bool
     */
    public function isEmptyAttachments($attachments): bool
    {

        $isEmpty = true;
        if (!isset($attachments)) {
            return true;
        }
        // dd($attachments);
        foreach ($attachments as $attachment) {
            if (!isset($attachment)) {
                return true;
            }
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
     * @param  mixed $query
     * @return bool
     */
    public function editAttachment($query): bool
    {
        $edit = true;
        if (isset($query['attachment'])) {
            if ($this->isEmptyAttachments($query['attachment'])) {
                $edit = true;
            } else {
                $edit = false;
            }
        } else {
            $edit = true;
        }

        return $edit;
    }
}
