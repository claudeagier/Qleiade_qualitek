<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Orchid\Screen\AsSource;

class Processus extends Model
{
    use HasFactory, AsSource;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'processus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'manager_name',
        'label',
        'description',
    ];
    
    /**
     * wealths
     *
     * @return void
     */
    public function wealths()
    {
        return $this->hasMany(Wealth::class);
    }
}
