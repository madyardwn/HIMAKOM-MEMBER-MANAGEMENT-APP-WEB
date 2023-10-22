<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
    */
    protected $fillable = [
        'name',
        'short_name',
        'description',
        'logo',
        'is_active',
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
            return asset('storage/' . config('dirpath.departments.logo') . '/' . $value);
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
            ->logOnly(['name', 'short_name', 'description', 'logo', 'is_active'])
            ->logOnlyDirty()
            ->useLogName('Department')
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
     * Get the cabinet that owns the department.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function cabinets()
    {
        return $this->belongsToMany(Cabinet::class, 'periodes', 'department_id', 'cabinet_id')->withPivot('id', 'is_active', 'position')->withTimestamps();
    }

    /**
     * Get the users that owns the department.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function users()
    {
        return $this->belongsToMany(User::class, 'periodes', 'department_id', 'user_id')->withPivot('id', 'is_active', 'position')->withTimestamps();
    }

    /**
     * Get the periodes that owns the department.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function periodes()
    {
        return $this->hasMany(Periode::class);
    }

    /**
     * Get the active departments.
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
