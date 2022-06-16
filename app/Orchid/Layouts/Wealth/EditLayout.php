<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Wealth;

use App\Models\WealthType;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Fields\Relation;

class EditLayout extends Rows
{
    /**
    * Data source.
    *
    * @var string
    */
   public $target = 'wealth';

    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('wealth.id')
                ->hidden(),
            Input::make('wealth.name')
                ->title(__('wealth_name'))
                ->placeholder('proof_toto')
                ->required()
                ->help(__('wealth_name_help')),

            DateTimer::make('wealth.validity_date')
                ->title(__('wealth_validity_date'))
                ->required()
                ->allowInput()
                ->format('d-m-Y'),

            Input::make('wealth.conformity_level')
                ->title(__('wealth_conformity_level')),

            Relation::make('wealth.wealth_type')
                ->fromModel(WealthType::class, 'name', 'id')
                // ->fromQuery(User::where('balance', '!=', '0'), 'email')
                ->title(__('wealth_type_select_title'))
                ->required(),

            SimpleMDE::make('wealth.description')
                ->title('Description')
                ->popover("Soyez concis s'il vous plait"),
        ];
    }
}
