<?php
header('Access-Control-Allow-Origin: *');

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//For Login and Registration webservices.
Route::post('/do-login','VoucherManagementSystem@authenticateCredentials')->middleware('authenticate_request');
Route::post('/change-password','VoucherManagementSystem@changePassword')->middleware('authenticate_request');

//for All Internal profile transactions, middleware will be used for handling all malicious web request.
Route::post('/get-user-vouchers','VoucherManagementSystem@getUserVouchers')->middleware('authenticate_request');
Route::post('/disable-enable-voucher','VoucherManagementSystem@disableEnableVoucher')->middleware('authenticate_request');
Route::post('/change-redemption_status','VoucherManagementSystem@changeRedemptionStatus')->middleware('authenticate_request');
Route::post('/delete-voucher','VoucherManagementSystem@deleteVoucher')->middleware('authenticate_request');
Route::post('/get-voucher-details','VoucherManagementSystem@getVoucherDetails')->middleware('authenticate_request');
Route::post('/get-product-details','VoucherManagementSystem@getProductDetails')->middleware('authenticate_request');
Route::post('/get-company-products','VoucherManagementSystem@getCompanyProducts')->middleware('authenticate_request');
Route::post('/submit-voucher-details','VoucherManagementSystem@SubmitVoucherDetails')->middleware('authenticate_request');
Route::post('/upload-vouchers','VoucherManagementSystem@UploadVoucherList')->middleware('authenticate_request');
Route::post('/add-new-product','VoucherManagementSystem@AddProductDetails')->middleware('authenticate_request');
Route::post('/update-product-details','VoucherManagementSystem@UpdateProductDetails')->middleware('authenticate_request');
Route::post('/get-user-details','VoucherManagementSystem@GetUserDetails')->middleware('authenticate_request');
Route::post('/get-all-plans','VoucherManagementSystem@GetAllPlans')->middleware('authenticate_request');
Route::post('/save-profile-details','VoucherManagementSystem@SaveProfileDetails')->middleware('authenticate_request'); 
Route::post('/register-company','VoucherManagementSytem@DoRegistration')->middleware('authenticate_request'); 