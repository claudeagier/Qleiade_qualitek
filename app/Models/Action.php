<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Orchid\Screen\AsSource;

class Action extends Model
{
    use HasFactory, AsSource;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'action';

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

    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    public function wealths()
    {
        return $this->belongsToMany(
            Wealth::class,
            "wealths_actions",
            "action_id",
            "wealth_id"
        );
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
