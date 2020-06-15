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
<div class="container" id="bidi-recycle-container">
	<div class="row">
		<div class="col-md-4">
			<h1 style="color:#80bb42; font-weight:600;" class="padding-top-60">Return Your Used	Bidi™ Sticks</h1>
			<p>Let’s take care of the environment together. Join our recycling program today!</p>
			<p>
			Simply return your used Bidi Sticks to us, and we will take care of the rest. For every ten (10) used Bidi Sticks that you recycle, we will send you one (1) FREE Bidi Stick back as a form of gratitude for participating in our cause to help the environment!
			</p>
			<p>Fill out this form below for us to generate a return label for you to use in shipping your used Bidi Sticks.</p>
		</div>
		
		<div class="col-md-8">
			<div class="container-form ">
			    <!-- <form method="POST" action="<?php //echo $this->plugin_url . 'templates/submit/pageSubmit.template.php'; ?>"> -->
	 			<form id="form-recycle" method="POST">
	 				<input type="hidden" name="current_user_id" value="<?php echo get_current_user_id(); ?>" >

					<div class="row">
						<div class="input-container col-md-6">
							<label for="fname">First Name</label>
							<input type="text" class="form-control" id="fname" name="from_firstname" value="<?php echo $billing_first_name; ?>" placeholder="<?php echo $billing_first_name; ?>" readonly>
						</div>
						<div class="input-container col-md-6">
							<label for="lname">Last Name</label>
							<input type="text" class="form-control" id="lname" name="from_lastName" value="<?php echo $billing_last_name; ?>" placeholder="<?php echo $billing_last_name; ?>" readonly>
						</div>
					</div>

					<div class="row">
						<div class="input-container col-md-6">
							<label for="email">Email</label>
							<input type="email" class="form-control" id="email" name="from_email" value="<?php echo $billing_email; ?>" placeholder="<?php echo $billing_email; ?>" readonly>
						</div>
						<div class="input-container col-md-6">
							<label for="phone">Phone</label>
							<input type="text" class="form-control" id="phone" name="from_phone_number" value="<?php echo $billing_phone; ?>" placeholder="<?php echo $billing_phone; ?>" readonly>
						</div>
					</div>
					<div class="row">
						<div class="input-container col-md-6">
							<label for="addressNo">Address</label>
							<input type="text" class="form-control" id="addressNo" name="from_address" value="<?php echo $billing_address_1; ?>" placeholder="<?php echo $billing_address_1; ?>" readonly>
						</div>
						<div class="input-container col-md-6">
							<label for="addressCity">City</label>
							<input type="text" class="form-control" id="addressCity" name="from_city" value="<?php echo $billing_city; ?>" placeholder="<?php echo $billing_city; ?>" readonly>
						</div>
					</div>
					<div class="row">
						<div class="input-container col-md-6">
							<label for="country-state">US State</label>
							<input type="text" class="form-control" id="country-state" name="from_state" value="<?php echo $billing_state; ?>" placeholder="<?php echo $billing_state; ?>" readonly>
						</div>
						<div class="input-container col-md-6">
							<label for="addressZC">Zip Code</label>
							<input type="text" class="form-control" id="addressZC" name="from_postcode" value="<?php echo $billing_postcode; ?>" placeholder="<?php echo $billing_postcode; ?>" readonly>
						</div>
					</div>
					<div class="input-container margin-top-16">
						<label for="storeLocatorPicker">Type In or Select Store :</label>
						<select class="selectpicker form-control" data-live-search="true" name="store_locator">
							<option>Select Store</option>
						    <?php
								global $wpdb;
								$stores = $wpdb->get_results ( "
								    SELECT * 
								    FROM  $wpdb->posts
								        WHERE post_type = 'wpsl_stores'
								" );
								var_dump($stores);		
								foreach ( $stores as $store )									{
								   echo '<option data-tokens="'.$store->post_title.'">'.$store->post_title.'</option>';
								}
							?>
							<option data-tokens="Others">Others</option>
						</select>
					</div>
					<div class="input-container margin-top-16">
						<label for="bidistick_qty">Quantity of Bidi Sticks you want to recycle</label>
						<select class="form-control" id="bidistick_qty" name="bidistick_qty">
							<option value="0">SELECT</option>
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
						</select>
					</div>

					<div class="input-container margin-top-16">
						<fieldset>
							<legend>Shipping Details:</legend>
							<div class="col-md-6">
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
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="ShipDate">Ship Date:</label>
									<p class="ShipDate"></p>
								</div>

								<div class="form-group">
									<label for="DeliverDays">Deliver Days:</label>
									<p class="DeliverDays"></p>
								</div>
							</div>
						</fieldset>
					</div>

					<div class="input-container margin-top-16">
						<label for="note">Note</label>
						<textarea id="note" class="form-control" name="note" placeholder="Enter your note" style="height:200px"></textarea>
					</div>
					<div class="input-container" style="text-align:center;">
						<input class="margin-top-25" id="recycle-submit" style=" text-transform: uppercase; font-weight: 600" type="submit" value="Submit Details now" disabled>
					</div>
			  	</form>
			</div>	
		</div>	
	</div>
</div>

<div id="loader"></div>
<?php 
	}
}