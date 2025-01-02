<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Admin\Doctor\DoctorController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ChangeForgotPasswordControllerController;
use App\Http\Controllers\Admin\Bip\MaladaptiveV2Controller;
use App\Http\Controllers\Admin\Bip\ReplacementV2Controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('register', [AuthController::class, 'register'])
//     ->name('register');

// Route::post('login', [AuthController::class, 'login'])
//     ->name('login');



Route::group(['middleware' => 'api'], function ($router) {

    // Auth
    require __DIR__ . '/api_routes/auth.php';

    // users
    require __DIR__ . '/api_routes/users.php';

    // roles
    require __DIR__ . '/api_routes/roles.php';

    // doctors
    require __DIR__ . '/api_routes/doctors.php';

    // patient
    require __DIR__ . '/api_routes/patient.php';

    // patientfile
    require __DIR__ . '/api_routes/patientfile.php';

    // insurance
    require __DIR__ . '/api_routes/insurance.php';

    // bip
    require __DIR__ . '/api_routes/bip.php';

    // goals
    // reduction goals
    require __DIR__ . '/api_routes/goal.php';

    // goal sustitution
    require __DIR__ . '/api_routes/goal_sustitution.php';

    // goal family_envolments
    require __DIR__ . '/api_routes/family_envolments.php';

    // goal behavior_asistant
    require __DIR__ . '/api_routes/behavior_asistant.php';

    // goal consent_to_treatment
    require __DIR__ . '/api_routes/consent_to_treatment.php';

    // goal crisis_plan
    require __DIR__ . '/api_routes/crisis_plan.php';

    // goal de_escalation_technique
    require __DIR__ . '/api_routes/de_escalation_technique.php';

    // goal generalization_training
    require __DIR__ . '/api_routes/generalization_training.php';

    // goal monitoring_evaluating
    require __DIR__ . '/api_routes/monitoring_evaluating.php';


    // goals

    // note_rbt
    require __DIR__ . '/api_routes/note_rbt.php';

    // note_bcba
    require __DIR__ . '/api_routes/note_bcba.php';


    // location
    require __DIR__ . '/api_routes/location.php';

    // graphic_reduction
    require __DIR__ . '/api_routes/graphic_reduction.php';

    // billing
    require __DIR__ . '/api_routes/billing.php';

    // client_report
    require __DIR__ . '/api_routes/client_report.php';


    // dashboard
    require __DIR__ . '/api_routes/dashboard.php';

    // parents
    require __DIR__ . '/api_routes/parents.php';

    // PA Services
    require __DIR__ . '/api_routes/pa_services.php';

    // Claims
    require __DIR__ . '/api_routes/claims.php';

    // Tests
    require __DIR__ . '/api_routes/tests.php';

    // PDF
    require __DIR__ . '/api_routes/pdf.php';

    Route::apiResource('maladaptives', MaladaptiveV2Controller::class);
    Route::apiResource('replacements', ReplacementV2Controller::class);

    //comandos desde la url del backend

    Route::get('/cache', function () {
        Artisan::call('cache:clear');
        return "Cache";
    });

    Route::get('/optimize', function () {
        Artisan::call('optimize:clear');
        return "Optimización de Laravel";
    });

    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return "Storage Link";
    });


    Route::get('/migrate-seed', function () {
        Artisan::call('migrate:refresh --seed');
        return "Migrate seed";
    });

    Route::get('/send-notification', function () {
        Artisan::call('command:notification-appointments');
        return "Send All notifications";
    });


    //rutas libres


    // Route::get('/categories', [CategoryController::class, 'index'])
    //     ->name('category.index');
});

Route::prefix('v2')->group(function () {
    Route::apiResource('maladaptives', MaladaptiveV2Controller::class);
    Route::apiResource('replacements', ReplacementV2Controller::class);
});
