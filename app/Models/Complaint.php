<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Complaint extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'complaint',
        'screenshot',
        'is_resolve',
        'user_id',
    ];

    /**
     * The attributes should be casted to native types.
     * 
     * @return Attribute
     */
    protected function screenshot(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => file_exists(storage_path('app/public/' . config('dirpath.complaints.screenshots') . '/' . $value)) && $value != null
                ? asset('storage/' . config('dirpath.complaints.screenshots') . '/' . $value)
                : asset(config('tablar.default.preview.path')),
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
            ->logOnly(['name', 'complaint', 'screenshot', 'is_resolve', 'user_id'])
            ->logOnlyDirty()
            ->useLogName('Complaint')
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
