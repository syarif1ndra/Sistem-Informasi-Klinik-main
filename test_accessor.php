<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$queues = App\Models\Queue::whereNotNull('patient_id')->get();
foreach ($queues as $q) {
    echo "Queue {$q->id} (Date: {$q->date}) -> Tx: " . ($q->transaction_data ? $q->transaction_data->id . ' (Items: ' . $q->transaction_data->items->count() . ')' : 'NULL') . "\n";
}
