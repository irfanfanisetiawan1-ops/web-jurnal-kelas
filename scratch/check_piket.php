<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;

echo "WA Gateway Provider: " . (Setting::getByKey('wa_gateway_provider') ?: env('WA_GATEWAY_PROVIDER', 'fonnte')) . "\n";
echo "WA Gateway Token: " . (Setting::getByKey('wa_gateway_token') ? 'CONFIGURED' : (env('WA_GATEWAY_TOKEN') || env('FONNTE_TOKEN') ? 'CONFIGURED IN ENV' : 'EMPTY')) . "\n";
echo "WA Gateway URL: " . (Setting::getByKey('wa_gateway_url') ?: env('WA_GATEWAY_URL', 'DEFAULT')) . "\n";
