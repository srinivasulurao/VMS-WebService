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
      $result=Customers::authenticateCustomers($email,$password);
      http_response_code($result['http_response_code']);
      echo json_encode($result);
      die();
    }

    public function changePassword(Request $request){

        $new_password=$request->get('new_password');
        $user_id=$request->get('user_id');
        $result=Customers::changeUserPassword($new_password,$user_id);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function getUserVouchers(Request $request){
        $user_id=$request->get('user_id');
        $result=Customers::getUserVouchersList($user_id);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }


    public function disableEnableVoucher(Request $request){
        $user_id=$request->get('user_id');
        $voucher_id=$request->get('voucher_id');
        $status=$request->get('status');
        $result=Customers::changeVoucherEnableDisable($user_id,$voucher_id,$status); //For disable send the flag 0.
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function changeRedemptionStatus(Request $request){
        $user_id=$request->get('user_id');
        $voucher_id=$request->get('voucher_id');
        $redemption_status=$request->get('redemption_status');
        $result=Customers::changeVoucherRedemptionStatus($user_id,$voucher_id,$redemption_status);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function deleteVoucher(Request $request){
        $user_id=$request->get('user_id');
        $voucher_id=$request->get('voucher_id');
        $result=Customers::deleteCustomerVoucher($user_id,$voucher_id);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function getVoucherDetails(Request $request){

        $user_id=$request->get('user_id');
        $voucher_id=$request->get('voucher_id');
        $result=Customers::getVoucherData($user_id,$voucher_id);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function getCompanyProducts(Request $request){
        $user_id=$request->get('user_id');
        $result=Customers::getAllCompanyProducts($user_id);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function SubmitVoucherDetails(Request $request){
        //Parameters list are quite huge.
        $result=Customers::editVoucherDetails($request);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function UploadVoucherList(Request $request){
        $result=Customers::processVoucherCSVFile($request);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function AddProductDetails(Request $request){
        $result=Customers::addProduct($request);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function getProductDetails(Request $request){
        $result=Customers::getProductData($request);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function UpdateProductDetails(Request $request){
        $result=Customers::editProductDetails($request);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function GetUserDetails(Request $request){
        $result=Customers::getUserData($request);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function GetAllPlans(Request $request){
        $result=Customers::getPlanList();
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function SaveProfileDetails(Request $request){
        $result=Customers::saveCompanyProfileDetails($request);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function CheckDuplicateAccount(Request $request){
        $result=Customers::CheckDuplicateEmailAddress($request);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function DoRegistration(Request $request){
        $result=Customers::SaveRegistrationAndCompletePayment($request);
        http_response_code($result['http_response_code']);
        echo json_encode($result);
        die();
    }

    public function GetCustomerMessages(Request $request){
       $result=Customers::getCommunicationMessages($request);
       http_response_code($result['http_response_code']);
       echo json_encode($result);
       die();
    }

    public function DeleteMessage(Request $request){
      $result=Customers::deleteCommunicationMessage($request);
      http_response_code($result['http_response_code']);
      echo json_encode($result);
      die();
    }

    public function DeleteProduct(Request $request){
      $result=Customers::deleteUserProduct($request);
      http_response_code($result['http_response_code']);
      echo json_encode($result);
      die();
    }








}
