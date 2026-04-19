<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Queue;
use App\Models\Patient;
use App\Models\Transaction;
use App\Models\Medicine;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    use ApiResponse;

    /** GET /api/admin/dashboard */
    public function index()
    {
        $today = now()->toDateString();

        $data = [
            'queues_today'       => Queue::whereDate('date', $today)->count(),
            'queues_waiting'     => Queue::whereDate('date', $today)->where('status', 'waiting')->count(),
            'queues_in_progress' => Queue::whereDate('date', $today)->where('status', 'in_progress')->count(),
            'queues_done'        => Queue::whereDate('date', $today)->where('status', 'done')->count(),
            'total_patients'     => Patient::count(),
            'total_transactions' => Transaction::count(),
            'revenue_today'      => Transaction::whereDate('date', $today)->where('status', 'paid')->sum('total_amount'),
            'low_stock_medicines'=> Medicine::whereColumn('stock', '<=', 'min_stock')->count(),
            'total_staff'        => User::whereIn('role', ['dokter', 'bidan'])->count(),
        ];

        return $this->successResponse($data, 'Data dashboard admin');
    }
}
