<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Service;
use App\Models\Medicine;
use App\Models\Faq;
use App\Models\Queue;

class PublicController extends Controller
{
    use ApiResponse;

    /** GET /api/public/services */
    public function services()
    {
        $services = Service::orderBy('name')->get();
        return $this->successResponse($services, 'Data layanan');
    }

    /** GET /api/public/medicines */
    public function medicines()
    {
        $medicines = Medicine::select('id', 'name', 'category', 'price', 'description')
            ->orderBy('name')
            ->get();
        return $this->successResponse($medicines, 'Data obat');
    }

    /** GET /api/public/faqs */
    public function faqs()
    {
        $faqs = Faq::all();
        return $this->successResponse($faqs, 'Data FAQ');
    }

    /** GET /api/public/queues/display — current queue number display */
    public function queueDisplay()
    {
        $today   = now()->toDateString();
        $serving = Queue::whereDate('date', $today)
            ->where('status', 'in_progress')
            ->with(['patient:id,name', 'userPatient:id,name', 'service:id,name'])
            ->first();

        $waiting = Queue::whereDate('date', $today)
            ->where('status', 'waiting')
            ->count();

        return $this->successResponse([
            'currently_serving' => $serving ? [
                'queue_number' => $serving->queue_number,
                'patient_name' => $serving->patient_name,
                'service'      => optional($serving->service)->name,
            ] : null,
            'waiting_count' => $waiting,
        ], 'Data antrian display');
    }
}
