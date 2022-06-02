<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Formation extends Model
{
    use HasFactory;
    use AsSource;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formation';

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

    public function wealths()
    {
        return $this->belongsToMany(
            Wealth::class,
            "wealths_formations",
            "formation_id",
            "wealth_id"
        );
    }
}
