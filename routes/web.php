 <?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/redeem-voucher/{user_id}/{email_id}',"VoucherRedemption@inputVouchers")->middleware('authenticate_request');  
Route::get('/voucher-redeem/',"VoucherRedemption@showVoucherRedemptionForm")->middleware('authenticate_request'); 
Route::get("/billing-address","VoucherRedemption@showBillingAddressForm")->middleware("authenticate_request");
Route::get('/shipping-address',"VoucherRedemption@showShippingAddressForm")->middleware('authenticate_request');
Route::get('/shopping-cart',"VoucherRedemption@shoppingCart")->middleware('authenticate_request'); 



Route::post('/validate-vouchers',"VoucherRedemption@validateVouchers")->middleware('authenticate_request');     
Route::post('/save-billing-address','VoucherRedemption@saveBillingAddress')->middleware("authenticate_request");
Route::post('/save-shipping-address','VoucherRedemption@saveShippingAddress')->middleware("authenticate_request");    

