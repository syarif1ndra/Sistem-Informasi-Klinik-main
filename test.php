<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$q = App\Models\Queue::whereNotNull('patient_id')->latest()->first();
if ($q) {
    echo 'Latest Queue ID: ' . $q->id . ' | Patient ID: ' . $q->patient_id . ' | Date: ' . $q->date . PHP_EOL;
    $t = App\Models\Transaction::where('patient_id', $q->patient_id)->first();
    if ($t) {
        echo 'Found Transaction ID: ' . $t->id . ' | Patient ID: ' . $t->patient_id . ' | Date: ' . $t->date . PHP_EOL;

        $match = App\Models\Queue::where('id', $q->id)->with('transaction')->first();
        echo 'Relation Loaded: ' . ($match->transaction ? 'YES (Tx: ' . $match->transaction->id . ')' : 'NO (Null)') . PHP_EOL;
    } else {
        echo 'No transaction found for patient_id=' . $q->patient_id . PHP_EOL;
    }
} else {
    echo 'No queues with patient_id found.' . PHP_EOL;
}
