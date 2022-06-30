<?php

namespace App\Orchid\Presenters;

use Laravel\Scout\Builder;
use Orchid\Support\Presenter;
// use Orchid\Screen\Contracts\Searchable;

class WealthPresenter extends Presenter
{
    // 'name',
    // 'description',
    // //suivi de la preuve
    // 'tracking',
    // // 0 a 99
    // 'conformity_level',
    // 'validity_date',
    // // json les visuelles de la preuve file, link, ypareo
    // 'attachment',
    /**
     * @return string
     */
    public function label(): string
    {
        return "Wealths";
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->entity->name;
    }

    /**
     * @return string
     */
    public function subTitle(): string
    {
        return $this->entity->description;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return "";
    }

    /**
     * @return string
     */
    public function image(): ?string
    {
        return "";
    }

    public function name()
    {
        return $this->entity->name;
    }

    public function indicators()
    {
        return $this->entity->indicators;
    }

    /**
     * Modify the query used to retrieve models when making all of the models searchable.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function makeAllSearchableUsing($query)
    {
        //         SELECT * FROM `wealth` 
        // INNER JOIN wealths_indicators
        // ON wealth.id = wealths_indicators.wealth_id
        // INNER JOIN indicator
        // ON wealths_indicators.indicator_id = indicator.id
        // INNER join quality_label
        // ON indicator.quality_label_id = quality_label.id
        return $query->with('indicators');
    }

    /**
     * @param string|null $query
     *
     * @return Builder
     */
    public function searchQuery(string $a_query = null): Builder
    {
        $myquery = $this->entity->search($a_query)
        ->query(function ($query){return $query->with('indicators');})
        ->orderBy('created_at', "asc");
        // dd($query);
        return $myquery;
    }

    /**
     * @return int
     */
    public function perSearchShow(): int
    {
        return 20;
    }
}
