<?php

namespace App\Orchid\Layouts\Wealth;

use App\Models\Indicator;
use App\Models\Processus;
use App\Models\Career;
use App\Models\Action;
use App\Models\Formation;

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
                ->fromModel(Indicator::class, 'name')
                ->multiple()
                ->required()
                ->title(__('indicator_select_title')),

            Relation::make('wealth.processus')
                ->fromModel(Processus::class, 'name')
                ->required()
                ->title(__('processus_select_title')),

            Relation::make('wealth.careers')
                ->fromModel(Career::class, 'name')
                ->multiple()
                ->required()
                ->popover("Ex.: cap 3 ans")
                ->title(__('career_select_title')),
                
            Relation::make('wealth.actions')
                ->fromModel(Action::class, 'name')
                ->multiple()
                ->required()

                ->title(__('action_select_title')),


            Relation::make('wealth.formations')
                ->fromModel(Formation::class, 'name')
                ->multiple()
                ->title(__('formation_select_title')),
        ];
    }
}
