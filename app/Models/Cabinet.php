<?php

namespace App\Models;

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
     * The attributes where the logo is stored.
     * 
     * @param string $value
     * @return string
     */
    public function getLogoAttribute($value)
    {
        if ($value) {
            return asset('storage/' . config('dirpath.cabinets.logo') . '/' . $value);
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
            ->logOnly(['name', 'logo', 'year', 'is_active', 'visi', 'misi'])
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_cabinets', 'cabinet_id', 'user_id')->withPivot('id')->withTimestamps();
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
