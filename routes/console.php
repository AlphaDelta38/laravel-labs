<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:generate-report')
    ->lastDayOfMonth('23:00')
    ->before(function () {
        Log::info('SCHEDULER: Starting monthly report generation...');
    })
    
    ->after(function () {
        Log::info('SCHEDULER: Monthly report generation attempt completed.');
    })
    
    ->onSuccess(function () {
        Log::info('SCHEDULER: Monthly report successfully generated!');
    })
    
    ->onFailure(function () {
        Log::error('SCHEDULER: Error occurred during monthly report generation.');
    });