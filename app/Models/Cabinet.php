<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Cabinet extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'logo',
        'year',
        'is_active',
        'visi',
        'misi',
    ];

    /**
     * The attributes should be casted to native types.
     * 
     * @return Attribute
     */
    protected function logo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => file_exists(storage_path('app/public/' . config('dirpath.cabinets.logo') . '/' . $value))
                ? asset('storage/' . config('dirpath.cabinets.logo') . '/' . $value)
                : asset(config('tablar.default.logo.path')),
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
            ->logOnly(['name', 'logo', 'year', 'is_active', 'visi', 'misi', 'description'])
            ->logOnlyDirty()
            ->useLogName('Cabinet')
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

    /**
     * Get the filosofies for the cabinet.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function filosofies()
    {
        return $this->hasMany(Filosofie::class);
    }

    /**
     * Get the users for the cabinet.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'cabinet_id');
    }

    /**
     * Get the departments for the cabinet.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'cabinets_departments', 'cabinet_id', 'department_id')->withPivot('id')->withTimestamps();
    }
}
