<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nim',
        'npa',
        'nama_bagus',
        'picture',
        'year',
        'device_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The attributes that are logged.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'nim', 'npa', 'nama_bagus', 'picture', 'year', 'device_token'])
            ->logOnlyDirty()
            ->useLogName('User')
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
     * Get the user's role.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function cabinets()
    {
        return $this->belongsToMany(Cabinet::class, 'periodes', 'user_id', 'cabinet_id')->withPivot('id', 'is_active', 'position')->withTimestamps();
    }

    /**
     * Get the user's role.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'periodes', 'user_id', 'department_id')->withPivot('id', 'is_active', 'position')->withTimestamps();
    }

    /**
     * Get the user's role.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function periodes()
    {
        return $this->hasMany(Periode::class);
    }

    /**
     * Get the user's role.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function scopeActive($query)
    {
        return $query->whereHas('periodes', function ($query) {
            $query->where('is_active', true);
        });
    }
}
