<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Stage extends Model
{
    use HasFactory;
    use AsSource;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stage';

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

    // Une étape a plusieurs actions
    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
