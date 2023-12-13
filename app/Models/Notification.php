<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Notification extends Model
{
    use HasFactory, LogsActivity;

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

    /**
     * The attributes should be casted to native types.
     * 
     * @return Attribute
     */
    protected function poster(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => file_exists(storage_path('app/public/' . config('dirpath.notifications.posters') . '/' . $value)) && $value != null
                ? asset('storage/' . config('dirpath.notifications.posters') . '/' . $value)
                : asset(config('tablar.default.notification.path')),
        );
    }

    /**
     * The attributes that be casted to native types.
     * 
     * @return array
     */
    protected function link(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != null
                ? $value
                : '-',
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
            ->logOnly(['title', 'body', 'link', 'poster'])
            ->logOnlyDirty()
            ->useLogName('Notification')
            ->setDescriptionForEvent(function (string $eventName) {
                return "{$this->name} has been {$eventName}";
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
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_notifications', 'notification_id', 'user_id');
    }
}
