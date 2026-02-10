<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immunization extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_name',
        'child_nik',
        'child_phone',
        'birth_place',
        'birth_date',
        'parent_name',
        'address',
        'notes',
        'immunization_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'immunization_date' => 'date',
    ];
}
