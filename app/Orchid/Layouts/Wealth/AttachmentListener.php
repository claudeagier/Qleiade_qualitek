<?php

namespace App\Orchid\Layouts\Wealth;

use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Sight;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use App\Orchid\Layouts\Attachment\File\UploadLayout;
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
        $uploadFile = new UploadLayout();

        $showFile =  [
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
            Sight::make(__('original_name')),
            Sight::make(__('mime_type')),
            Sight::make(__('gdrive_shared_link'))->render(function () {
                $link = $this->query['wealth']->file->gdrive_shared_link;
                return Link::make($link)
                    ->href($link);
                // ->class('my-link');
            }),
            Sight::make(__('created_at')),
        ];
        
        $wealth = $this->query['wealth'];

        return [
            $uploadFile->title(__('file_upload'))
                ->canSee(
                    ($this->query['whoShouldSee'] === 'file') && (count($wealth->files) < 1)
                ),
            //le layout d'affichage du fichier pour le formulaire de mise à jour
            Layout::legend(
                'wealth.file',
                $showFile
            )->title(__('file_details'))
                ->canSee(($this->query['whoShouldSee'] === 'file') && ($this->query['wealth']->exists && count($this->query['wealth']->files) > 0))
        ];
    }
}
