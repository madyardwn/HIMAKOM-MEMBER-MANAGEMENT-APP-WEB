<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabinet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo',
        'year',
        'is_active',
        'visi',
        'misi',        
    ];

    public function filosofies()
    {
        return $this->hasMany(Filosofie::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'periodes', 'cabinet_id', 'user_id')->withPivot('id', 'periode', 'is_active')->withTimestamps();
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'periodes', 'cabinet_id', 'department_id')->withPivot('id', 'periode', 'is_active')->withTimestamps();
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
