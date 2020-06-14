<!-- Just show the Billing Address form -->
<form method='post' action='' onsubmit='saveBillingAddressDetails(event)' id='billing_address_form' class='billing_address_form'>
	<h4>Billing Address</h4>
		<div class="form-group">
		    <label class='required'>Address</label>
		    <input required='required' class='form-control' value="<?php echo $address_line_1; ?>" type='text' id='address_line_1' name='address_line_1' placeholder="Address Line 1">
		    <input class='form-control' value="<?php echo $address_line_2; ?>" type='text' name='address_line_2' id='address_line_2' placeholder="Address Line 2" style='margin-top:2px'>
		    <label class='required'>City</label>
		    <input required='required' class='form-control' value="<?php echo $city; ?>" id='city' type='text' name='city' placeholder="Enter your city">         
		    <label class='required'>State</label>
		    <input required='required' class='form-control' value="<?php echo $state; ?>" id='state' type='text' name='state' placeholder="Enter your state">    
		    <label class='required'>Postal Code</label>
		    <input required='required' class='form-control' value="<?php echo $postal_code; ?>" id='postal_code' type='text' name='postal_code' placeholder="Enter your zip code"> 
		    <label class='required'>Country</label>
		    <select onchange='ChangePhoneCountryCode()' required="required" class="form-control" id='country' type='text' name='country' placeholder="Select your country">
		    </select> 	
		    <input type='hidden' value="<?php echo $country; ?>" id='country_hidden' /> 
		    <label class='required'>Phone</label>
		    <div class='input-group'>
		    <div class="input-group-prepend"><span id='country_dial_code' class="input-group-text"></span></div>
		    <input required='required' maxlength='10' value="<?php echo $phone; ?>" class='form-control' id='phone' type='text' name='phone' placeholder="Enter your 10 digit phone number.">
		    </div>
        </div>
        <div class='form-group'> 
        	<input type='hidden' id='csrf_token' name='csrf_token' value='<?php echo csrf_token(); ?>'>
        	<button type='button' onclick='loadVoucherInputForm()' class='btn btn-primary float-left' name='voucher_input_back'>Back</button>
        	<button class="btn btn-info float-right" name="submit-billing-address" ><i id='loading' class="fa fa-spin fa-spinner" aria-hidden="true"></i> Next</button>
        </div>	
        <br><br>
</form>	
