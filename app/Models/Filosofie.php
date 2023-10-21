<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filosofie extends Model
{
    use HasFactory;

    /**
     * The attributes that are logged.
     *
     */

    /**
     * The attributes where the logo is stored.
     * 
    */
    protected $fillable = [
        'cabinet_id',
        'logo',
        'label',
    ];

    /**
     * The attributes that are mass assignable.
     * 
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS 
    |--------------------------------------------------------------------------
    |
    | Here are the relations this model has with other models
    |
    */

    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class);
    }    
}
