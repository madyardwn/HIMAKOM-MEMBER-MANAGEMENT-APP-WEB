<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array 
    */
    protected $fillable = [
        'name',
        'guard_name',
    ];

    /**
     * The attributes that are logged.
     *
     * @return LogOptions
     */
     public function getActivitylogOptions(): LogOptions
     {
         return LogOptions::defaults()
             ->logOnly(['name', 'guard_name'])
             ->logOnlyDirty()
             ->useLogName('Permission')
             ->setDescriptionForEvent(function (string $eventName) {
                 return "{$this->name} has been {$eventName}";
             });
     }
}
