<?php

namespace App\Orchid\Layouts\Wealth;

use App\Models\Tag;
use App\Models\Action;
use App\Models\Indicator;
use App\Models\Processus;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Actions\ModalToggle;

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
                ->chunk(50)
                ->title(__('indicator_select_title')),

            Relation::make('wealth.processus')
                ->fromModel(Processus::class, 'label')
                ->required()
                ->chunk(50)
                ->title(__('processus_select_title')),

            Group::make([
                Relation::make('wealth.tags')
                    ->fromModel(Tag::class, 'label')
                    ->multiple()
                    ->chunk(50)
                    ->popover("Ex.: cap 3 ans")
                    ->title(__('tag_select_title')),
                    
                ModalToggle::make(__('add new tag'))
                    ->modal('addTagModal')
                    ->icon('plus')
                    ->class('btn btn-outline-secondary mt-4')
                    ->method('addNewTagByModal'),

                ])->fullWidth()
                ->set('align', ''),
                
            Relation::make('wealth.actions')
                ->fromModel(Action::class, 'label')
                ->multiple()
                ->chunk(50)
                ->title(__('action_select_title')),
        ];
    }
}
