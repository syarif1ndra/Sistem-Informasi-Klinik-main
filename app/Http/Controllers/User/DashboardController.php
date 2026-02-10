<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $patient = $user->userPatient; // Renamed logic, keeping variable name for view compatibility? Or update view?
        // Let's keep variable name $patient but it holds UserPatient model. 
        // Better to verify view compatibility. UserPatient has name, nik, phone, address. 
        // Dashboard view uses: name, nik, whatsapp_number (removed).

        $recentRegistrations = [];

        if ($patient) {
            $recentRegistrations = Queue::where('user_patient_id', $patient->id)
                ->with('service')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('user.dashboard', compact('user', 'patient', 'recentRegistrations'));
    }
}
