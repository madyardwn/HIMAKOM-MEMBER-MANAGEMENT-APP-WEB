<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'description',
        'logo',
        'is_active',
    ];

    public function cabinets()
    {
        return $this->belongsToMany(Cabinet::class, 'periodes', 'department_id', 'cabinet_id')->withPivot('id', 'periode', 'is_active')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'periodes', 'department_id', 'user_id')->withPivot('id', 'periode', 'is_active')->withTimestamps();
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
