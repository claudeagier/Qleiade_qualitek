<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class QualityLabel extends Model
{
    use HasFactory;
    use AsSource;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'quality_label';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'label',
        'description',
    ];

    public function indicators()
    {
        return $this->hasMany(Indicator::class);
    }
}
