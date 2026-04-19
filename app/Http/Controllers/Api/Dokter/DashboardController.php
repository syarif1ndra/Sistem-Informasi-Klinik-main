<?php

namespace App\Http\Controllers\Api\Dokter;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Queue;
use App\Models\Transaction;

class DashboardController extends Controller
{
    use ApiResponse;

    /** GET /api/dokter/dashboard */
    public function index(\Illuminate\Http\Request $request)
    {
        $today  = now()->toDateString();
        $userId = $request->user()->id;

        return $this->successResponse([
            'my_queues_today'    => Queue::whereDate('date', $today)
                ->where('assigned_practitioner_id', $userId)->count(),
            'my_queues_waiting'  => Queue::whereDate('date', $today)
                ->where('assigned_practitioner_id', $userId)->where('status', 'waiting')->count(),
            'my_queues_done'     => Queue::whereDate('date', $today)
                ->where('assigned_practitioner_id', $userId)->where('status', 'done')->count(),
            'my_revenue_today'   => Transaction::whereDate('date', $today)
                ->where('handled_by', $userId)->where('status', 'paid')->sum('medical_staff_revenue'),
        ], 'Dashboard dokter');
    }
}
