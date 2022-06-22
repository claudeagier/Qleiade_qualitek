<?php

namespace App\Orchid\Layouts\Wealth;

use App\Orchid\Layouts\Attachment\File\FileCard;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use App\Orchid\Layouts\Attachment\File\UploadLayout;
use App\Orchid\Layouts\Attachment\Link\LinkCard;
use App\Orchid\Layouts\Attachment\Ypareo\YpareoCard;
use App\Orchid\Layouts\Attachment\Link\LinkEditLayout;
use App\Orchid\Layouts\Attachment\Ypareo\YpareoEditlayout;

class AttachmentListener extends Listener
{
    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = ['wealth.wealth_type', 'wealth.id'];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = 'asyncCansee';

    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {

        $wealth = $this->query['wealth'];
        $whoShouldSee = $this->query['whoShouldSee'];


        //File type attachment
        $uploadFile = new UploadLayout();
        $fileCard = new FileCard();

        //Link type attachment
        $linkEdit = new LinkEditLayout();
        $linkCard = new LinkCard();

        //Ypareo type attachment
        $ypareoEdit = new YpareoEditlayout();
        $ypareoCard = new YpareoCard();

        return [
            //File type attachment
            //edit
            $uploadFile->title(__('file_upload'))
                ->canSee(
                    ($whoShouldSee === 'file') && (count($wealth->files) < 1)
                ),
            //show
            $fileCard->title(__('file_show'))
                ->canSee(
                    ($whoShouldSee === 'file')
                        &&
                        ($wealth->exists && count($wealth->files) > 0)
                ),

            // link type attachment
            //edit
            $linkEdit->title(__('link_edit'))
                ->canSee(
                    ($whoShouldSee === 'link')
                        &&
                        $this->editAttachment($this->query)
                ),
            // show
            $linkCard->title(__('link_show'))
                ->canSee(
                    ($whoShouldSee === 'link')
                        &&
                        ($wealth->exists && !$this->editAttachment($this->query))
                ),

            // Ypareo type attachment
            //edit  
            $ypareoEdit->title(__('ypareo_edit'))
                ->canSee(
                    ($this->query['whoShouldSee'] === 'ypareo')
                        &&
                        $this->editAttachment($this->query)
                ),
            //show
            $ypareoCard->title(__('ypareo_show'))
                ->canSee(
                    ($whoShouldSee === 'ypareo')
                        &&
                        ($wealth->exists && !$this->editAttachment($this->query))
                ),
        ];
    }

    protected function isEmptyAttachment($attachment)
    {
        $isEmpty = true;         
        foreach ($attachment as $value) {
            if (is_null($value)) {
                $isEmpty = true;
            } else {
                return false;
            }
        }
        return $isEmpty;
    }

    protected function editAttachment($query): bool
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
