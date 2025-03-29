<?php

use App\Jobs\UpdatePresensiJamKeluarJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\UpdatePresensiStatusJob;

// Perintah Artisan inspire
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Jadwalkan job UpdatePresensiStatusJob setiap hari pada jam 17:00
Schedule::job(new UpdatePresensiStatusJob())->dailyAt('17:00');

// Jadwalkan job UpdatePresensiJamKeluarJob setiap hari pada jam 19:00
Schedule::job(new UpdatePresensiJamKeluarJob())->dailyAt('19:00');