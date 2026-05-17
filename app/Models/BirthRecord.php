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
        'mother_age',
        'mother_job',
        'father_name',
        'father_nik',
        'father_age',
        'father_job',
        'mother_address',
        'father_address',
        'phone_number',
        'child_order',
        'attendant_name',
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

    protected $appends = [
        'gender_label',
    ];

    /**
     * Interact with the baby's gender.
     */
    protected function gender(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn (?string $value) => $value ? strtoupper($value) : null,
            set: fn (?string $value) => $value === null ? null : match (strtolower($value)) {
                'male', 'l' => 'L',
                'female', 'p' => 'P',
                default => null,
            },
        );
    }

    public function getGenderLabelAttribute(): ?string
    {
        return $this->gender === 'L' ? 'Laki-laki' : ($this->gender === 'P' ? 'Perempuan' : null);
    }
}
