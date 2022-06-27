<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Indicator extends Model
{
    use HasFactory;
    use AsSource;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'indicator';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'label',
        'description',
        //numéro indicateur 1 à 37
        'indicater_number',
        //numéro critère 1 à 7
        'criteria_number',
        'conformity_level'
    ];

    public function wealths()
    {
        return $this->belongsToMany(
            Wealth::class,
            "wealths_indicators",
            "indicator_id",
            "wealth_id"
        );
    }

    public function qualityLabel()
    {
        return $this->belongsTo(QualityLabel::class);
    }

        /**
     * @return string
     */
    public function getFullAttribute(): string
    {
        return $this->attributes['criteria_number'] . '.' . $this->attributes['indicater_number'] . " . " . $this->attributes['label'];
    }
}
