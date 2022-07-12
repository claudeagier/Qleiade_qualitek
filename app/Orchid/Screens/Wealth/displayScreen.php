<?php

namespace App\Orchid\Screens\Wealth;

use App\Models\Wealth;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Screen;

use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use App\Http\Traits\WithAttachments;

class displayScreen extends Screen
{
    use WithAttachments;
    /**
     * @var Wealth
     */
    public $wealth;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Wealth $wealth): iterable
    {
        return [
            'wealth' => $wealth
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->wealth->name;
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Cancel'))
                ->icon('action-undo')
                ->route('platform.quality.wealths')
                ->class("cancel-btn"),

            Link::make(__('Edit'))
                ->route('platform.quality.wealths.edit', $this->wealth->id)
                ->icon('pencil')
                ->canSee(Auth::user()->hasAccess('platform.quality.actions.edit'))
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::view(
                'components.admin.wealth.show.wealth',
                [
                    'wealth' => $this->wealth,
                    'emptyAttachments' => $this->isEmptyAttachments($this->wealth->attachment)
                ]
            )
        ];
    }
}
