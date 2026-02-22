<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$queues = App\Models\Queue::with('transaction')->whereNotNull('patient_id')->get();
foreach ($queues as $q) {
    echo "Queue {$q->id} (Date: {$q->date}) -> Tx: " . ($q->transaction ? $q->transaction->id : 'NULL') . "\n";
}
