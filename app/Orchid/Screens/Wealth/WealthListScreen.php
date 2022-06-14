<?php

namespace App\Orchid\Screens\Wealth;

use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use App\Models\Wealth;
use App\Orchid\Layouts\Wealth\ListLayout;
use Illuminate\Http\Request;

class WealthListScreen extends Screen
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
                ->route('platform.quality.wealths.create'),
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
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        $wealth = Wealth::findOrFail($request->get('id'));

        $wealth->formations()->detach();
        $wealth->actions()->detach();
        $wealth->careers()->detach();
        $wealth->indicators()->detach();

        $wealth->delete();
        Toast::info(__('Wealth_was_removed'));
    }
}
