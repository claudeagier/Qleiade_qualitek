<?php

namespace App\Orchid\Layouts\Wealth;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class UploadCustomLayout extends Rows
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
            Input::make('wealth.file')
                ->type('file'),
            // Button::make(__('Save File'))
            //     ->icon('check')
            //     ->method('saveFile'),
        ];
    }
}
