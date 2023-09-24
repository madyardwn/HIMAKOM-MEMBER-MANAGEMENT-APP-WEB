<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filosofie extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabinet_id',
        'logo',
        'label',
    ];

    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class);
    }    
}
