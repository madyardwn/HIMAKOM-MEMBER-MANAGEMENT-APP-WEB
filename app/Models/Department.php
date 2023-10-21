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
     * The attributes that are logged.
     *
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

    /**
     * The attributes where the logo is stored.
     * 
    */
    protected $fillable = [
        'name',
        'short_name',
        'description',
        'logo',
        'is_active',
    ];
    
    /**
     * The attributes that are mass assignable.
     * 
    */
    public function getLogoAttribute($value)
    {
        if ($value) {
            return asset('storage/' . config('dirpath.departments.logo') . '/' . $value);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS 
    |--------------------------------------------------------------------------
    |
    | Here are the relations this model has with other models
    |
    */
    
    public function cabinets()
    {
        return $this->belongsToMany(Cabinet::class, 'periodes', 'department_id', 'cabinet_id')->withPivot('id', 'is_active', 'position')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'periodes', 'department_id', 'user_id')->withPivot('id', 'is_active', 'position')->withTimestamps();
    }

    public function periodes()
    {
        return $this->hasMany(Periode::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
