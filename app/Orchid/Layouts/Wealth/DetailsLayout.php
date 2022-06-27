<?php

namespace App\Orchid\Layouts\Wealth;

use App\Models\Indicator;
use App\Models\Processus;
use App\Models\Tag;
use App\Models\Action;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Relation;

class DetailsLayout extends Rows
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
            Relation::make('wealth.indicators')
                ->fromModel(Indicator::class, 'label')
                ->displayAppend('full')
                ->multiple()
                ->required()
                ->title(__('indicator_select_title')),

            Relation::make('wealth.processus')
                ->fromModel(Processus::class, 'label')
                ->required()
                ->title(__('processus_select_title')),

            Relation::make('wealth.tags')
                ->fromModel(Tag::class, 'label')
                ->multiple()
                ->popover("Ex.: cap 3 ans")
                ->title(__('tag_select_title')),
                
            Relation::make('wealth.actions')
                ->fromModel(Action::class, 'label')
                ->multiple()
                ->title(__('action_select_title')),
        ];
    }
}
