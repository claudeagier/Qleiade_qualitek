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
}
