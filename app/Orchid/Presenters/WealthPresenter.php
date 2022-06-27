<?php

namespace App\Orchid\Presenters;

use Laravel\Scout\Builder;
use Orchid\Support\Presenter;

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
    public function name()
    {
        return $this->entity->name;
    }

    public function label()
    {
        return $this->entity->label;
    }

    public function indicators()
    {
        return $this->entity->indicators;
    }

    // public function description()
    // {
    //     return $this->entity->description;
    // }

    // public function tracking()
    // {
    //     return $this->entity->tracking;
    // }

    // public function conformity_level()
    // {
    //     return $this->entity->conformity_level;
    // }
    // public function attachment()
    // {
    //     // TODO c'est du json, il faut gérer l'affichage

    //     return $this->entity->attchement;
    // }

    /**
     * @param string|null $query
     *
     * @return Builder
     */
    public function searchQuery(string $query = null): Builder
    {
        return $this->entity->search($query);
    }

    /**
     * @return int
     */
    public function perSearchShow(): int
    {
        return 20;
    }
}
