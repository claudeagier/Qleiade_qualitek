<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Laravel\Scout\Searchable;

use Orchid\Screen\AsSource;

use App\Orchid\Presenters\WealthPresenter;

class Wealth extends Model
{
    use HasFactory, AsSource, Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wealth';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        //suivi de la preuve
        'tracking',
        // 0 a 99
        'conformity_level',
        'validity_date',
        // json les visuelles de la preuve file, link, ypareo
        'attachment',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'validity_date' => 'datetime',
        'attachment' => 'array'
    ];

    public function actions()
    {
        return $this->belongsToMany(
            Action::class,
            "wealths_actions",
            "wealth_id",
            "action_id"
        );
    }

    public function wealthType()
    {
        return $this->belongsTo(WealthType::class);
    }

    public function indicators()
    {
        return $this->belongsToMany(
            Indicator::class,
            "wealths_indicators",
            "wealth_id",
            "indicator_id"
        );
    }

    public function files()
    {
        return $this->belongsToMany(
            File::class,
            "wealths_files",
            "wealth_id",
            "file_id"
        );
    }

    public function processus()
    {
        return $this->belongsTo(Processus::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            "wealths_tags",
            "wealth_id",
            "tag_id"
        );
    }

    /**
     * Get the presenter for the model.
     *
     * @return WealthPresenter
     */
    public function presenter()
    {
        return new WealthPresenter($this);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        
        // Customize array...
        $array['name'] = $this->name;
        $array['description'] = $this->description;


        return $array;
    }
}
