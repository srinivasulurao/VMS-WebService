<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\VoucherRedeemModel; 
use Session; 

class VoucherRedemption extends Controller
{
    
    public static function inputVouchers($user_id,$email_id){
      $data=array();
      //Store the user_id and email id in the session, these things needs to be very secure.
      VoucherRedeemModel::initializeSessionValues($user_id,$email_id);
      $data['vouchers']=@implode(",",\Session::get('vouchers'));  //CAOK65517,BAOK65812
      return view('playground',$data);
    }
    public static function showVoucherRedemptionForm(){
    	//We have already values present in the session.
    	$data=array(); 
    	$data['vouchers']=@implode(",",\Session::get('vouchers'));
    	return view('voucher-input',$data);  
    }
    public function validateVouchers(Request $request){ 
        $entered_vouchers=base64_decode($request->get('entered_vouchers')); 
        $entered_vouchers=explode(",",$entered_vouchers);
        VoucherRedeemModel::checkVouchers($entered_vouchers);      
    }

    public function showBillingAddressForm(){
    	$auto_populate=\Session::get('billing_address');
    	return view('billing-address',$auto_populate);  
    }
    public function saveBillingAddress(Request $request){
    	VoucherRedeemModel::saveBillingAddressToSession($request);
    }
    public function showShippingAddressForm(){
    	$auto_populate=\Session::get('shipping_address');
    	return view("shipping-address",$auto_populate);  
    }
    public function saveShippingAddress(Request $request){
    	VoucherRedeemModel::saveShippingAddressToSession($request); 
    }
    public function shoppingCart(Request $request){
    	$data=array();
    	$user=VoucherRedeemModel::getUserDetails();
    	$locale='en-US'; //browser or user locale
		$currency=$user->currency;
		$fmt = new \NumberFormatter( $locale."@currency=$currency", \NumberFormatter::CURRENCY );
		$symbol = $fmt->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
    	$data['user']=$user;
    	$data['currency_symbol']=$symbol;
    	$data['products']=VoucherRedeemModel::getShoppingCartProducts(); 
    	return view('cart',$data); 

    }

}//Class ends here.
