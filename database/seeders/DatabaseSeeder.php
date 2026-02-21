<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Medicine;
use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // ADMIN USER
        // =====================
        User::create([
            'name' => 'Admin Bidan',
            'email' => 'admin@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'user ',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // =====================
        // BIDAN USER
        // =====================
        User::create([
            'name' => 'Bidan Utama',
            'email' => 'bidan@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'bidan',
        ]);

        // =====================
        // DOKTER USER
        // =====================
        User::create([
            'name' => 'Dokter Klinik',
            'email' => 'dokter@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);
        // =====================
        // SERVICES (LAYANAN)
        // =====================

        // KB & Pemeriksaan Umum
        Service::create([
            'name' => 'KB IUD',
            'description' => 'Pemasangan alat kontrasepsi IUD.',
            'price' => 750000
        ]);

        Service::create([
            'name' => 'KB Implan',
            'description' => 'Pemasangan KB implan.',
            'price' => 300000
        ]);

        Service::create([
            'name' => 'KB Suntik 1 Bulan',
            'description' => 'KB suntik 1 bulan.',
            'price' => 35000
        ]);

        Service::create([
            'name' => 'KB Suntik 3 Bulan',
            'description' => 'KB suntik 3 bulan.',
            'price' => 35000
        ]);

        Service::create([
            'name' => 'Berobat Anak',
            'description' => 'Pemeriksaan dan pengobatan anak.',
            'price' => 65000
        ]);

        Service::create([
            'name' => 'Berobat Dewasa',
            'description' => 'Pemeriksaan dan pengobatan dewasa.',
            'price' => 85000
        ]);

        Service::create([
            'name' => 'Hecting',
            'description' => 'Tindakan penjahitan luka.',
            'price' => 25000
        ]);

        // Kehamilan
        Service::create([
            'name' => 'ANC',
            'description' => 'Antenatal Care / pemeriksaan kehamilan.',
            'price' => 65000
        ]);

        Service::create([
            'name' => 'USG',
            'description' => 'Pemeriksaan USG kehamilan.',
            'price' => 100000
        ]);

        Service::create([
            'name' => 'Gestamin',
            'description' => 'Pemeriksaan dan vitamin kehamilan.',
            'price' => 70000
        ]);

        Service::create([
            'name' => 'Pregnabon',
            'description' => 'Vitamin kehamilan.',
            'price' => 70000
        ]);

        Service::create([
            'name' => 'Kontrol Nifas',
            'description' => 'Pemeriksaan ibu setelah melahirkan.',
            'price' => 100000
        ]);

        // Persalinan & Bayi
        Service::create([
            'name' => 'Persalinan',
            'description' => 'Pelayanan persalinan normal.',
            'price' => 2000000
        ]);

        Service::create([
            'name' => 'Baby Spa',
            'description' => 'Perawatan baby spa.',
            'price' => 150000
        ]);

        Service::create([
            'name' => 'Massage Bayi',
            'description' => 'Pijat dan relaksasi bayi.',
            'price' => 50000
        ]);

        Service::create([
            'name' => 'Baby Gym',
            'description' => 'Stimulasi gerak dan motorik bayi.',
            'price' => 50000
        ]);

        Service::create([
            'name' => 'Perawatan Bayi',
            'description' => 'Perawatan kesehatan bayi.',
            'price' => 50000
        ]);

        Service::create([
            'name' => 'Pijat Batuk',
            'description' => 'Terapi pijat untuk bayi batuk.',
            'price' => 100000
        ]);

        // =====================
        // MEDICINES (IMUNISASI)
        // =====================
        Medicine::create([
            'name' => 'Vaksin Rotavirus',
            'category' => 'Imunisasi',
            'stock' => 50,
            'price' => 100000,
            'description' => 'Vaksin rotavirus untuk bayi.'
        ]);

        Medicine::create([
            'name' => 'Vaksin DPT / Polio',
            'category' => 'Imunisasi',
            'stock' => 50,
            'price' => 75000,
            'description' => 'Vaksin DPT dan Polio.'
        ]);

        Medicine::create([
            'name' => 'Vaksin BCG',
            'category' => 'Imunisasi',
            'stock' => 50,
            'price' => 100000,
            'description' => 'Vaksin BCG pencegahan TBC.'
        ]);

        Medicine::create([
            'name' => 'Vaksin Hib',
            'category' => 'Imunisasi',
            'stock' => 50,
            'price' => 150000,
            'description' => 'Vaksin Haemophilus Influenzae tipe B.'
        ]);

        Medicine::create([
            'name' => 'Vaksin TT',
            'category' => 'Imunisasi',
            'stock' => 50,
            'price' => 50000,
            'description' => 'Vaksin Tetanus Toxoid.'
        ]);

        Medicine::create([
            'name' => 'Vaksin Campak',
            'category' => 'Imunisasi',
            'stock' => 50,
            'price' => 100000,
            'description' => 'Vaksin campak.'
        ]);

        Medicine::create([
            'name' => 'Vaksin PCV',
            'category' => 'Imunisasi',
            'stock' => 50,
            'price' => 100000,
            'description' => 'Vaksin Pneumococcal Conjugate.'
        ]);

        // =====================
        // FAQ
        // =====================
        Faq::create([
            'question' => 'Apa saja tanda awal kehamilan?',
            'answer' => 'Tanda awal meliputi telat haid, mual, dan payudara sensitif.'
        ]);

        Faq::create([
            'question' => 'Kapan bayi harus imunisasi?',
            'answer' => 'Imunisasi diberikan sesuai jadwal nasional dari lahir.'
        ]);
    }
}
