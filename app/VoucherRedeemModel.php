<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Session; 

class VoucherRedeemModel extends Model
{
    
    public static function initializeSessionValues($user_id,$email_id){
    	$address_array=array('address_line_1'=>'','address_line_2'=>'','city'=>'','state'=>'','country'=>'','postal_code'=>'','phone'=>''); 
    	\Session::put('vouchers',array()); //Empty fields.
    	\Session::put('user_id',base64_decode($user_id));
        \Session::put('email_id',base64_decode($email_id));
        \Session::put('billing_address',$address_array); 
        \Session::put('shipping_address',$address_array); 
    }
    public static function checkVouchers($entered_vouchers){   
       $user_id=\Session::get('user_id');  
       $voucher_table=self::getUserVoucherTable($user_id);
       $invalid_validation_result=array();
       $valid_validation_result=array(); 
       foreach($entered_vouchers as $voucher){
            $count=DB::table($voucher_table)->where('user_id',$user_id)->where('coupon_code',$voucher)->count();  
            if($count==0){
                $invalid_validation_result[]=$voucher;
            }
            else{
                $valid_validation_result[]=$voucher;
            }
       }
       $valid_validation_result=array_unique($valid_validation_result); 
       \Session::put('vouchers',$valid_validation_result);
       $result=array();
       $result['invalid_result']=$invalid_validation_result;
       $result['valid_result']=$valid_validation_result; 
       echo json_encode($result);  
    }

    public static function getUserVoucherTable($user_id=1){
        if($user_id){
            $user_details=DB::table('users')->where('user_id',$user_id)->first();
            return $user_details->voucher_table;
        } 
        return false;
    }

    public static function getUserProductTable($user_id=1){
    	if($user_id){
    		$user_details=DB::table('users')->where('user_id',$user_id)->first();
    		return $user_details->product_table;
    	}
    	return false;
    }
    public static function saveBillingAddressToSession($request){
         $billing_address=array();
         $billing_address=$request->all();
         \Session::put('billing_address',$billing_address); 
    }
    public static function saveShippingAddressToSession($request){
    	$shipping_address=array();
    	$billing_shipping_same=$request->get('shipping_billing_same');
    	if($billing_shipping_same){
           $shipping_address=\Session::get('billing_address');
           $shipping_address['shipping_billing_same']=1;
           \Session::put('shipping_address',$shipping_address); 
    	}
    	else{
           \Session::put('shipping_address',$request->all()); 
    	}
    }

    public static function getShoppingCartProducts(){
    	$vouchers=\Session::get('vouchers');
    	$products=array(); 
    	$user_id=\Session::get('user_id'); 
    	$voucher_table=self::getUserVoucherTable($user_id);
    	$product_table=self::getUserProductTable($user_id); 

    	foreach($vouchers as $voucher){
           $voucher_details=DB::table($voucher_table)->where('coupon_code',$voucher)->where('user_id',$user_id)->first();
           $products[]=DB::table($product_table)->where('product_id',$voucher_details->product_linked)->first();
    	} 
    	return $products; 
    }

    public static function getUserDetails(){
    	$user_id=\Session::get('user_id');
    	$user_details=DB::table('users')->where('user_id',$user_id)->first();
    	return $user_details;
    }

}//Model Class ends here.
