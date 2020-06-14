var playground=document.getElementById('playground'); 

function submitVoucherForm(event){ 
    event.preventDefault();
    var error_indicator=document.getElementById('error_text')
    var voucher_form=document.getElementById('voucher-input-form');
    var voucher_field=voucher_form.elements.namedItem('vouchers_textarea').value;
    var loading=document.getElementById('loading');
    error_indicator.innerHTML=""; 
    if(voucher_field==null || voucher_field==undefined || voucher_field==""){
        document.getElementById('error_text').innerHTML="Please Enter the Voucher Ids to proceed further !";
        return false;
    }
	var entered_vouchers=btoa(voucher_field).split("=").join("");
    var csrf_token=voucher_form.elements.namedItem('csrf_token').value;  
    loading.style.display="inline-block"; 
	    var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response=JSON.parse(this.responseText);
                if(response.invalid_result.length){
                    error_indicator.innerHTML="<b>"+response.invalid_result.join(",")+"</b> is/are invalid vouchers !"; 
                }
                else{
                    loadBillingAddressForm();
                }
                    loading.style.display="none"; 
            }
            if(this.readyState==4 && this.status >=300){
                    error_indicator.innerHTML="Server Error : "+xmlhttp.status+"-"+xmlhttp.statusText;
                    loading.style.display="none"; 
            }
        }; 
        xmlhttp.open("post",root_url+"/validate-vouchers",true); 
        xmlhttp.setRequestHeader('X-CSRF-TOKEN', csrf_token);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
        xmlhttp.send("entered_vouchers="+entered_vouchers);    
	return false;  
}

function loadVoucherInputForm(){
	loadingPlayGround(); 
	var playground=document.getElementById('playground');
    //show product listing page.
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
    	if(this.readyState==4 && this.status ==200){
    		//Show the form.
    		playground.innerHTML=this.responseText; //This will be the normal HTML template.
    	}
    	if(this.readyState==4 && this.status >=300){
            playground.innerHTML="Server Error : "+xmlhttp.status+"-"+xmlhttp.statusText;
    	} 
    }
    xmlhttp.open("get",root_url+"/voucher-redeem",true); 
    xmlhttp.send(); 
}

function changeShippingAddressRequiredFields(required){ 
		
		var billing_address_form=document.getElementById('shipping_address_form'); 
		var address_line_1=billing_address_form.elements.namedItem('address_line_1');
		var address_line_2=billing_address_form.elements.namedItem('address_line_2');
		var city=billing_address_form.elements.namedItem('city');
		var state=billing_address_form.elements.namedItem('state');
		var phone=billing_address_form.elements.namedItem('phone');
		var country=billing_address_form.elements.namedItem('country'); 
		var postal_code=billing_address_form.elements.namedItem('postal_code');

		address_line_1.required=required;
		address_line_2.required=required;
		city.required=required;
		state.required=required;
		phone.required=required;
		country.required=required;
		postal_code.required=required;
}

function showHideShippingAddressBlock(){
	var shipping_billing_same=document.getElementById('shipping_billing_same_yes').checked;
	var shipping_address_block=document.getElementById('shipping_address_block');
	if(shipping_billing_same){
		shipping_address_block.style.display='none';
		changeShippingAddressRequiredFields(false); 
	}
	else{
		shipping_address_block.style.display='block'; 
		changeShippingAddressRequiredFields(true);   
	}
}

function loadingPlayGround(){ 
	var playground=document.getElementById('playground');
    playground.innerHTML="<div style='text-align:center;margin-bottom:20px'><img style='height:200px' src='https://sezeromer.com/wp-content/uploads/2019/09/Infinity-1s-200px.gif'><br>Loading, Please Wait ...</div>";
}

