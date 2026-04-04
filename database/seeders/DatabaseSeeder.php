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

        $users = [
            ['name' => 'Admin ', 'email' => 'admin@klinik.com', 'role' => 'admin'],
            ['name' => 'user', 'email' => 'user@gmail.com', 'role' => 'user'],
            ['name' => 'Bidan Siti Hajar', 'email' => 'bidan@klinik.com', 'role' => 'bidan'],
            ['name' => 'Dokter Jaya', 'email' => 'dokter@klinik.com', 'role' => 'dokter'],
            ['name' => 'Owner Klinik', 'email' => 'owner@klinik.com', 'role' => 'owner'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']], 
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password'),
                    'role' => $user['role'],
                ]
            );
        }

  
        $services = [
            ['name' => 'KB IUD', 'description' => 'Pemasangan alat kontrasepsi IUD.', 'price' => 750000],
            ['name' => 'KB Implan', 'description' => 'Pemasangan KB implan.', 'price' => 300000],
            ['name' => 'KB Suntik 1 Bulan', 'description' => 'KB suntik 1 bulan.', 'price' => 35000],
            ['name' => 'KB Suntik 3 Bulan', 'description' => 'KB suntik 3 bulan.', 'price' => 35000],
            ['name' => 'Berobat Anak', 'description' => 'Pemeriksaan dan pengobatan anak.', 'price' => 65000],
            ['name' => 'Berobat Dewasa', 'description' => 'Pemeriksaan dan pengobatan dewasa.', 'price' => 85000],
            ['name' => 'Hecting', 'description' => 'Tindakan penjahitan luka.', 'price' => 25000],
            ['name' => 'ANC', 'description' => 'Antenatal Care / pemeriksaan kehamilan.', 'price' => 65000],
            ['name' => 'USG', 'description' => 'Pemeriksaan USG kehamilan.', 'price' => 100000],
            ['name' => 'Gestamin', 'description' => 'Pemeriksaan dan vitamin kehamilan.', 'price' => 70000],
            ['name' => 'Pregnabon', 'description' => 'Vitamin kehamilan.', 'price' => 70000],
            ['name' => 'Kontrol Nifas', 'description' => 'Pemeriksaan ibu setelah melahirkan.', 'price' => 100000],
            ['name' => 'Persalinan', 'description' => 'Pelayanan persalinan normal.', 'price' => 2000000],
            ['name' => 'Baby Spa', 'description' => 'Perawatan baby spa.', 'price' => 150000],
            ['name' => 'Massage Bayi', 'description' => 'Pijat dan relaksasi bayi.', 'price' => 50000],
            ['name' => 'Baby Gym', 'description' => 'Stimulasi gerak dan motorik bayi.', 'price' => 50000],
            ['name' => 'Perawatan Bayi', 'description' => 'Perawatan kesehatan bayi.', 'price' => 50000],
            ['name' => 'Pijat Batuk', 'description' => 'Terapi pijat untuk bayi batuk.', 'price' => 100000],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], $service);
        }

   
        $medicines = [
            ['name' => 'Vaksin Rotavirus', 'category' => 'Imunisasi', 'stock' => 50, 'price' => 100000, 'description' => 'Vaksin rotavirus untuk bayi.'],
            ['name' => 'Vaksin DPT / Polio', 'category' => 'Imunisasi', 'stock' => 50, 'price' => 75000, 'description' => 'Vaksin DPT dan Polio.'],
            ['name' => 'Vaksin BCG', 'category' => 'Imunisasi', 'stock' => 50, 'price' => 100000, 'description' => 'Vaksin BCG pencegahan TBC.'],
            ['name' => 'Vaksin Hib', 'category' => 'Imunisasi', 'stock' => 50, 'price' => 150000, 'description' => 'Vaksin Haemophilus Influenzae tipe B.'],
            ['name' => 'Vaksin TT', 'category' => 'Imunisasi', 'stock' => 50, 'price' => 50000, 'description' => 'Vaksin Tetanus Toxoid.'],
            ['name' => 'Vaksin Campak', 'category' => 'Imunisasi', 'stock' => 50, 'price' => 100000, 'description' => 'Vaksin campak.'],
            ['name' => 'Vaksin PCV', 'category' => 'Imunisasi', 'stock' => 50, 'price' => 100000, 'description' => 'Vaksin Pneumococcal Conjugate.'],
        ];

        foreach ($medicines as $med) {
            Medicine::updateOrCreate(['name' => $med['name']], $med);
        }


    
        
    }
}
