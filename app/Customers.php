<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Customers extends Model
{
    public $table="users";
    public $primaryKey="user_id";
    const current_voucher_table="vouchers_1"; //This is a plan, if in future the table becomes full, to be used only during registration process.
    const current_product_table="products_1";

    //###################################################################
    //Authenticators
    //###################################################################
    public static function authenticateCustomers($email,$password){
           try{
               if($email && $password){
                    $result_count=DB::table('users')->where('email',$email)->where('password',md5($password))->count();
                    if($result_count){
                        $result=DB::table('users')->where('email',$email)->where('password',md5($password))->first();
                        //Check the account is activated or not.
                        if($result->activation==false){
                            return self::responseObject(206,"Unable to Login, your account is deactivated, please contact administrator for account activation !");
                        }
                        else{
                            self::updateLastLogin($result->user_id);
                            return self::responseObject(200,"Login Successful !",$result); //User Exists.
                        }
                    }
                    else{
                        return self::responseObject(400,"Invalid credentials !");
                    }
              }
              else{
                  return self::responseObject(400,"Missing parameters, Email and Password is mandatory !");
              }
          }
          catch(\Exception $e){
              return self::responseObject(403,$e->getMessage()); // Internal server Error.
          }
    }

    public static function CheckDuplicateEmailAddress($request){

        try{
            $email=$request->get('email');
            $count=DB::table('users')->where('email',$email)->count();
            if($count){
                return self::responseObject(200,"Account Exist!",array('total_count'=>$count));
            }
            else{
                return self::responseObject(200,"Duplicate Account",array('total_count'=>$count));
            }
        }
        catch(\Exception $e){
            return self::responseObject(403, explode("(",$e->getMessage())[0],$e->getLine());
        }
    }

############################################################
//Add Webservice Requests
############################################################

    public static function SaveRegistrationAndCompletePayment($request){
        try{
            $insert=array();
            $insert['email']=$request->get('email');
            $insert['company_name']=$request->get('company_name');
            $insert['phone_no']=$request->get('phone_no');
            $insert['password']=md5($request->get('password'));
            $insert['activation']=1;
            $insert['opted_plan']=$request->get('opted_plan');
            $insert['voucher_table']=self::current_voucher_table;
            $insert['product_table']=self::current_product_table;
            $insert['currency']=$request->get('currency');
            $insert['account_created']=date("Y-m-d H:i:s",time());
            $insert['last_login']=  date("Y-m-d H:i:s",time());
            $params=array();
            $params[0]['plan_slno']=0;
            $params[0]['plan_id']=$request->get('opted_plan');
            $params[0]['end_date']=self::getPlanEndDate($request->get('opted_plan'));
            $insert['params']=json_encode($params);
            $company_logo=$request->file('company_logo'); //Store the company logo.
            if($company_logo){
                $destination_path=storage_path('company_logos');
                $image_name=time()."_".str_replace(" ","_",$company_logo->getClientOriginalName());
                $company_logo->move($destination_path,$image_name);
                $insert['company_logo']=$image_name;
            }
            $last_insert_id=DB::table('users')->insertGetId($insert);
            //Save the Payment Transaction Details, as of now we using paypal, in future we may integrate some more payment gateways like stripe etc.
            if($last_insert_id){
                $payment_transaction=array();
                $payment_transaction['user_id']=$last_insert_id;
                $payment_transaction['transaction_id']=$request->get('transaction_id'); //This is the payment gateway transaction id.
                $payment_transaction['plan_id']=$request->get('opted_plan');
                $payment_transaction['transaction_details']=$request->get('transaction_details');
                $payment_transaction['created_on']=date('Y-m-d H:i:s',time());
                $payment_transaction['status']=$request->get('status');
                $payment_transaction_success=DB::table('payment_transactions')->insertGetId($payment_transaction);
            }
            if($last_insert_id && $payment_transaction_success){
                //Ideally we should send a mail to the user, who registered here.
                self::sendRegistrationSuccessMail($request->get('email'));
                return self::responseObject(200,"Registration Successful !",array('paypal_transaction_id'=>$request->get('transaction_id'),'user_id'=>$last_insert_id,'VMS_payment_transaction_id'=>$payment_transaction_success)); // User has been inserted with payment transaction details.
            }
        }
        catch(\Exception $e){
            return self::responseObject(403,$e->getmessage()." @ ".$e->getLine(). ", Please contact the administrator to resolve this issue.",null);
        }
    }

    protected static function addProduct($request){
        try{
            $insert=array();
            $user_id = $request->get('user_id');
            $insert['user_id']=$request->get('user_id');
            $insert['product_name']=$request->get('product_name');
            $insert['specification']=$request->get('specification');
            $insert['specification_options']=$request->get('specification_options');
            $insert['price']=$request->get('price');
            $insert['quantity']=$request->get('quantity');
            $validation=self::validateProductDetails($request,true);
            $product_image=$request->file('product_image');

            if($product_image){
                $destination_path=storage_path('product_images');
                $product_image_name=time()."_".str_replace(" ","_",$product_image->getClientOriginalName());
                $product_image->move($destination_path,$product_image_name);
                $insert['product_image']=$product_image_name;
            }

            if($validation['result']==true) {
                $product_table = self::getProductsTable($user_id);
                DB::table($product_table)->insert($insert);
                return self::responseObject(200,"New Product Added Successfully !",array());
            }else{
                return self::responseObject(300,$validation['validation_message'], null);
            }
        }
        catch (\Exception $e){
            return self::responseObject(300,$e->getMessage(),array());
        }
    }

    public static function sendRegistrationSuccessMail($customer_email){

        // Mail::send('mail',array('register.mail'=>'Voucher Management System'), function($message){
        //     $message->to($customer_email)
        //             ->subject('Registration Successful !')
        //             ->from('admin@vms.com');
        // });
        //we do something very soon.
        return 1;
    }

    /*
     * Here, we will first check the CSV format is correct or not !
     * Secondly, we will skip the first row while processing the rows.
     * Finally, will check the how many vouchers can the user upload, based on that we will process the rows.
     *
     */
    protected static function processVoucherCSVFile($request){
        try {
            $file = $request->file('voucher_csv');
            $user_id = $request->get('user_id');
            $voucher_table = self::getUserVoucherTable($user_id);
            $remaining_count = self::getVoucherRemainingCount($user_id);
            $file_name = time() . "_" . str_replace(" ", "_", $file->getClientOriginalName());
            $destination_path = storage_path('voucher_csv_files');
            $file->move($destination_path, $file_name);
            $csv_file = $destination_path . "/" . $file_name;
            $fp = fopen($csv_file, "r");
            $count = 0;
            $row = 0;

            $error = "";
            while ($handle = fgetcsv($fp, 1000, ",")) {
                $count++;
                if (sizeof($handle) != 4) {
                    $error = "Format Not Supported in Row $count !";
                    break;
                } else if ($count == 1) { //Skip the first row.
                    continue;
                } else {
                    if ($row > $remaining_count) {   //Customer is not allowed to add more than his quota.
                        $error .= "Processed, $count coupons, Your coupon quota is full !";
                        break;
                    }
                    $validity = date("Y-m-d", strtotime($handle[1]));
                    $today = date("Y-m-d", time());
                    $product_linked = self::getLinkedProductId($handle[2], $user_id);
                    $insert = array();
                    $insert['coupon_code'] = $handle[0];
                    $insert['redemption_status'] = 0;
                    $insert['enabled'] = 1;
                    $insert['validity'] = $validity;
                    $insert['created_on'] = $today;
                    $insert['product_linked'] = self::getLinkedProductId($handle[2], $user_id);
                    $insert['notes'] = $handle[3];

                    DB::table($voucher_table)->insert($insert);
                    $row++;
                }
            }

            $vouchers = self::getUserVouchersList($user_id);

            if ($error) {
                return self::responseObject(201, $error, $vouchers);
            } else {
                return self::responseObject(200, "Vouchers Uploaded Successfully !");
            }
        }
        catch(\Exception $e){
            return self::responseObject(403, explode("(",$e->getMessage())[0],$e->getLine());
        }
    }

###########################################################
//Get Webservice Requests
##########################################################
   public static function getCommunicationMessages($request){
     try{
        $user_id=$request->get('user_id');
        if($user_id){
            $messages=DB::table('communications')->where('user_id', $user_id)->get();
            return self::responseObject(200,"Success",$messages);
        }
        else{
            return self::responseObject(400,"Missing Parameters, UserID is mandatory !");
        }
     }
     catch(\Exception $e){
           return self::responseObject(403,$e->getMessage());
     }
   }

   public static function getUserVouchersList($user_id){
       try{
             if($user_id){
                 $user_details=DB::table('users')->where('user_id',$user_id)->first();
                 $voucher_table=$user_details->voucher_table;
                 $vouchers=DB::table($voucher_table)->get();
                 return self::responseObject(200,"Voucher list generated successfully !", $vouchers);
             }
             else{
                 return self::responseObject(400,"Missing parameters, UserID is missing !");
             }
       }
       catch(\Exception $e){
            return self::responseObject(403,$e->getMessage());
       }
   }

   protected static function getVoucherData($user_id,$voucher_id){
       try{
           if($user_id && $voucher_id){
               $voucher_table=self::getUserVoucherTable($user_id);
               $voucher=DB::table($voucher_table)->where('voucher_id',$voucher_id)->first();
               return self::responseObject(200,"Voucher id {$voucher_id} data generated successfully !", $voucher);
           }
           else{
               return self::responseObject(400,"Missing Parameters, UserID and VoucherID are mandatory !",null);
           }
       }
       catch(\Exception $e){
           return self::responseObject(403,$e->getMessage());
       }
   }

   protected static function getProductData($request){

       try {
           $user_id = $request->get('user_id');
           $product_id = $request->get('product_id');
           if ($user_id && $product_id) {
               $products_table = self::getProductsTable($user_id);
               $product = DB::table($products_table)->where('product_id', $product_id)->first();
               return self::responseObject(200, "Data fetched successfully !", $product);
           } else {
               return self::responseObject(400, "Parameters Missing, UserID and ProductID are mandatory !", null);
           }
       }
       catch (\Exception $e){
           return self::responseObject(403, $e->getMessage() , null);
       }
   }

   protected static function getAllCompanyProducts($user_id){
       try{
           if($user_id){
               $products_table=self::getProductsTable($user_id);
               $products=DB::table($products_table)->where('user_id',$user_id)->get();
               return self::responseObject(200,"Product list generated successfully !",$products);
           }
           else{
               return self::responseObject(400,"Parameter User ID is missing !");
           }
       }
       catch(\Exception $e){
           return self::responseObject(403,$e->getMessage());
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

   //If the volume of product is very high, then we may use multiple tables for product.
   public static function getProductsTable($user_id){
       if($user_id){
           $user_details=DB::table('users')->where('user_id',$user_id)->first();
           $product_table=$user_details->product_table;
           return $product_table;
       }
       return false;
   }
   /* Get Customer Plan limits */
   protected static function getUserPlan($user_id){
       $user=DB::table('users')->where('user_id',$user_id)->first();
       $plan=DB::table('plans')->where('plan_id',$user->opted_plan)->first();
       return $plan;
   }

   public static function getPlanEndDate($plan_id){
       $plan=DB::table('plans')->where('plan_id',$plan_id)->first();
       $end_date=($plan->duration*3600*24)+time();
       return date("Y-m-d H:i:s",$end_date);
   }

   protected static function getLinkedProductId($product_name,$user_id)
   {
       $product_obj=DB::table('products')->where('user_id',$user_id)->where('product_name',$product_name);
       if($product_obj->count()){
           $pid=$product_obj->first()->product_id;
           return $pid;
       }
       return null;
   }

   protected static function getVoucherRemainingCount($user_id){
        $plan=self::getUserPlan($user_id);
        $voucher_table=self::getUserVoucherTable($user_id);
        $total_vouchers=DB::table($voucher_table)->count();
        $remaining_quota=$plan->coupon_limit-$total_vouchers;
        return $remaining_quota;
   }

   public static function getUserData($request){

       try{
           $user_id=$request->get('user_id');
           if($user_id){
               $result=DB::table('users')->where('user_id',$user_id)->first();
               return self::responseObject(200,"User Details Loaded Successfully !",$result); //User Exists.
           }
           else{
               return self::responseObject(400,"Missing Parameters, UserID is mandatory !");
           }

       }
       catch(\Exception $e){
           return self::responseObject(403, explode("(",$e->getMessage())[0],$e->getLine());
       }
   }

   public static function getPlanList(){
         try{
             $result=DB::table('plans')->get();
             return self::responseObject(200,"Plan List Generated Successfully !", $result);
         }
         catch(\Exception $e){
             return self::responseObject(403, explode("(",$e->getMessage())[0],$e->getLine());
         }
   }

###########################################################
//Delete Webservice Requests
##########################################################

     public static function deleteCommunicationMessage($request){
       try{
           $user_id=$request->get('user_id');
           $message_id=$request->get('message_id');
           DB::table('communications')->where('message_id',$message_id)->where('user_id',$user_id)->delete();
           $messages=DB::table('communications')->where('user_id', $user_id)->get();
           return self::responseObject(200,"Message id {$message_id} deleted successfully !", $messages);
       }
       catch(\Exception $e){
           return self::responseObject(300,$e->getMessage());
       }
     }

    public static function deleteUserProduct($request){
        try{
           $user_id=$request->get('user_id');
           $product_id=$request->get('product_id');
           if($user_id && $product_id){
              $product_table=self::getProductsTable($user_id);
              DB::table($product_table)->where('user_id',$user_id)->where('product_id',$product_id)->delete();
              $products=DB::table($product_table)->where('user_id', $user_id)->get();
              return self::responseObject(200,"Product Id {$product_id} deleted successfully !", $products);
           }
           else{
              return self::responseObject(400,"Missing Parameters, User ID & Product ID is mandatory !");
           }
        }
        catch(\Exception $e){
           return self::responseObject(403,$e->getMessage());
        }
    }

    public static function deleteCustomerVoucher($user_id,$voucher_id){
        try{
            if($user_id && $voucher_id){
                  $voucher_table=self::getUserVoucherTable($user_id);
                  DB::table($voucher_table)->where('voucher_id',$voucher_id)->delete();
                  $vouchers=DB::table($voucher_table)->get();
                  return self::responseObject(200,"Voucher id {$voucher_id} deleted successfully !", $vouchers);
            }
            else{
                 return self::responseObject(400,"Missing Parameters, UserID and VoucherID is mandatory !",null);
            }
      }
      catch(\Exception $e){
            return self::responseObject(403,$e->getMessage());
      }
    }

###########################################################
//Update Webservice Requests
##########################################################

    public static function updateLastLogin($user_id){
        if($user_id) {
            $current_time=date("Y-m-d H:i:s",time()); //We have to think about the timezone later on. Currently it is UTC as per Laravel.
            DB::table("users")->where('user_id', $user_id)->update(['last_login'=>$current_time]);
        }
    }

    public static function changeUserPassword($new_password,$user_id){
        try{
              if($new_password && $user_id){
                  DB::table('users')->where('user_id', $user_id)->update(array('password' => md5($new_password)));
                  return self::responseObject(200,"User Account Password Changed Successfully!",md5($new_password));
              }
              else{
                  return self::responseObject(400,"Parameters Missing, User Id & Password is mandatory !");
              }
        }
        catch(\Exception $e){
              return self::responseObject(403,$e->getMessage());
        }
    }
    public static  function changeVoucherEnableDisable($user_id,$voucher_id,$status){
      try{
            $voucher_table=self::getUserVoucherTable($user_id);
            if($voucher_table && $user_id){
                DB::table($voucher_table)->where('voucher_id',$voucher_id)->update(array('enabled'=>$status));
                $vouchers=DB::table($voucher_table)->get();
                $ed=($status==1)?"Enabled":"Disabled";
                return self::responseObject(200,"Voucher id {$voucher_id} $ed Successfully !", $vouchers);
            }
            else{
                return self::responseObject(400,"User Id, Voucher Id and Voucher Redemption Status is missing !",null);
            }
      }
      catch(\Exception $e){
           return self::responseObject(403,$e->getMessage());
      }
    }

    public static function changeVoucherRedemptionStatus($user_id,$voucher_id,$redemption_status){
        try{
            if($user_id && $voucher_id && $redemption_status){
                $voucher_table=self::getUserVoucherTable($user_id);
                $now=date("Y-m-d h:i:s");
                DB::table($voucher_table)->where('voucher_id',$voucher_id)->update(array('redemption_status'=>$redemption_status,'redeemed_on'=>$now));
                $vouchers=DB::table($voucher_table)->get();
                $ed=($redemption_status==1)?"Redeemed":"Un-Redeemed";
                return self::responseObject(200,"Voucher id {$voucher_id} $ed Successfully !", $vouchers);
            }
            else{
                return self::responseObject(400,"User Id, Voucher Id and Voucher Redemption Status are mandatory !",null);
            }
       }
       catch(\Exception $e){
            return self::responseObject(403,$e->getMessage());
       }
    }

    protected static function editVoucherDetails($request){
        try {
            $user_id = $request->get('user_id');
            $voucher_id = $request->get('voucher_id');
            $update_data = array();
            $update_data['redemption_status'] = $request->get('redemption_status');
            $update_data['validity'] = $request->get('voucher_validity');
            if (intval($request->get('product_linked'))!=null){
                $update_data['product_linked'] = $request->get('product_linked');
              }
            $update_data['enabled'] = $request->get('enabled');
            $update_data['created_on'] = $request->get('created_on');
            if($request->get('redeemed_on')){
               $update_data['redeemed_on'] = $request->get('redeemed_on');
            }
            if ($request->get('notes')){
                $update_data['notes'] = $request->get('notes');
            }

            if ($user_id && $voucher_id) {
                $voucher_table = self::getUserVoucherTable($user_id);
                DB::table($voucher_table)->where('voucher_id', $voucher_id)->update($update_data);
                $vouchers = DB::table($voucher_table)->get();
                return self::responseObject(200, "Voucher id {$voucher_id} updated Successfully !", $vouchers);
            } else {
                return self::responseObject(400, "Parameters missing, UserID and VoucherID are mandatory !", null);
            }
        }catch (\Exception $e){
            return self::responseObject(403, $e->getMessage(), null);
        }
    }

    protected static function editProductDetails($request){
        try {
            $user_id = $request->get('user_id');
            $update_data = array();
            $update_data['product_name'] = $request->get('product_name');
            $update_data['specification'] = $request->get('specification');
            $update_data['specification_options']=$request->get('specification_options');
            $update_data['price']=$request->get('price');
            $update_data['quantity']=$request->get('quantity');
            $product_id=$request->get('product_id');
            $product_image=$request->file('product_image');

            if($product_image){
                $destination_path=storage_path('product_images');
                $product_image_name=time()."_".str_replace(" ","_",$product_image->getClientOriginalName());
                $product_image->move($destination_path,$product_image_name);
                $update_data['product_image']=$product_image_name;
            }
            $validation=self::validateProductDetails($request);
            if($validation['result']==true) {
                $product_table = self::getProductsTable($user_id);
                DB::table($product_table)->where('product_id', $product_id)->update($update_data);
                $products = DB::table($product_table)->get();
                return self::responseObject(200, "Product Details updated Successfully !", $products);
            } else {
                return self::responseObject(400,$validation['validation_message'], null);
            }
        }
        catch (\Exception $e){
            return self::responseObject(403, $e->getMessage(), null);
        }
    }

    private static function validateProductDetails($request,$ignore_product_id=false){
        $validation_result=array();
        $msg=array();
        if($request->get('user_id')==null){
            $msg[]="User id is missing";
        }
        if($request->get('product_id')==null && $ignore_product_id==false){
            $msg[]="Product Id  is missing";
        }
        if($request->get('product_name')==null){
            $msg[]="Product Name  is missing";
        }
        if($request->get('specification')==null){
            $msg[]="Product Specification  is missing";
        }
        if($request->get('price')==null){
            $msg[]="Price is missing";
        }
        if($request->get('quantity')==null){
            $msg[]="Quantity is missing";
        }
        if($request->get('specification_options')==null){
            $msg[]="Specification option is missing";
        }
        if($request->get('specification_options')){
            $so=$request->get('specification_options');
            $so_explode=explode("|",$so);
            foreach($so_explode as $key=>$value){
                $reverse_value=strrev($value);
                 //This is doing our job for regular expression, i am quite week in regex, LOL ;)
                if(strpos($value,":") > strpos($value,",") || substr_count($value,":")==0 || substr_count($value,",")==0 || substr_count($value,":") > 1 || substr_count($value,",,") || $reverse_value[0]=="," || $reverse_value[0]==":" || $value[0]==":" || $value[0]==","){
                    $msg[]="Specifications options format not supported";
                }
            }
        }

        $msg=array_unique($msg);
        $validation_result['validation_message']=implode(", ",$msg);
        $validation_result['result']=(sizeof($msg)==0)?true:false;

        return $validation_result;

    }

    protected static function saveCompanyProfileDetails($request){
        try{
            //Create the field array.
            $update=array();
            $user_id=$request->get('user_id');
            $update['email']=$request->get('company_email');
            $update['company_name']=$request->get('company_name');
            $update['paypal_email']=$request->get('paypal_email');
            $update['currency']=$request->get('currency');
            $update['opted_plan']=str_replace("plan_","",$request->get('opted_plan'));
            //check that the logo is present or not.
            $company_logo=$request->file('company_logo');
            if($company_logo){
                $destination_path=storage_path('company_logos');
                $company_logo_name=time()."_".str_replace(" ","_", $company_logo->getClientOriginalName());
                $company_logo->move($destination_path, $company_logo_name);
                $update['company_logo']=$company_logo_name;
            }
            DB::table('users')->where('user_id',$user_id)->update($update);
            $user_details=DB::table('users')->where('user_id',$user_id)->first();
            return self::responseObject(200,"Company Profile Information Saved Successfully, Please try login again to reflect the changes !",$user_details);

        }
        catch(\Exception $e){
            return self::responseObject(400, $e->getMessage(), null);
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
