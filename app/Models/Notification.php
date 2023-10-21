<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
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
        'title',
        'body',
        'link',
        'poster',
    ];
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS 
    |--------------------------------------------------------------------------
    |
    | Here are the relations this model has with other models
    |
    */

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_notifications', 'notification_id', 'user_id');
    }
}
