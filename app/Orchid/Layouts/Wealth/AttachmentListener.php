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
            // $this->fileLegend(),
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

    protected function fileLegend()
    {
        return Layout::legend(
            'wealth.file',
            [
                Sight::make(__('actions'))->render(function () {
                    return Group::make(
                        [
                            Button::make(__('file_archive'))
                                ->icon('database')
                                ->confirm(__('confirm_archive_file'))
                                ->method('removeFile', [
                                    'wealth' =>  $this->query['wealth'],
                                    'action' => "archive"
                                ]),

                            Button::make(__('remove_db'))
                                ->icon('trash')
                                ->confirm(__('confirm_delete_db_file'))
                                ->method('removeFile', [
                                    'wealth' =>  $this->query['wealth'],
                                    "action" => "logical"
                                ])->right(),

                            Button::make(__('remove_drive'))
                                ->icon('trash')
                                ->confirm(__('confirm_delete_file'))
                                ->method('removeFile', [
                                    'wealth' =>  $this->query['wealth'],
                                    'action' => 'eradicate'
                                ]),
                        ]
                    );
                }),
                Sight::make('original_name', __('original_name')),
                Sight::make('mime_type', __('mime_type')),
                Sight::make('gdrive_shared_link', __('gdrive_shared_link'))->render(function () {
                    $link = $this->query['wealth']->file->gdrive_shared_link;
                    return Link::make($link)
                        ->href($link);
                    // ->class('my-link');
                }),
                Sight::make('created_at', __('created_at')),
            ]
        )->title(__('file_details'))
            ->canSee(($this->query['whoShouldSee'] === 'file') && ($this->query['wealth']->exists && count($this->query['wealth']->files) > 0));
    }
}
