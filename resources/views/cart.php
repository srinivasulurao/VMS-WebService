<!-- Just Show the cart -->
<div class='shopping-cart'>
	<h4>Shopping Cart</h4>
	<form method='post' action=''>
		<div class='form-group'>
			<div class='products col-md-8' style='padding-left: 0'>
				<?php 
				$counter=1;
                foreach($products as $product):
                	$product_image=url(Storage::url("product_images/".$product->product_image));
                	$product_price=number_format($product->price,2); 
                	$product_options="";
                	$specifications=@explode("|",$product->specification_options);  
                	    foreach($specifications as $specification):
                	    	$specification_break=@explode(":",$specification);
                	    	$specification_options_values=@explode(",",$specification_break[1]);
                	    	$product_options.="<label class='product_options_label'>{$specification_break[0]}</label> : <select class='form-control product_options'><option>--Select--</option>";
                	    	foreach($specification_options_values as $product_option): 
                	    		$product_options.="<option value='$product_option'>$product_option</option>";
                	    	endforeach;	
                	    	$product_options.="</select><br>"; 
                	    endforeach;	 
                    $quantity_box="<div class='input-group float-right'><div class='input-group-prepend'><button type='button' class='btn btn-danger'>--</button></div><input style='width:40px;padding-left: 0px;text-align: center !important;padding-right: 0px;' class='form-control' value='1' type='text'><div class='input-group-append'><button type='button' class='btn btn-primary'>+</button></div></div>";
                	echo "<div class='product_block'>"; 
                	echo "<div class='col-md-3'><img class='img-thumbnail product_image' src='$product_image'></div>";
                	echo "<div class='col-md-9' style='vertical-align:top'>";
                	echo "<h5>{$product->product_name} <span class='float-right'>{$quantity_box}</span></h5>";
                	echo "<div class='product_option_box'>$product_options</div>";
                	echo "<div class='float-right'>$currency_symbol {$product_price}"; 
                	echo "</div></div></div>"; 
                	if(count($products) != $counter){
                	echo "<hr>";
                    }
                    $counter++; 
                endforeach;
				?>
				<div class='alert alert-warning' style='top:30px;position: relative;'><i class='fa fa-info-circle'></i> Do not delay the purchase, adding items to your cart does not mean booking them.</div>
			</div>

			<!-- Show Total Price and Checkout Option -->
			<div class='checkout col-md-4'>
		    </div>		
		</div>	
		<button class='btn btn-primary' type='button' onclick='loadShippingAddressForm()'>Back</button>
		<button class='btn btn-info float-right' type='button'>Next</button>
	</form>
</div>	
