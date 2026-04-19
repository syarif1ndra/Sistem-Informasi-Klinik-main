<?php

namespace App\Http\Controllers\Api\Bidan;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Queue;
use App\Models\Transaction;

class DashboardController extends Controller
{
    use ApiResponse;

    /** GET /api/bidan/dashboard */
    public function index()
    {
        $today = now()->toDateString();

        return $this->successResponse([
            'queues_today'   => Queue::whereDate('date', $today)->count(),
            'queues_waiting' => Queue::whereDate('date', $today)->where('status', 'waiting')->count(),
            'queues_done'    => Queue::whereDate('date', $today)->where('status', 'done')->count(),
            'revenue_today'  => Transaction::whereDate('date', $today)
                ->where('status', 'paid')
                ->sum('total_amount'),
        ], 'Dashboard bidan');
    }
}
