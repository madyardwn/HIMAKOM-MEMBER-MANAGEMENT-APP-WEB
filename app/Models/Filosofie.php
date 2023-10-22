<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Filosofie extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are logged.
     *
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['cabinet_id', 'logo', 'label'])
            ->logOnlyDirty()
            ->useLogName('Filosofie')
            ->setDescriptionForEvent(function (string $eventName) {
                return "{$this->label} has been {$eventName}";
            });
    }

    /**
     * The attributes where the logo is stored.
     * 
     */    
    public function getLogoAttribute($value)
    {
        if ($value) {
            return asset('storage/' . config('dirpath.cabinets.filosofies') . '/' . $value);
        }
    }

    /**
     * The attributes that are mass assignable.
     * 
    */
    protected $fillable = [
        'cabinet_id',
        'logo',
        'label',
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
}
