<?php

namespace App\Orchid\Screens\Search;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Models\Wealth;

use Orchid\Screen\Actions\Link;
use Orchid\Support\Color;

class ResultScreen extends Screen
{
        /**
     * @var Wealth
     */
    public $wealths;

    /**
     * Query data.
     *
     * @return array
     */
    public function query($payload): iterable
    {
        $needs = [];
        //convert query string to array
        parse_str($payload, $needs);

        if (isset($needs['key_word'])) {
            $keyWord = $needs['key_word'];
        }
        
        try {
        // Search with scout
        $this->wealths = Wealth::search($keyWord)
        ->query(
                function ($query) use ($needs) {
                    return $this->fillWealthQuery($query, $needs);
                }
            )->get();
        } catch (\Throwable $th) {
            //TODO : j'en fais quoi de mon erreur ?
            throw $th;
        }

        return [
            "wealths" => $this->wealths,
            "needs" => $keyWord
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('result_screen_title');
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

            Link::make(__('Search'))
                ->type(Color::LIGHT())
                ->icon('magnifier')
                ->route('platform.quality.search'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        //TODO : ajouter une pop up dans le template pour afficher le niveau de preuve sur la jauge
        return [
            Layout::view(
                'components.admin.wealth.show.list'
            )
        ];
    }
    
    /**
     * fillWealthQuery
     *
     * @param  mixed $query
     * @param  mixed $payload
     * @return void
     */
    protected function fillWealthQuery($query, $payload)
    {
        $keyWord = $payload['key_word'];

        // TODO : complete request
        // if (isset($payload['tags']) && is_array($payload['tags'])) {
        //     $tagIds = $payload['tags'];
        // } 

        // pour le recherche avec eloquent remplacer $query->with... par Wealth::with ...
        $query->with(['indicators', 'tags', 'actions', 'wealthType', 'processus'])
            ->where('name', 'like', '%' . $keyWord . '%')
            ->orWhere(function ($query) use ($keyWord) {
                $query->whereHas('indicators', function ($q) use ($keyWord) {
                    $q
                        ->join('quality_label', 'quality_label_id', '=', 'quality_label.id')
                        ->where('indicator.label', 'like', '%' . $keyWord . '%')
                        ->orWhere('quality_label.label', 'like', '%' . $keyWord . '%');
                });
            })
            ->orWhere(function ($query) use ($keyWord) {
                $query->with('tags')->whereHas('tags', function ($q) use ($keyWord) {
                    $q->where('label', 'like', '%' . $keyWord . '%');
                });
            })
            ->orWhere(function ($query) use ($keyWord) {
                $query->with('processus')->whereHas('processus', function ($q) use ($keyWord) {
                    $q->where('label', 'like', '%' . $keyWord . '%')
                        ->orWhere('name', 'like', '%' . $keyWord . '%');
                });
            })
            ->orWhere(function ($query) use ($keyWord) {
                $query->whereHas('actions', function ($q) use ($keyWord) {
                    $q
                        ->join('stage', 'stage_id', '=', 'stage.id')
                        ->where('action.label', 'like', '%' . $keyWord . '%')
                        ->orWhere('action.name', 'like', '%' . $keyWord . '%')
                        ->orWhere('stage.label', 'like', '%' . $keyWord . '%')
                        ->orWhere('stage.name', 'like', '%' . $keyWord . '%');
                });
            });

        return $query;
    }
}
