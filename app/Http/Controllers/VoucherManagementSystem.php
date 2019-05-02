<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Customers;


class VoucherManagementSystem extends Controller
{
    //

    public function authenticateCredentials(Request $request){

      $email=$request->get('email');
      $password=$request->get('password');

      return $result=Customers::authenticateCustomers($email,$password);

    }

    public function changePassword(Request $request){

        $new_password=$request->get('new_password');
        $user_id=$request->get('user_id');

        return $result=Customers::changeUserPassword($new_password,$user_id);
    }

    public function getUserVouchers(Request $request){
        $user_id=$request->get('user_id');
        //sleep(3);
        return $result=Customers::getUserVouchersList($user_id);
    }


    public function disableEnableVoucher(Request $request){
        $user_id=$request->get('user_id');
        $voucher_id=$request->get('voucher_id');
        $status=$request->get('status');
        return $result=Customers::changeVoucherEnableDisable($user_id,$voucher_id,$status); //For disable send the flag 0.
    }

    public function changeRedemptionStatus(Request $request){
        $user_id=$request->get('user_id');
        $voucher_id=$request->get('voucher_id');
        $redemption_status=$request->get('redemption_status');
        return $result=Customers::changeVoucherRedemptionStatus($user_id,$voucher_id,$redemption_status);
    }

    public function deleteVoucher(Request $request){
        $user_id=$request->get('user_id');
        $voucher_id=$request->get('voucher_id');
        return $result=Customers::deleteCustomerVoucher($user_id,$voucher_id);
    }

    public function getVoucherDetails(Request $request){

        $user_id=$request->get('user_id');
        $voucher_id=$request->get('voucher_id');
        return $result=Customers::getVoucherData($user_id,$voucher_id);
    }

    public function getCompanyProducts(Request $request){
        $user_id=$request->get('user_id');
        return $result=Customers::getAllCompanyProducts($user_id);
    }

    public function SubmitVoucherDetails(Request $request){
        //Parameters list are quite huge.
        return $result=Customers::editVoucherDetails($request);
    }

}
