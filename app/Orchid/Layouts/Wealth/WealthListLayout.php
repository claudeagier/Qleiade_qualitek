<?php

namespace App\Orchid\Layouts\Wealth;

use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use App\Models\Wealth;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;

class WealthListLayout extends Table
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
            TD::make( __('name'))
            ->sort()
            ->render(function (Wealth $wealth) {
                return $wealth->name;
            }),
            TD::make('Description', __('wealth_description'))
            ->sort()
            ->render(function (Wealth $wealth) {
                return $wealth->description;
            }),
            TD::make('updated_at', __('Last edit'))
                ->sort()
                ->render(function (Wealth $wealth) {
                    return $wealth->updated_at->toDateTimeString();
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
                                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                                ->method('remove',[
                                    'id'=>$wealth->id,
                                ]),
                        ]);
                }),
            ];
    }
}
