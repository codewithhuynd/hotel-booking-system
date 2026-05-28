<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
Mail::raw('Hello from test', function ($m) {
    $m->to('nguyenduchuy31052006@gmail.com')->subject('Laravel SMTP Test');
});
echo "SENT\n";
