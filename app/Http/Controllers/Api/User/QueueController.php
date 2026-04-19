<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Queue;
use App\Models\Service;
use App\Models\UserPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class QueueController extends Controller
{
    use ApiResponse;

    /** GET /api/user/queues — riwayat antrian user */
    public function index(Request $request)
    {
        $patient = UserPatient::where('user_id', $request->user()->id)->first();

        if (!$patient) {
            return $this->errorResponse('Anda belum mengisi data pasien', 404);
        }

        $queues = Queue::where('user_patient_id', $patient->id)
            ->with(['service:id,name', 'assignedPractitioner:id,name,role'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return $this->successResponse($queues, 'Riwayat antrian');
    }

    /** POST /api/user/queues — daftar antrian baru */
    public function store(Request $request)
    {
        $patient = UserPatient::where('user_id', $request->user()->id)->first();

        if (!$patient) {
            return $this->errorResponse('Anda belum mengisi data pasien. Isi data diri terlebih dahulu di /api/user/patient', 404);
        }

        $validator = Validator::make($request->all(), [
            'service_id'  => 'required|exists:services,id',
            'complaint'   => 'required|string',
            'bpjs_usage'  => 'sometimes|boolean',
            'date'        => 'sometimes|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $date    = $request->input('date', now()->toDateString());
        $service = Service::findOrFail($request->service_id);

        // Cek apakah sudah terdaftar hari ini untuk layanan yang sama
        $existing = Queue::where('user_patient_id', $patient->id)
            ->whereDate('date', $date)
            ->where('service_id', $request->service_id)
            ->whereIn('status', ['waiting', 'in_progress'])
            ->first();

        if ($existing) {
            return $this->errorResponse('Anda sudah terdaftar untuk layanan ini pada tanggal tersebut', 409);
        }

        // Generate nomor antrian
        $lastQueue   = Queue::whereDate('date', $date)->max('queue_number');
        $queueNumber = ($lastQueue ?? 0) + 1;

        $queue = Queue::create([
            'user_patient_id' => $patient->id,
            'nik'             => $patient->nik,
            'service_id'      => $service->id,
            'service_name'    => $service->name,
            'bpjs_usage'      => $request->input('bpjs_usage', false),
            'queue_number'    => $queueNumber,
            'status'          => 'waiting',
            'complaint'       => $request->complaint,
            'date'            => $date,
        ]);

        return $this->successResponse($queue->load('service'), 'Berhasil mendaftar antrian', 201);
    }

    /** PATCH /api/user/queues/{id}/cancel — batalkan antrian */
    public function cancel(Request $request, $id)
    {
        $patient = UserPatient::where('user_id', $request->user()->id)->first();

        $queue = Queue::where('id', $id)
            ->where('user_patient_id', optional($patient)->id)
            ->first();

        if (!$queue) {
            return $this->errorResponse('Antrian tidak ditemukan', 404);
        }

        if (!in_array($queue->status, ['waiting'])) {
            return $this->errorResponse('Antrian tidak bisa dibatalkan pada status: ' . $queue->status, 422);
        }

        $queue->update(['status' => 'cancelled']);

        return $this->successResponse($queue, 'Antrian berhasil dibatalkan');
    }
}
