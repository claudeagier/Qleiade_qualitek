<?php

namespace App\Orchid\Layouts\Wealth;

use App\Orchid\Layouts\Attachment\File\FileCard;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Sight;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use App\Orchid\Layouts\Attachment\File\UploadLayout;
use App\Orchid\Layouts\Attachment\Link\LinkEditLayout;
use App\Orchid\Layouts\Attachment\Ypareo\YpareoEditlayout;
use Orchid\Screen\Fields\Group;

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

        //File type attachment
        $uploadFile = new UploadLayout();
        $fileCard = new FileCard();

        //Link type attachment
        $linkEdit = new LinkEditLayout();

        //Ypareo type attachment
        $ypareoEdit = new YpareoEditlayout();


        return [
        //File type attachment
            //edit
            $uploadFile->title(__('file_upload'))
                ->canSee(
                    ($this->query['whoShouldSee'] === 'file') && (count($wealth->files) < 1)
                ),
            //show
            $fileCard->title(__('file_details'))
                ->canSee(($this->query['whoShouldSee'] === 'file') && ($this->query['wealth']->exists && count($this->query['wealth']->files) > 0)),
    

        // link type attachment
            //edit
            $linkEdit->title(__('link_edit'))
                ->canSee(
                    ($this->query['whoShouldSee'] === 'link')
                ),

        // Ypareo type attachment
            //edit
            $ypareoEdit->title(__('ypareo_edit'))
                ->canSee(
                    ($this->query['whoShouldSee'] === 'ypareo')
                ),
        ];
    }
}
