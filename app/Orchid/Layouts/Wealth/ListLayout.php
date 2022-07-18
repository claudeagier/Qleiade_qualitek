<?php

namespace App\Orchid\Layouts\Wealth;

use Illuminate\Support\Facades\Auth;

use App\Models\Wealth;
use App\Http\Traits\WithAttachments;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

class ListLayout extends Table
{
    use WithAttachments;
    
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

            TD::make(__('name'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return view('components.admin.tools.colorized_table_row', [
                        'value' => $wealth->name,
                        'conformityLevel' => $wealth->conformity_level,
                        'emptyAttachment' => !(count($wealth->files) > 0 || !$this->isEmptyAttachments($wealth->attachment)),
                    ]);
                }),

            TD::make('Processus', __('wealth_processus'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return $wealth->processus->label;
                }),

            TD::make('conformity_level', __('wealth_conformity_level'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return $wealth->conformity_level;
                }),

            TD::make(__('wealth_type'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return $wealth->wealthType->name;
                }),

            TD::make('has visual', __('has_visual'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return count($wealth->files) > 0 || !$this->isEmptyAttachments($wealth->attachment);
                }),

            TD::make('validity_date', __('wealth_validity_date'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return $wealth->validity_date;
                }),

            TD::make('updated_at', __('Last edit'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return $wealth->updated_at;
                }),

            TD::make(__('Actions_form'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Wealth $wealth) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Display'))
                                ->icon('eye')
                                ->route('platform.quality.wealths.display', $wealth->id),

                            Link::make(__('Edit'))
                                ->route('platform.quality.wealths.edit', $wealth->id)
                                ->icon('pencil')
                                ->canSee(Auth::user()->hasAccess('platform.quality.wealths.edit')),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('wealth_remove_confirmation'))
                                ->method('remove', [
                                    'id' => $wealth->id,
                                ])
                                ->canSee(Auth::user()->hasAccess('platform.quality.wealths.edit')),
                        ]);
                }),
        ];
    }
}
