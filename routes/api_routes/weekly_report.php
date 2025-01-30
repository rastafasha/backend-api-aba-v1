<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WeeklyReportV2Controller;

Route::prefix('v2')->group(function () {
        Route::get('weekly-reports', [WeeklyReportV2Controller::class, 'index'])->name('weekly-report.index');
        Route::post('weekly-reports', [WeeklyReportV2Controller::class, 'store'])->name('weekly-report.store');
        Route::get('weekly-reports/{id}', [WeeklyReportV2Controller::class, 'show'])->name('weekly-report.show');
        Route::put('weekly-reports/{id}', [WeeklyReportV2Controller::class, 'update'])->name('weekly-report.update');
        Route::patch('weekly-reports/{id}', [WeeklyReportV2Controller::class, 'patch'])->name('weekly-report.patch');
        Route::delete('weekly-reports/{id}', [WeeklyReportV2Controller::class, 'destroy'])->name('weekly-report.destroy');
});
