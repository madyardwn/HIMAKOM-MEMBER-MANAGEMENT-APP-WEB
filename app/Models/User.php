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
     * Constant Variable 
     * 
     * @var object
     */
    const GENDER_TYPE = [
        0 => 'Female',
        1 => 'Male'
    ];

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
        'name_bagus',
        'picture',
        'year',
        'device_token',
        'gender',
        'department_id',
        'cabinet_id',
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

    /**
     * The attributes where the logo is stored.
     * 
     * @param string $value
     * @return string
     */
    public function getPictureAttribute($value)
    {
        if ($value && file_exists(storage_path('app/public/' . config('dirpath.users.pictures') . '/' . $value))) {
            return asset('storage/' . config('dirpath.users.pictures') . '/' . $value);
        } else if ($this->gender == 0) {
            return asset(config('tablar.default.female_avatar.path'));
        } else {
            return asset(config('tablar.default.male_avatar.path'));
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

    /**
     * Get the user's role.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class, 'cabinet_id');
    }

    /**
     * Get the user's role.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the user's program.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'users_programs', 'user_id', 'program_id');
    }

    /**
     * Get the user's notifications.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'users_notifications', 'user_id', 'notification_id')->withPivot('id')->withTimestamps();
    }
}