function loadBillingAddressForm(){ 
	loadingPlayGround(); 
	var playground=document.getElementById('playground');
    //show product listing page.
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
    	if(this.readyState==4 && this.status ==200){
    		//Show the form.
    		playground.innerHTML=this.responseText; //This will be the normal HTML template.
    		loadCountries('country'); 
    	}
    	if(this.readyState==4 && this.status >=300){
            playground.innerHTML="Server Error : "+xmlhttp.status+"-"+xmlhttp.statusText; 
    	} 
    }
    xmlhttp.open("get",root_url+"/billing-address",true); 
    xmlhttp.send(); 
}

function loadCountries(field_id){ 
   var country_field=document.getElementById(field_id);
   var countries_options="<option value='' dial-code='00'>--SELECT COUNTRY --</option>"; 
   for(var i=0;i<countries_phone_code.length;i++){
      countries_options+="<option dial-code='"+countries_phone_code[i]['dial_code']+"' value='"+countries_phone_code[i]['name']+"'>"+countries_phone_code[i]['name']+"</option>"; 
   }
   country_field.innerHTML=countries_options;   
   country_field.value=document.getElementById('country_hidden').value; 
   ChangePhoneCountryCode();
}

function ChangePhoneCountryCode(){
	var dial_code_text=document.getElementById('country_dial_code'); 
	var country_field=document.getElementById('country'); 
	var selected_index=country_field.selectedIndex; 
	var selected_option=country_field.options[selected_index];
	dial_code_text.innerHTML=selected_option.getAttribute('dial-code'); 
}

function saveBillingAddressDetails(event){
	event.preventDefault(); 
	var playground=document.getElementById('playground'); 
	var csrf_token=document.getElementById('csrf_token').value; 
	var loading=document.getElementById('loading'); 
	var billing_address_form=document.getElementById('billing_address_form'); 
	var address_line_1=billing_address_form.elements.namedItem('address_line_1');
	var address_line_2=billing_address_form.elements.namedItem('address_line_2');
	var city=billing_address_form.elements.namedItem('city');
	var state=billing_address_form.elements.namedItem('state');
	var phone=billing_address_form.elements.namedItem('phone');
	var country=billing_address_form.elements.namedItem('country'); 
	var postal_code=billing_address_form.elements.namedItem('postal_code');
	let error=0;

	if(address_line_1.value==''){
		error=1;
		address_line_1.classList.add('has-error'); 
	}
	else{
		address_line_1.classList.remove('has-error'); 
	}

	if(city.value==''){
		error=1;
		city.classList.add('has-error');
	}
	else{
		city.classList.remove('has-error');
	}

	if(state.value==''){
		error=1;
		state.classList.add('has-error');
	}
	else{
		state.classList.remove('has-error');
	}

	if(phone.value==''){
		error=1;
		phone.classList.add('has-error');
	}
	else{
		phone.classList.remove('has-error');
	}

	if(postal_code.value==''){
		error=1;
		postal_code.classList.add('has-error');
	}
	else{
		postal_code.classList.remove('has-error');  
	}

	if(country.value==''){
		error=1;
		country.classList.add('has-error');
	}
	else{
		country.classList.remove('has-error'); 
	}

	if(error){
		return false;
	}

    loading.style.display='inline-block';
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if(this.readyState==4 && this.status==200){
            loading.style.display='none';
            loadShippingAddressForm();
		}
		if(this.readyState==4 && this.status >=300){
            playground.innerHTML="Server Error : "+xmlhttp.status+"-"+xmlhttp.statusText;
		}
	}
	xmlhttp.open('post',root_url+'/save-billing-address',true);
	xmlhttp.setRequestHeader('X-CSRF-TOKEN', csrf_token);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("address_line_1="+address_line_1.value+"&address_line_2="+address_line_2.value+"&city="+city.value+"&state="+state.value+"&country="+country.value+"&postal_code="+postal_code.value+"&phone="+phone.value);
}


