<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'baby_name',
        'birth_date',
        'birth_time',
        'birth_place',
        'gender',
        'mother_name',
        'mother_nik',
        'father_name',
        'father_nik',
        'mother_address',
        'father_address',
        'phone_number',
        'gpa',
        'kala_1',
        'kala_2',
        'kala_3',
        'baby_weight',
        'baby_length',
        'head_circumference',
        'chest_circumference',
        'birth_certificate_number',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
}
