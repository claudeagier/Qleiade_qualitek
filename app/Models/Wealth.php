<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Wealth extends Model
{
    use HasFactory, AsSource;

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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'validity_date' => 'datetime',
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

    public function careers()
    {
        return $this->belongsToMany(
            Career::class,
            "wealths_careers",
            "wealth_id",
            "career_id"
        );
    }
}