function saveShippingAddressDetails(event){
	event.preventDefault(); 
	var shipping_billing_same=document.getElementById('shipping_billing_same_yes').checked;
	var playground=document.getElementById('playground'); 
	var csrf_token=document.getElementById('csrf_token').value; 
	var loading=document.getElementById('loading');

	if(shipping_billing_same==false){ 

			var billing_address_form=document.getElementById('shipping_address_form'); 
			var address_line_1=billing_address_form.elements.namedItem('address_line_1');
			var address_line_2=billing_address_form.elements.namedItem('address_line_2');
			var city=billing_address_form.elements.namedItem('city');
			var state=billing_address_form.elements.namedItem('state');
			var phone=billing_address_form.elements.namedItem('phone');
			var country=billing_address_form.elements.namedItem('country'); 
			var postal_code=billing_address_form.elements.namedItem('postal_code');
		   
			var address_line_1=billing_address_form.elements.namedItem('address_line_1');
			var address_line_2=billing_address_form.elements.namedItem('address_line_2');
			var city=billing_address_form.elements.namedItem('city');
			var state=billing_address_form.elements.namedItem('state');
			var phone=billing_address_form.elements.namedItem('phone');
			var country=billing_address_form.elements.namedItem('country'); 
			var postal_code=billing_address_form.elements.namedItem('postal_code');
			let error=0;

			if(address_line_1.value==''){
				error=1;
				address_line_1.classList.add('has-error'); 
			}
			else{
				address_line_1.classList.remove('has-error'); 
			}

			if(city.value==''){
				error=1;
				city.classList.add('has-error');
			}
			else{
				city.classList.remove('has-error');
			}

			if(state.value==''){
				error=1;
				state.classList.add('has-error');
			}
			else{
				state.classList.remove('has-error');
			}

			if(phone.value==''){
				error=1;
				phone.classList.add('has-error');
			}
			else{
				phone.classList.remove('has-error');
			}

			if(postal_code.value==''){
				error=1;
				postal_code.classList.add('has-error');
			}
			else{
				postal_code.classList.remove('has-error');  
			}

			if(country.value==''){
				error=1;
				country.classList.add('has-error');
			}
			else{
				country.classList.remove('has-error'); 
			}

			if(error){
				return false;
			}
	}

    loading.style.display='inline-block';
	var xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function(){
		if(this.readyState==4 && this.status==200){
            loading.style.display='none';
            loadShoppingCart();
		}
		if(this.readyState==4 && this.status >=300){
            playground.innerHTML="Server Error : "+xmlhttp.status+"-"+xmlhttp.statusText;
		}
	}
	xmlhttp.open('post',root_url+'/save-shipping-address',true);
	xmlhttp.setRequestHeader('X-CSRF-TOKEN', csrf_token);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if(shipping_billing_same==false){
	   xmlhttp.send("shipping_billing_same=0&address_line_1="+address_line_1.value+"&address_line_2="+address_line_2.value+"&city="+city.value+"&state="+state.value+"&country="+country.value+"&postal_code="+postal_code.value+"&phone="+phone.value);
	}
	else{
		xmlhttp.send("shipping_billing_same=1"); 
	}

}

function loadShippingAddressForm(){
	loadingPlayGround(); 
	var playground=document.getElementById('playground');
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
    	if(this.readyState==4 && this.status ==200){
    		//Show the form.
    		playground.innerHTML=this.responseText; //This will be the normal HTML template.
    		loadCountries('country');
    	}
    	if(this.readyState==4 && this.status >=300){
            playground.innerHTML="Server Error : "+xmlhttp.status+"-"+xmlhttp.statusText;
    	} 
    }
    xmlhttp.open("get",root_url+"/shipping-address",true); 
    xmlhttp.send(); 
}

function loadShoppingCart(){
    loadingPlayGround(); 
	var playground=document.getElementById('playground');
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function(){
    	if(this.readyState==4 && this.status ==200){
    		//Show the form.
    		playground.innerHTML=this.responseText; //This will be the normal HTML template.
    	}
    	if(this.readyState==4 && this.status >=300){
            playground.innerHTML="Server Error : "+xmlhttp.status+"-"+xmlhttp.statusText;
    	} 
    }
    xmlhttp.open("get",root_url+"/shopping-cart",true);  
    xmlhttp.send(); 
}