<?php

use App\Helpers\RegistrationHelper;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/accomodation', function () {
    return view('pages.accomodation');
});

// Route::get('/', [RegistrationController::class, 'get_view_international']);

Route::get('/registration-international', [RegistrationController::class, 'get_view_international'])->name('registration.form.international');

Route::post('/registration-international-submit', [RegistrationController::class, 'registration_international_submit']);

Route::post('/registration-vietnamese-submit', [RegistrationController::class, 'registration_vietnamese_submit']);

Route::get('/registration-vietnamese', [RegistrationController::class, 'get_view_vietnamese'])->name('registration.form.vietnamese');

Route::get('/registration/payment-response', [RegistrationController::class, 'payment_response']);

Route::get('/registration/wire-transfer-response', [RegistrationController::class, 'wire_transfer_response']);

Route::get('/get-list-countries', function () {
    $countries = RegistrationHelper::getListCountry();
    return response()->json($countries);
});

Route::get('/registration/response/success', [RegistrationController::class, 'responseSuccess'])->name('registration.response.success');
Route::get('/registration/response/cancelled', [RegistrationController::class, 'responseCancelled'])->name('registration.response.cancelled');
Route::get('/registration/response/failed', [RegistrationController::class, 'responseFailed'])->name('registration.response.failed');
