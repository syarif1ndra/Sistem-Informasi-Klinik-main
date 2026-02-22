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
        'complaint', // Added complaint
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

    public function getTransactionDataAttribute()
    {
        if (!$this->patient_id)
            return null;

        // Get all queues for this patient on this date, ordered by time created
        $queues = self::where('patient_id', $this->patient_id)
            ->whereDate('date', $this->date)
            ->orderBy('created_at')
            ->get();

        // Find index of the current queue (0 = first visit of the day, 1 = second visit, etc)
        $index = $queues->search(function ($q) {
            return $q->id === $this->id; });

        // Get all transactions for this patient on this date, logically in same chronological order
        $transactions = Transaction::with('items')
            ->where('patient_id', $this->patient_id)
            ->whereDate('date', $this->date)
            ->orderBy('created_at')
            ->get();

        // Match the transaction to the exact visit index
        return $transactions->get($index);
    }
}
