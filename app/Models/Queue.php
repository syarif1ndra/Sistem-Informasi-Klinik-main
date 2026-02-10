<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'user_patient_id',
        'nik',
        'service_id',
        'service_name',
        'bpjs_usage',
        'queue_number',
        'status',
        'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function userPatient()
    {
        return $this->belongsTo(UserPatient::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getPatientNameAttribute()
    {
        return $this->patient ? $this->patient->name : ($this->userPatient ? $this->userPatient->name : '-');
    }

    public function getPatientNikAttribute()
    {
        return $this->patient ? $this->patient->nik : ($this->userPatient ? $this->userPatient->nik : '-');
    }
}
