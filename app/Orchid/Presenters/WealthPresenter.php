<?php

namespace App\Orchid\Presenters;

use Laravel\Scout\Builder;
use Orchid\Support\Presenter;
// use Orchid\Screen\Contracts\Searchable;

//not used
class WealthPresenter extends Presenter
{
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
