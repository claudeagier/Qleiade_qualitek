<?php

namespace App\Orchid\Layouts\Attachment\File;

use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Sight;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;

class FileCardLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return  [
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
                                "action" => "logic"
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
    }
}
