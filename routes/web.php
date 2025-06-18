<?php

use App\Helpers\RegistrationHelper;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/registration-international', [RegistrationController::class, 'get_view_international']);

Route::post('/registration-international-submit', [RegistrationController::class, 'registration_international_submit']);

Route::post('/registration-vietnamese-submit', [RegistrationController::class, 'registration_vietnamese_submit']);

Route::get('/registration-vietnamese', [RegistrationController::class, 'get_view_vietnamese']);

Route::get('/registration/payment-response', [RegistrationController::class, 'payment_response']);

Route::get('/registration/wire-transfer-response', [RegistrationController::class, 'wire_transfer_response']);

Route::get('/get-list-countries', function () {
    $countries = RegistrationHelper::getListCountry();
    return response()->json($countries);
});
