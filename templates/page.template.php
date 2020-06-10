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
			<div class="row">
				<div class="col-md-12">
					<h2 style="text-align:center;">BIDI CARES RECYCLING MOVEMENT</h2>
    				<h4 style="text-align:center;"><b>Are you ready to help save the environment?</b> Bidi Cares is our sustainable initiative where you can get involved simply by returning your used Bidi Sticks. As a token of appreciation for your eco-friendly decision, we give you a <b>FREE</b> Bidi Stick at your next purchase for every 10 used Bidi Stick you ship back to us. </br></br>After collecting your 10 used Bidi Sticks, fill out the form below, pay for the shipping fee, and we will send you the return label. Kindly return the Bidi Sticks only. Do not include the whole packaging to avoid return label cost differences on actual shipment.</br></br></h4>
				</div>
			</div>
			<div class="col-md-8">
				
				<div class="product-list default-container-border">
					<header>
						<h1>RECYCLE</h1>
						<button type="button" class="btn btn btn-success btn-md" id="buttonModal" data-toggle="modal" data-target="#selectProductModal">Add Product</button>
					</header>

					<hr>

					<div class="content" id="product-scroll-bar">
						<!-- Append Products Here -->
					</div>

				</div>

			</div>

			<div class="col-md-4">
				
				<div class="user-details default-container-border">

					<header>
						<h1 style="font-size:2.222em !important;line-height: 1 !important;">CONTACT DETAILS</h1>
					</header>
					
					<hr>

					<div class="content">
						
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
						
					</div>
				</div>

			</div>
		</div>


		<div class="row" style="margin-top:.5em;">
			<div class="col-md-12">
				<div class="mail-return default-container-border">
					<h3>Shipping Details : </h3>
					<p style="color:#fff;margin-bottom: 1% !important;margin-bottom:1% !important;"><em>Kindly double check you added the correct products above and that your contact information is up to date. If all information is correct, fill in your card information so you can proceed with the shipping payment, and help save our planet.</em></p>
					<input type="hidden" class="form-control" id="totalItemWeight" name="totalItemWeight" value="">
					<hr>
					<div class="row">
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

	</div>
</form>

<div id="loader"></div>

<!-- Modal -->
<div id="selectProductModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Product</h4>
      </div>

      <div class="modal-body">
			<?php
				/**
				* Declare Variable with value of 1 for loop and ID purpose
				**/
				$x = 1;
				/**
				* Get Product List
				**/
				$args = array(
						'post_type' => 'product',
						'post_status' => 'publish',
						'posts_per_page' => -1
						);
				$loop = new WP_Query( $args );
				
				/**
				* Loop all the products
				**/
			    while ( $loop->have_posts() ) : $loop->the_post();
			?>
			<!-- Product -->
			<div class="row modal-product modal-product-<?php echo $x ?>">

				<div class="col-md-8">
					<div class="product-info flex">
						<?php
							$image = get_the_post_thumbnail_url(get_the_ID(),'full');
							$product_id = get_the_ID();
							$product_name = get_the_title();
						 ?>
						<img src="<?php echo $image; ?>" alt="<?php echo $product_name; ?>" id="modal_product_image_<?php echo $x; ?>">

						<div class="product-details">
							<h4 id="modal_product_name_<?php echo $x; ?>"><?php echo $product_name; ?></h4>
						</div>
					</div>

				</div>

				<div class="col-md-4">
					<div class="product-qty">
						<input type="hidden" id="modal_order_id_<?php echo $x; ?>" name="order_id" value="<?php echo $product_id; ?>">
						<input type="hidden" id="modal_order_item_id_<?php echo $x; ?>" name="order_item_id" value="<?php echo $product_id; ?>">
						<input type="number" class="form-control modal_productQty" onclick="getModalProdQty(this)"  id="modal_productQty_<?php echo $x; ?>" name="productQty" placeholder="0" value="">
						<button type="button" class="modalButton btn btn-success btn-circle" id="modal_buttonAdd_<?php echo $x; ?>" value="<?php echo $x; ?>" onclick="addElement(this)"><i class="fa fa-plus"></i></button>
					</div>
				</div>

			</div>
			<?php
				$x++;
				endwhile;
			    wp_reset_query();
			 ?>
      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>
</div>

<?php 
	}else{
		echo "<div class='bidiRecycleContainer'><h3 style='text-align:center;'>We are excited about your participation in our Recycling Program!</h3></br><h4 style='text-align:center; font-weight:500;'>Currently, you do not have enough Bidi Sticks in your order history. Remember you need 10 Bidi Sticks before you can recycle. If you are out of Bidi Sticks, you can go to our shop <a href='/shop'>here</a>.</br></br>We look forward to seeing you back here so we can save the planet together.</h4></br>";
		echo "<img src='" . plugin_dir_url( dirname( __FILE__, 2 ) ) . "bidi-recycle-program/assets/img/adminHeader.jpg' width='100%'></div>";
	}
}