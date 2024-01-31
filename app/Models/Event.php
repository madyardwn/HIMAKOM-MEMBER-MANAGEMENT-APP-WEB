<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'dbu_id'
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
     * The attributes should be casted to native types.
     * 
     * @return Attribute
     */
    protected function poster(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => file_exists(storage_path('app/public/' . config('dirpath.events.posters') . '/' . $value)) && $value != null
                ? asset('storage/' . config('dirpath.events.posters') . '/' . $value)
                : asset(config('tablar.default.event.path')),
        );
    }

    /**
     * The attributes that are logged.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'description', 'location', 'poster', 'date', 'type'])
            ->logOnlyDirty()
            ->useLogName('Events')
            ->setDescriptionForEvent(function (string $eventName) {
                return "{$this->name} has been {$eventName}";
            });
    }

    public function dbu()
    {
        return $this->belongsTo(DBU::class, 'dbu_id');
    }
}
