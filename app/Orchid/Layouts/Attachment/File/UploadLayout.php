<?php

namespace App\Orchid\Layouts\Attachment\File;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Relation;
use App\Models\File as FileModel;

class UploadLayout extends Rows
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
        return [
            Input::make('attachment.file')
                ->type('file'),
        ];
    }
}
