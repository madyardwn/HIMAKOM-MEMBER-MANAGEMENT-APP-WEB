<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Program extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     * 
     */
    protected $fillable = [
        'name',
        'description',
        'dbu_id',
        'user_id',
        'cabinet_id',
        'end_at',
    ];

    /**
     * The attributes where the logo is stored.
     * 
     */

    /**
     * The attributes that are logged.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'description', 'dbu_id', 'user_id', 'cabinet_id', 'end_at'])
            ->logOnlyDirty()
            ->useLogName('Program')
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
     * Get the dbu that owns the program.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dbu()
    {
        return $this->belongsTo(DBU::class, 'dbu_id');
    }

    /**
     * Get the lead for the program.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lead()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the participants for the program.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'users_programs', 'program_id', 'user_id');
    }

    /**
     * Get the cabinet for the program.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class, 'cabinet_id');
    }
}
