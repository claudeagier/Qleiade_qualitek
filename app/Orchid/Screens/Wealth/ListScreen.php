<?php

namespace App\Orchid\Screens\Wealth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Wealth;
use App\Orchid\Layouts\Wealth\ListLayout;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Toast;


class ListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'wealths' => Wealth::all()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('wealths');
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return __('wealths_list_description');
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.quality.wealths',
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.quality.wealths.create')
                //it works
                ->canSee(Auth::user()->hasAccess('platform.quality.wealths.create')),
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
            ListLayout::class
        ];
    }

       
    /**
     * remove
     *
     * @param  Request $request
     * @return void
     */
    public function remove(Request $request): void
    {
        $wealth = Wealth::findOrFail($request->get('id'));

        $wealth->actions()->detach();
        $wealth->tags()->detach();
        $wealth->indicators()->detach();

        $wealth->delete();
        Toast::info(__('Wealth_was_removed'));
    }
}
