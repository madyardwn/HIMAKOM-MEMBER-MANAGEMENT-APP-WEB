<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkHistory extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $fillable = [
        'user_id',
        'cabinet_id',
        'department_id',
        'role_id',
        'start_date',
    ];

    /**
     * The attributes that are logged on every activity.
     *
     * @var string[]
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['user_id', 'cabinet_id', 'department_id', 'role_id', 'start_date'])
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
     * Get the user that owns the WorkHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class);
    }

    /**
     * Get the user that owns the WorkHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the user that owns the WorkHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user that owns the WorkHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
