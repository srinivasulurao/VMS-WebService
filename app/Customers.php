<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Customers extends Model
{
    //
    public $table="users";

    public $primaryKey="user_id";

    //###################################################################
    //All Data Providers
    //###################################################################

    public static function authenticateCustomers($email,$password){

        $result_count=DB::table('users')->where('email',$email)->where('password',md5($password))->count();

        if($result_count){
            $result=DB::table('users')->where('email',$email)->where('password',md5($password))->first();
            //Check the account is activated or not.
            if($result->activation==false){
                return self::responseObject(300,"Unable to Login, your account is deactivated, please contact administrator for further activation !");
            }
            else{
                //Update the last login time.
                self::updateLastLogin($result->user_id);
                //Now return the result.
                return self::responseObject(200,"Login Successful !",$result); //User Exists.

            }

        }
        else{
            return self::responseObject(300,"Invalid credentials!");
        }

    }

    public static function registerUser($email,$password,$company_name,$opted_plan){
        //Add important details in the params fields.
    }

    public static function updateLastLogin($user_id){
        if($user_id) {
            $current_time=date("Y-m-d H:i:s",time()); //We have to think about the timezone later on. Currently it is UTC as per Laravel.
            DB::table("users")->where('user_id', $user_id)->update(['last_login'=>$current_time]);
        }
    }

    public static function changeUserPassword($new_password,$user_id){
        if($new_password && $user_id){
            DB::table('users')->where('user_id', $user_id)->update(array('password' => md5($new_password)));
            return self::responseObject(200,"User Account Password Changed Successfully!",md5($new_password));
        }
        else{
            return self::responseObject(300,"User Id or the Password is missing, please contact the site administrator for more details !");
        }
    }

    public static function getUserVouchersList($user_id){

        if($user_id){
            $user_details=DB::table('users')->where('user_id',$user_id)->first();
            $voucher_table=$user_details->voucher_table;

            $vouchers=DB::table($voucher_table)->get();
            return self::responseObject(200,"Voucher list generated successfully !", $vouchers);


        }
        else{
            return self::responseObject(300,"Invalid User Id, Account doesn't exist !");
        }
    }

    public static  function changeVoucherEnableDisable($user_id,$voucher_id,$status){
        $voucher_table=self::getUserVoucherTable($user_id);
        if($voucher_table && $user_id){
            DB::table($voucher_table)->where('voucher_id',$voucher_id)->update(array('enabled'=>$status));
            $vouchers=DB::table($voucher_table)->get();
            $ed=($status==1)?"Enabled":"Disabled";
            return self::responseObject(200,"Voucher id {$voucher_id} $ed Successfully !", $vouchers);
        }
        else{
            return self::responseObject(300,"User Id, Voucher Id and Voucher Redemption Status is missing !",null);
        }
    }

    public static function changeVoucherRedemptionStatus($user_id,$voucher_id,$redemption_status){

        if($user_id){
            $voucher_table=self::getUserVoucherTable($user_id);
            $now=date("Y-m-d h:i:s");
            DB::table($voucher_table)->where('voucher_id',$voucher_id)->update(array('redemption_status'=>$redemption_status,'redeemed_on'=>$now));
            $vouchers=DB::table($voucher_table)->get();
            $ed=($redemption_status==1)?"Redeemed":"Not Redeemed";
            return self::responseObject(200,"Voucher id {$voucher_id} $ed Successfully !", $vouchers);
        }
        else{
            return self::responseObject(300,"User Id, Voucher Id and Voucher Redemption Status is missing !",null);
        }
    }

    public static function deleteCustomerVoucher($user_id,$voucher_id){

        if($user_id){
            $voucher_table=self::getUserVoucherTable($user_id);
            DB::table($voucher_table)->where('voucher_id',$voucher_id)->delete();
            $vouchers=DB::table($voucher_table)->get();
            return self::responseObject(200,"Voucher id {$voucher_id} deleted successfully !", $vouchers);
        }
        else{
            return self::responseObject(300,"User Id and Voucher Id missing !",null);
        }
    }

    public static function getUserVoucherTable($user_id){
        if($user_id){
            $user_details=DB::table('users')->where('user_id',$user_id)->first();
            $voucher_table=$user_details->voucher_table;
            return $voucher_table;
        }
        return false;
    }

    protected static function getVoucherData($user_id,$voucher_id){
        if($user_id){
            $voucher_table=self::getUserVoucherTable($user_id);
            $voucher=DB::table($voucher_table)->where('voucher_id',$voucher_id)->first();
            return self::responseObject(200,"Voucher id {$voucher_id} data generated successfully !", $voucher);
        }
        else{
            return self::responseObject(300,"User Id and Voucher ID is missing !",null);
        }
    }

    protected static function getAllCompanyProducts($user_id){
        if($user_id){
            $products=DB::table('products')->where('user_id',$user_id)->get();
            return self::responseObject(200,"Product list generated successfully !",$products);
        }
        else{
            return self::responseObject(300,"Parameter User ID is missing !",null);
        }
    }

    protected static function editVoucherDetails($request){
        $user_id=$request->get('user_id');
        $voucher_id=$request->get('voucher_id');
        $update_data=array();
        $update_data['redemption_status']=$request->get('redemption_status');
        $update_data['validity']=$request->get('voucher_validity');
        $update_data['product_linked']=$request->get('product_linked');
        $update_data['enabled']=$request->get('enabled');
        $update_data['created_on']=$request->get('created_on');
        $update_data['redeemed_on']=$request->get('redeemed_on');
        $update_data['notes']=$request->get('notes');

        if($user_id){
            $voucher_table=self::getUserVoucherTable($user_id);
            DB::table($voucher_table)->where('voucher_id',$voucher_id)->update($update_data);
            $vouchers=DB::table($voucher_table)->get();
            return self::responseObject(200,"Voucher id {$voucher_id} updated Successfully !", $vouchers);
        }
        else{
            return self::responseObject(300,"Important Parameters are missing !",null);
        }
    }

    //#################################################
    //JSON Converter
    //###############################################

    public static function responseObject($http_response='200',$verbose_message,$data=null){

        $response_result=array();
        $response_result['action']=($http_response>100 && $http_response < 300)?"success":"failure";
        $response_result['http_response_code']=$http_response;
        $response_result['verbose_message']=$verbose_message;
        $response_result['data']=$data;

        return $response_result;

    }




} //Class ends here.
