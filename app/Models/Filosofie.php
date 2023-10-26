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
     * The attributes that are mass assignable.
     *
     * @var array 
     */
    protected $fillable = [
        'cabinet_id',
        'logo',
        'label',
    ];

    /**
     * The attributes where the logo is stored.
     * 
     * @param string $value
     * @return string
     */
    public function getLogoAttribute($value)
    {
        if ($value) {
            return asset('storage/' . config('dirpath.cabinets.filosofies') . '/' . $value);
        }
    }

    /**
     * The attributes that are logged.
     *
     * @return LogOptions
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS 
    |--------------------------------------------------------------------------
    |
    | Here are the relations this model has with other models
    |
    */

    /**
     * Get the cabinet that owns the filosofie.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class);
    }
}
