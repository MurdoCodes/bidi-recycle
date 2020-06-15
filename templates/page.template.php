<?php
/**
* @package Bidi Recycle Program
*/
use Includes\Base\BaseController;
use Includes\Base\CustomerOrder;
use Includes\StampsAPI\StampService;
use Includes\StampsAPI\Address;

	/**
	*	Declare variable that contains current user details from wp_user table
	**/
	
	if(wp_get_current_user()){
	/**
	* Get Customer Details
	**/	
	$user_meta = get_user_meta( get_current_user_id() );
	
  	/*
  	* If $user_meta is not null
  	*/
    if($user_meta){
    /**
	* Storing customer details to variables
	**/
	$billing_first_name = $user_meta['billing_first_name'][0];
	$billing_last_name = $user_meta['billing_last_name'][0];
	$billing_email = $user_meta['billing_email'][0];
	$billing_address_1 = $user_meta['billing_address_1'][0];
	$billing_phone = $user_meta['billing_phone'][0];
	$billing_country = $user_meta['billing_country'][0];
	$billing_postcode = $user_meta['billing_postcode'][0];
	$billing_city = $user_meta['billing_city'][0];
	$billing_state = $user_meta['billing_state'][0];

?>
<!-- <form method="POST" action="<?php //echo $this->plugin_url . 'templates/submit/pageSubmit.template.php'; ?>"> -->
 <form id="form-recycle" method="POST">
	<input type="hidden" name="current_user_id" value="<?php echo get_current_user_id(); ?>" >
	<div class="container">
		<div class="row">
				<div class="col-md-12">
					<h2 style="text-align:center;">BIDI CARES RECYCLING MOVEMENT</h2>
    				<h4 style="text-align:center;"><b>Are you ready to help save the environment?</b> Bidi Cares is our sustainable initiative where you can get involved simply by returning your used Bidi Sticks. As a token of appreciation for your eco-friendly decision, we give you a <b>FREE</b> Bidi Stick at your next purchase for every 10 used Bidi Stick you ship back to us. </br></br>After collecting your 10 used Bidi Sticks, fill out the form below, pay for the shipping fee, and we will send you the return label. Kindly return the Bidi Sticks only. Do not include the whole packaging to avoid return label cost differences on actual shipment.</br></br></h4>
				</div>
				<div class="col-md-12 user-details default-container-border">
					<header>
						<h1 style="font-size:2.222em !important;line-height: 1 !important;">CONTACT DETAILS</h1>
					</header>
					
					<hr>

					<div class="content col-md-12">
						<div class="col-md-6">
							<div class="form-group">
						    	<label for="firstName">First Name:</label>
						    	<input type="text" class="form-control" name="from_firstname" value="<?php echo $billing_first_name; ?>" placeholder="<?php echo $billing_first_name; ?>" readonly>
						  	</div>

						  	<div class="form-group">
						    	<label for="lastName">Last Name:</label>
						    	<input type="text" class="form-control" name="from_lastName" value="<?php echo $billing_last_name; ?>" placeholder="<?php echo $billing_last_name; ?>" readonly>
						  	</div>

						  	<div class="form-group">
						    	<label for="email">Email Address:</label>
						    	<input type="email" class="form-control" name="from_email" value="<?php echo $billing_email; ?>" placeholder="<?php echo $billing_email; ?>" readonly>
						  	</div>
							
							<div class="form-group">
						    	<label for="email">Address:</label>
						    	<input type="text" class="form-control" name="from_address" value="<?php echo $billing_address_1; ?>" placeholder="<?php echo $billing_address_1; ?>" readonly>
						  	</div>


						  	<div class="form-group">
						    	<label for="note">Phone :</label>
						    	<input type="text" class="form-control" name="from_phone_number" value="<?php echo $billing_phone; ?>" placeholder="<?php echo $billing_phone; ?>" readonly>
						  	</div>

						  	<div class="form-group">
						    	<label for="country">Country:</label>
						    	<input type="text" class="form-control" name="from_country" value="<?php echo $billing_country; ?>" placeholder="<?php echo $billing_country; ?>" readonly>
						  	</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
						    	<label for="postcode">Postcode:</label>
						    	<input type="text" class="form-control" name="from_postcode" value="<?php echo $billing_postcode; ?>" placeholder="<?php echo $billing_postcode; ?>" readonly>
						  	</div>

							<div class="form-group">
						    	<label for="city">City:</label>
						    	<input type="text" class="form-control" name="from_city" value="<?php echo $billing_city; ?>" placeholder="<?php echo $billing_city; ?>" readonly>
						  	</div>

						  	<div class="form-group">
						    	<label for="state">State:</label>
						    	<input type="text" class="form-control" name="from_state" value="<?php echo $billing_state; ?>" placeholder="<?php echo $billing_state; ?>" readonly>
						  	</div>
							
						  	<div class="form-group">
								<label for="storeLocatorPicker">Type In or Select Store :</label>
								<select class="selectpicker form-control" data-live-search="true">
									<option>Select Store</option>
								    <?php
										global $wpdb;
										$stores = $wpdb->get_results ( "
										    SELECT * 
										    FROM  $wpdb->posts
										        WHERE post_type = 'wpsl_stores'
										" );

										foreach ( $stores as $store )									{
										   echo '<option data-tokens="'.$store->post_name.'">'.$store->post_name.'</option>';
										}
									?>
									<option data-tokens="Others">Others</option>
								</select>
							</div>

							<div class="form-group">
							  <label for="sel1">Quantity of Sticks to return :</label>
							  <select class="form-control" id="sel1" name="bidistick_qty">
							    <option value="0">SELECT</option>
							    <option value="10">10</option>
							    <option value="20">20</option>
							    <option value="30">30</option>
							  </select>
							</div>
						</div>					
					</div>
				</div>
		</div>


		<div class="row" style="margin-top:.5em;">
			<div class="col-md-12 mail-return default-container-border">
				<header>
					<h3>Shipping Details : </h3>
					<p style="color:#fff;margin-bottom: 1% !important;margin-bottom:1% !important;"><em>Kindly double check you added the correct products above and that your contact information is up to date. If all information is correct, fill in your card information so you can proceed with the shipping payment, and help save our planet.</em></p>
					<input type="hidden" class="form-control" id="totalItemWeight" name="totalItemWeight" value="">
				</header>
				
				<hr>
				<div class="content col-md-12">
					<div class="col-md-3">
						
						<h4 style="color:#fff;font-weight: bold;">Package Details</h4>
						<div class="col-md-12">
							<div class="form-group">
								<label for="serviceType">Service Type:</label>
								<p class="serviceType"></p>
							</div>

							<div class="form-group">
								<label for="totalItemWeight">Total Item Weight in oz:</label>
								<p class="totalItemWeight"></p>
							</div>

							<div class="form-group">
								<label for="returnedRate">Amount:</label>
								<p class="returnedRate"></p>
							</div>

							<div class="form-group">
								<label for="ShipDate">Ship Date:</label>
								<p class="ShipDate"></p>
							</div>

							<div class="form-group">
								<label for="DeliverDays">Deliver Days:</label>
								<p class="DeliverDays"></p>
							</div>
						</div>

					</div>
					<div class="col-md-5">

						<h4 style="color:#fff;font-weight: bold;">Ship To : </h4>

						<div class="col-md-6">
							<div class="form-group">
								<label for="ShippingFullName">Full Name :</label>
								<p>BIDI CARES</p>
							</div>

							<div class="form-group">
								<label for="ShippingEmail">Email :</label>
								<p><a href="mailto:support@bidivapor.com" style="color:#fff;"><b>support@bidivapor.com</b></a></p>
							</div>

							<div class="form-group">
								<label for="ShippingPhone">Phone :</label>
								<p>(833) 367-2434</p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="ShippingStreetAddress">Address :</label>
								<p>BIDI CARES</p>
								<p>4460 OLD DIXIE HWY</p>
								<p>GRANT</p>
								<p>Florida, 32949</p>
							</div>
						</div>

					</div>
					<div class="col-md-4">
						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" name="submit" class="form-control btn btn-success btn-lg" id="recycle-submit" disabled>Confirm Recycle</button>
							</div>
						</div>
					</div>
				</div>				
			</div>	
		</div>

	</div>
</form>

<div id="loader"></div>
<?php 
	}
}