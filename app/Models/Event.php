<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
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

    /**
     * The attributes that are mass assignable.
     * 
    */
    protected $fillable = [
        'name',
        'description',
        'location',
        'poster',
        'date',
        'time',
        'type',
        'is_active',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS 
    |--------------------------------------------------------------------------
    |
    | Here are the relations this model has with other models
    |
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
