<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'queue_id',
        'examined_by',
        'examined_at',
        'height',
        'weight',
        'blood_pressure',
        'temperature',
        'pulse',
        'respiratory_rate',
        'main_complaint',
        'medical_history',
        'diagnosis_text',
    ];

    protected $casts = [
        'examined_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function examiner()
    {
        return $this->belongsTo(User::class, 'examined_by');
    }

    public function icd10Codes()
    {
        return $this->belongsToMany(Icd10Code::class, 'screening_icd10', 'screening_id', 'icd10_code_id');
    }
}
