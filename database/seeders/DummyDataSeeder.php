<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use App\Models\UserPatient;
use App\Models\Service;
use App\Models\Medicine;
use App\Models\Queue;
use App\Models\MedicalRecord;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Screening;
use App\Models\BirthRecord;
use App\Models\Immunization;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Ensure roles exist
        $bidan = User::where('role', 'bidan')->first();
        $dokter = User::where('role', 'dokter')->first();
        if (!$bidan || !$dokter) {
            $this->command->info('Please run DatabaseSeeder first to create base users.');
            return;
        }

        $services = Service::all();
        $medicines = Medicine::all();
        
        if ($services->count() == 0 || $medicines->count() == 0) {
            $this->command->info('Please run DatabaseSeeder first to create services and medicines.');
            return;
        }

        $this->command->info('Creating 50 Users & Patients...');
        $patients = [];
        $userPatients = [];

        for ($i = 0; $i < 50; $i++) {
            // Create User (role: user)
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);

            // Create UserPatient (Profile for the User)
            $userPatient = UserPatient::create([
                'user_id' => $user->id,
                'nik' => $faker->unique()->numerify('################'),
                'name' => $user->name,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'dob' => $faker->date('Y-m-d', '-20 years'),
                'gender' => $faker->randomElement(['L', 'P']),
                // removed medical_history and bpjs_number per model schema
            ]);
            $userPatients[] = $userPatient;

            // Create Patient (Clinic Record)
            $patient = Patient::create([
                'user_id' => $user->id,
                'nik' => $userPatient->nik,
                'name' => $user->name,
                'address' => $userPatient->address,
                'phone' => $userPatient->phone,
                'dob' => $userPatient->dob,
                'gender' => $userPatient->gender,
            ]);
            $patients[] = $patient;
        }

        $this->command->info('Creating 50 Queues, Screenings, Medical Records & Transactions...');
        for ($i = 0; $i < 50; $i++) {
            $patient = $faker->randomElement($patients);
            $userPatient = UserPatient::where('user_id', $patient->user_id)->first();
            $service = $faker->randomElement($services);
            $practitioner = $faker->randomElement([$bidan, $dokter]);
            
            $date = $faker->dateTimeBetween('-6 months', 'now');
            $status = $faker->randomElement(['finished', 'cancelled']);

            // Create Queue
            $queue = Queue::create([
                'patient_id' => $patient->id,
                'user_patient_id' => $userPatient->id,
                'service_id' => $service->id,
                'service_name' => $service->name,
                'nik' => $patient->nik,
                'queue_number' => rand(1, 100),
                'status' => $status,
                'date' => clone $date,
                'complaint' => $faker->sentence(),
                'assigned_practitioner_id' => $practitioner->id,
            ]);

            if ($status === 'finished') {
                // Determine Queue handled_by explicitly if needed via update
                // Queue doesn't always have handled_by in mass assignable or standard setup, 
                // but we assign handled_by inside MedicalRecord and Transaction.
                
                // Create Screening
                $screening = Screening::create([
                    'patient_id' => $patient->id,
                    'queue_id' => $queue->id,
                    'examined_by' => $practitioner->id,
                    'examined_at' => clone $date,
                    'height' => $faker->randomFloat(1, 140, 190),
                    'weight' => $faker->randomFloat(1, 40, 100),
                    'blood_pressure' => $faker->numberBetween(100, 140) . '/' . $faker->numberBetween(60, 90),
                    'temperature' => $faker->randomFloat(1, 36.0, 37.5),
                    'pulse' => $faker->numberBetween(60, 100),
                    'respiratory_rate' => $faker->numberBetween(12, 20),
                    'main_complaint' => $queue->complaint,
                    'medical_history' => $patient->medical_history ?? '-',
                    'diagnosis_text' => $faker->sentence(),
                ]);

                // Create Medical Record
                MedicalRecord::create([
                    'patient_id' => $patient->id,
                    'service_id' => $service->id,
                    'diagnosis' => $faker->sentence(),
                    'treatment' => $faker->sentence(),
                    'type' => $faker->randomElement(['outpatient', 'inpatient']),
                    'date' => clone $date,
                ]);

                // Create Transaction
                $totalAmount = $service->price;
                
                $transaction = Transaction::create([
                    'patient_id' => $patient->id,
                    'total_amount' => 0, 
                    'status' => 'paid',
                    'payment_method' => $faker->randomElement(['cash', 'bpjs']),
                    'date' => clone $date,
                    'handled_by' => $practitioner->id,
                    'processed_by' => User::where('role', 'admin')->first()->id ?? $practitioner->id,
                ]);

                // Transaction Items
                // 1. Service
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'item_type' => 'App\Models\Service',
                    'item_id' => $service->id,
                    'name' => $service->name,
                    'quantity' => 1,
                    'price' => $service->price,
                    'subtotal' => $service->price,
                ]);

                // 2. Medicines
                $numMedicines = rand(1, 3);
                for ($m = 0; $m < $numMedicines; $m++) {
                    $medicine = $faker->randomElement($medicines);
                    $qty = rand(1, 10);
                    $subtotal = $medicine->price * $qty;
                    
                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'item_type' => 'App\Models\Medicine',
                        'item_id' => $medicine->id,
                        'name' => $medicine->name,
                        'quantity' => $qty,
                        'price' => $medicine->price,
                        'subtotal' => $subtotal,
                    ]);
                    $totalAmount += $subtotal;
                }

                $transaction->update(['total_amount' => $totalAmount]);
            }
        }

        $this->command->info('Creating 50 Birth Records...');
        for ($i = 0; $i < 50; $i++) {
            BirthRecord::create([
                'baby_name' => $faker->name,
                'birth_date' => clone $faker->dateTimeBetween('-1 years', 'now'),
                'birth_time' => $faker->time('H:i:s'),
                'birth_place' => $faker->city,
                'gender' => $faker->randomElement(['L', 'P']),
                'mother_name' => $faker->name('female'),
                'mother_nik' => $faker->numerify('################'),
                'father_name' => $faker->name('male'),
                'father_nik' => $faker->numerify('################'),
                'mother_address' => $faker->address,
                'father_address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'gpa' => 'G1P0A0', // dummy
                'kala_1' => '-',
                'kala_2' => '-',
                'kala_3' => '-',
                'baby_weight' => $faker->numberBetween(2500, 4000), // integer grams in some schemas, model casts to integer typically? Using float/int gracefully 
                'baby_length' => $faker->randomFloat(1, 45, 55),
                'head_circumference' => $faker->randomFloat(1, 30, 35),
                'chest_circumference' => $faker->randomFloat(1, 30, 35),
                'birth_certificate_number' => $faker->bothify('BCN-######'),
                'notes' => $faker->sentence(),
            ]);
        }

        $this->command->info('Creating 50 Immunizations...');
        $immunizationTypes = ['BCG', 'DPT', 'Polio', 'Campak', 'Hepatitis B'];
        for ($i = 0; $i < 50; $i++) {
            Immunization::create([
                'child_name' => $faker->name,
                'child_nik' => $faker->numerify('################'),
                'child_phone' => $faker->phoneNumber,
                'birth_place' => $faker->city,
                'birth_date' => clone $faker->dateTimeBetween('-1 years', 'now'),
                'parent_name' => $faker->name('female'),
                'address' => $faker->address,
                'notes' => $faker->sentence(),
                'immunization_date' => clone $faker->dateTimeBetween('-1 years', 'now'),
            ]);
        }

        $this->command->info('Dummy data generation completed successfully!');
    }
}
