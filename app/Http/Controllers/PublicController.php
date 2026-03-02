<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Queue;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // 1. Ambil antrian hari ini yang sedang dipanggil
        $currentQueue = Queue::where('date', date('Y-m-d'))
            ->where('status', 'calling')
            ->orderBy('updated_at', 'desc')
            ->first();

        // 2. Ambil data obat (karena harganya mungkin sering berubah di database)
        $medicines = Medicine::all();

        /* Data FAQ dan Layanan tidak perlu dipanggil dari database lagi
           karena sudah kita tulis langsung (hardcoded) di index.blade.php
        */

        return view('public.home', compact('currentQueue', 'medicines'));
    }

    // Fungsi redirect tetap aman dibiarkan jika ada user yang manual mengetik url /services
    public function services() { return redirect()->route('public.home', ['#layanan']); }
    public function medicines() { return redirect()->route('public.home', ['#obat']); }
    public function faqs() { return redirect()->route('public.home', ['#faq']); }
}
