<?php

namespace App\Orchid\Layouts\Wealth;

use Illuminate\Support\Facades\Auth;

use App\Models\Wealth;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class ListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'wealths';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            //TODO : afficher en rouge quand les infos de la piece jointe ne sont pas renseignés
            TD::make(__('name'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return view('components.admin.tools.conformity-colorized', [
                        'value' => $wealth->name,
                        'conformityLevel' => $wealth->conformity_level
                    ]);
                }),

            TD::make('Processus', __('wealth_processus'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return view('components.admin.tools.conformity-colorized', [
                        'value' => $wealth->processus->label,
                        'conformityLevel' => $wealth->conformity_level
                    ]);
                }),

            TD::make('conformity_level', __('wealth_conformity_level'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return view('components.admin.tools.conformity-colorized', [
                        'value' => $wealth->conformity_level,
                        'conformityLevel' => $wealth->conformity_level
                    ]);
                }),

            TD::make(__('wealth_type'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return view('components.admin.tools.conformity-colorized', [
                        'value' => $wealth->wealthType->name,
                        'conformityLevel' => $wealth->conformity_level
                    ]);
                }),

            TD::make('has visual', __('has_visual'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return count($wealth->files) > 0 || !is_null($wealth->attachment);
                }),

            TD::make('validity_date', __('wealth_validity_date'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return view('components.admin.tools.conformity-colorized', [
                        'value' => $wealth->validity_date,
                        'conformityLevel' => $wealth->conformity_level
                    ]);
                }),

            TD::make('updated_at', __('Last edit'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return view('components.admin.tools.conformity-colorized', [
                        'value' => $wealth->updated_at,
                        'conformityLevel' => $wealth->conformity_level
                    ]);
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Wealth $wealth) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.quality.wealths.edit', $wealth->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('wealth_remove_confirmation'))
                                ->method('remove', [
                                    'id' => $wealth->id,
                                ]),
                        ])
                        ->canSee(Auth::user()->hasAccess('platform.quality.wealths.edit'));
                }),
        ];
    }
}
