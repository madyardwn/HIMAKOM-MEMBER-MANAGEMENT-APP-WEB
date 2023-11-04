<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Event extends Model
{
    use HasFactory, LogsActivity;

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
        'type',
        'link',
    ];

    /**
     * Type of event.
     * 
     */
    const EVENT_TYPE = [
        '1' => 'kegiatan',
        '2' => 'proker',
        '3' => 'lomba',
        '4' => 'project',
    ];

    /**
     * The attributes where the logo is stored.
     * 
     * @param string $value
     * @return string
     */
    public function getPosterAttribute($value)
    {
        if ($value) {
            return asset('storage/' . config('dirpath.events.posters') . '/' . $value);
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
            ->logOnly(['name', 'description', 'location', 'poster', 'date', 'time', 'type', 'is_active'])
            ->logOnlyDirty()
            ->useLogName('Events')
            ->setDescriptionForEvent(function (string $eventName) {
                return "{$this->name} has been {$eventName}";
            });
    }
}
