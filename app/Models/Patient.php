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

    /**
     * Interact with the patients's gender.
     */
    protected function gender(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn (string $value) => $value === 'L' ? 'male' : 'female',
            set: fn (string $value) => strtolower($value) === 'male' || strtolower($value) === 'l' ? 'L' : 'P',
        );
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
