<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are logged.
     *
     */
     public function getActivitylogOptions(): LogOptions
     {
         return LogOptions::defaults()
             ->logOnly(['name', 'guard_name'])
             ->logOnlyDirty()
             ->useLogName('Role')
             ->setDescriptionForEvent(function (string $eventName) {
                 return "{$this->name} has been {$eventName}";
             });
     }
    
     /**
     * The attributes where the logo is stored.
     * 
    */
    
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
}
