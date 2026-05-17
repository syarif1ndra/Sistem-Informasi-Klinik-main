<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik',
        'name',
        'address',
        'phone',
        'medical_history',
        'service',
        'dob',
        'gender',
    ];

    protected $appends = [
        'gender_label',
    ];

    /**
     * Interact with the patients's gender.
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function screenings()
    {
        return $this->hasMany(Screening::class)->orderByDesc('examined_at');
    }
}
