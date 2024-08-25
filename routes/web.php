<?php

use App\Http\Controllers\SendMailController;
use App\Http\Controllers\HealthCheckController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [SendMailController::class, 'index']);
Route::post('/send-email', [SendMailController::class, 'sendEmail'])->name('send.email');


// routes/web.php

Route::get('/live', function () {
    // Perform basic checks, such as checking if the app is running
    return response()->json(['status' => 'OK'], 200);
});

