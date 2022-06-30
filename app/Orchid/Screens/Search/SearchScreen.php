<?php

namespace App\Orchid\Screens\Search;

use App\Models\Tag;
use Illuminate\Http\Request;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Color;
use Illuminate\Support\Arr;
use Orchid\Screen\Fields\Relation;

class SearchScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('search_screen_title');
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return __('search_screen_description');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Home'))
                ->icon('home')
                ->route('platform.dashboard'),
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
            Layout::columns([
                Layout::rows(
                    [
                        Input::make('search.key_word', __('Key word'))->title(__('search_input')),

                        // TODO : Add fields to custom search form
                        // Relation::make('search.tags')
                        //     ->fromModel(Tag::class, 'label')
                        //     ->multiple()
                        //     ->chunk(50)
                        //     ->popover("Ex.: cap 3 ans")
                        //     ->title(__('tag_select_title')),

                        Button::make('Search', __('Search'))
                            ->type(Color::LIGHT())
                            ->icon('magnifier')
                            ->method('search')
                    ]
                )->title(__('Search')),
            ])
        ];
    }

    public function search(Request $request)
    {
        //FIXME : search values request validations
        $request->validate([
            'search.key_word' => 'required|string'
        ]);

        $payload =  $request->all()['search'];
        $queryString = Arr::query($payload);

        return redirect()->route('platform.quality.search.result', ['wealths' => $queryString]);
    }
}
