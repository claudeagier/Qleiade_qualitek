<?php

namespace App\Orchid\Layouts\Wealth;

use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Sight;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use App\Orchid\Layouts\Wealth\UploadCustomLayout;

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
        $uploadFile = new UploadCustomLayout();
        $wealth = $this->query['wealth'];

        return [
            $uploadFile->title(__('file_upload'))
                ->canSee(
                    ($this->query['whoShouldSee'] === 'file') && (count($wealth->files) < 1)
                ),
            //le layout d'affichage du fichier pour le formulaire de mise à jour
            Layout::legend(
                'wealth.file',
                [
                    Sight::make('original_name'),
                    Sight::make('mime_type'),
                    Sight::make('gdrive_shared_link')->render(function () {
                        $link = $this->query['wealth']->file->gdrive_shared_link;
                        return Link::make($link)
                            ->href($link)
                            ->class('my-link');
                    }),
                    Sight::make('created_at'),
                    Sight::make(__('actions'))->render(function () {
                        return Button::make(__('Remove'))
                        ->icon('trash')
                        ->confirm(__('confirm_delete_file'))
                        ->method('removeFile',[
                            'wealth' =>  $this->query['wealth']
                        ]);
                    })
                ]
            )
            ->title(__('file_details'))
            ->canSee(($this->query['whoShouldSee'] === 'file') && ($this->query['wealth']->exists && count($this->query['wealth']->files) > 0))
        ];
    }
}
