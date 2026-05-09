<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$items = Illuminate\Support\Facades\DB::table('menu_items')->select('id','name','category','image')->get();
foreach ($items as $i) {
    echo "{$i->id} | {$i->category} | {$i->name} | image: " . ($i->image ?? 'NULL') . PHP_EOL;
}
