<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPatient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'nik',
        'dob',
        'gender',
        'phone',
        'address',
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

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
