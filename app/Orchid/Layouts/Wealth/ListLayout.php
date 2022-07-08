<?php

namespace App\Orchid\Layouts\Wealth;

use Illuminate\Support\Facades\Auth;

use App\Models\Wealth;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;

use function PHPUnit\Framework\isNull;

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
                    return view('components.admin.tools.colorized_table_row', [
                        'value' => $wealth->name,
                        'conformityLevel' => $wealth->conformity_level,
                        'emptyAttachment' => !(count($wealth->files) > 0 || !$this->isEmptyAttachment($wealth->attachment)),
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
                    return count($wealth->files) > 0 || !$this->isEmptyAttachment($wealth->attachment);
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
                            Button::make(__('Display'))
                                ->icon('eye')
                                ->method('display', [
                                    'id' => $wealth->id,
                                ]),

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

    public static function isEmptyAttachment($attachments)
    {
        // dd($attachments);
        $isEmpty = true;
        if (!isset($attachments)) {
            return true;
        }
        foreach ($attachments as $attachment) {
            // dd($attachment);
            foreach ($attachment as $key => $value) {
                if (is_null($value)) {
                    $isEmpty = true;
                } else {
                    return false;
                }
            }
        }
        return $isEmpty;
    }
}
