<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
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
        'user_id',
        'department_id',
        'cabinet_id',
        'position',
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

    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
