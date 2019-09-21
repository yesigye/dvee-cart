<?php $this->load->view('public/templates/header', array(
	'title' => 'Cart',
	'link' => 'cart'
)) ?>

<ul class="breadcrumb">
	<li>
		<?php echo anchor('cart', 'Shopping Cart') ?>
	</li>
	<li class="active">Checkout</li>
</ul>
	
<?php echo form_open(current_url());?>
	<div class="row">
		<div class="col-md-6">
			<div class="lead page-header">Billing Details</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="checkout_billing_name">Name:</label>
						<input type="text" name="checkout[billing][name]" id="checkout_billing_name" value="<?php echo set_value('checkout[billing][name]');?>" placeholder="Name" class="form-control"/>
					</div>
					<div class="form-group">
						<label for="checkout_billing_company">Company:</label>
						<input type="text" name="checkout[billing][company]" id="checkout_billing_company" value="<?php echo set_value('checkout[billing][company]');?>" placeholder="Company" class="form-control"/>
					</div>
					<div class="form-group">
						<label for="checkout_billing_add_01">Address Line 1:</label>
						<input type="text" name="checkout[billing][add_01]" id="checkout_billing_add_01" value="<?php echo set_value('checkout[billing][add_01]');?>" placeholder="Address Line 1" class="form-control"/>
					</div>
					<div class="form-group">
						<label for="checkout_billing_add_02">Address Line 2:</label>
						<input type="text" name="checkout[billing][add_02]" id="checkout_billing_add_02" value="<?php echo set_value('checkout[billing][add_02]');?>" placeholder="Address Line 2" class="form-control"/>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="checkout_billing_city">City / Town:</label>
						<input type="text" name="checkout[billing][city]" id="checkout_billing_city" value="<?php echo set_value('checkout[billing][city]');?>" placeholder="City / Town" class="form-control"/>
					</div>
					<div class="form-group">
						<label for="checkout_billing_state">State / County:</label>
						<input type="text" name="checkout[billing][state]" id="checkout_billing_state" value="<?php echo set_value('checkout[billing][state]', $this->flexi_cart->shipping_location_name(2));?>" placeholder="State" class="form-control"/>
					</div>
					<div class="form-group">
						<label for="checkout_billing_post_code">Post / Zip Code:</label>
						<input type="text" name="checkout[billing][post_code]" id="checkout_billing_post_code" value="<?php echo set_value('checkout[billing][post_code]', $this->flexi_cart->shipping_location_name(3));?>" placeholder="Post / Zip Code" class="form-control"/>
					</div>
					<div class="form-group">
						<label for="checkout_billing_country">Country:</label>
						<select id="checkout_billing_country" name="checkout[billing][country]" class="form-control">
							<option value="0"> - Country - </option>
						<?php 
							foreach($countries as $country) { 
								$id = $country[$this->flexi_cart->db_column('locations', 'id')];
								$name = $country[$this->flexi_cart->db_column('locations', 'name')];
						?>
							<option value="<?php echo $name;?>" <?php echo set_select('checkout[billing][country]', $name, $this->flexi_cart->match_shipping_location_id($id)); ?>>
								<?php echo $name;?>
							</option>
						<?php } ?>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="page-header">
				<div class="lead">Shipping Details</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" id="copy_billing_details" value="1"/>
						<strong>Copy Billing Details</strong>
					</label>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="checkout_shipping_name">Name:</label>
						<input type="text" name="checkout[shipping][name]" id="checkout_shipping_name" value="<?php echo set_value('checkout[shipping][name]');?>" placeholder="Name" class="form-control"/>
					</div>
					<div>
						<label for="checkout_shipping_company">Company:</label>
						<input type="text" name="checkout[shipping][company]" id="checkout_shipping_company" value="<?php echo set_value('checkout[shipping][company]');?>" placeholder="Company" class="form-control"/>
					</div>
					<div class="form-group">
						<label for="checkout_shipping_add_01">Address Line 1:</label>
						<input type="text" name="checkout[shipping][add_01]" id="checkout_shipping_add_01" value="<?php echo set_value('checkout[shipping][add_01]');?>" placeholder="Address Line 1" class="form-control"/>
					</div>
					<div>
						<label for="checkout_shipping_add_02">Address Line 2:</label>
						<input type="text" name="checkout[shipping][add_02]" id="checkout_shipping_add_02" value="<?php echo set_value('checkout[shipping][add_02]');?>" placeholder="Address Line 2" class="form-control"/>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="checkout_shipping_city">City / Town:</label>
						<input type="text" name="checkout[shipping][city]" id="checkout_shipping_city" value="<?php echo set_value('checkout[shipping][city]');?>" placeholder="City / Town" class="form-control"/>
					</div>
					<div class="form-group">
						<label for="checkout_shipping_state">State / County:</label>
					<?php if (!($this->flexi_cart->shipping_location_name(2))) { ?>
						<input type="text" name="checkout[shipping][state]" id="checkout_shipping_state" value="<?php echo set_value('checkout[shipping][state]');?>" placeholder="State" class="form-control"/>
					<?php } else { ?>
						<?php echo $this->flexi_cart->shipping_location_name(2);?>
						<input type="hidden" name="checkout[shipping][state]" value="<?php echo set_value('checkout[shipping][state]', $this->flexi_cart->shipping_location_name(2));?>"/>
					<?php } ?>
					</div>
					<div class="form-group">
						<label for="checkout_shipping_post_code">Post / Zip Code:</label>
					<?php if (!($this->flexi_cart->shipping_location_name(3))) { ?>
						<input type="text" name="checkout[shipping][post_code]" id="checkout_shipping_post_code" value="<?php echo set_value('checkout[shipping][post_code]');?>" placeholder="Post / Zip Code" class="form-control"/>
					<?php } else { ?>
						<?php echo $this->flexi_cart->shipping_location_name(3);?>
						<input type="hidden" name="checkout[shipping][post_code]" value="<?php echo set_value('checkout[shipping][post_code]', $this->flexi_cart->shipping_location_name(3));?>"/>
					<?php } ?>
					</div>
					<div>
						<label for="checkout_shipping_country">Country:</label>
						<?php echo $this->flexi_cart->shipping_location_name(1);?>
						<input type="hidden" name="checkout[shipping][country]" value="<?php echo $this->flexi_cart->shipping_location_name(1);?>"/>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="lead page-header">Contact Details</div>
			<div class="form-inline">
				<div class="form-group">
					<label for="checkout_email">Email:</label>
					<input type="text" name="checkout[email]" id="checkout_email" value="<?php echo set_value('checkout[email]');?>" placeholder="Email" class="form-control"/>
				</div>
				<div class="form-group">
					<label for="checkout_phone">Phone Number:</label>
					<input type="text" name="checkout[phone]" id="checkout_phone" value="<?php echo set_value('checkout[phone]');?>" placeholder="Phone Number" class="form-control"/>
				</div>
			</div>
		</div>
	</div>
					
	
	<hr>
	
	<div class="form-group text-right">
		<button type="submit" name="submit" value="Checkout" class="btn btn-lg btn-primary">
			Checkout
			<span class="favfa"></span>
		</button>
	</div>
<?php echo form_close();?>

<script>
$(function() 
{
	// Toggle show/hide cart session array
	$('#copy_billing_details').click(function()
	{
		$('input[name^="checkout[billing]"]').each(function()
		{
			// Target textboxes only, no hidden fields
			if ($(this).attr('type') == 'text')
			{
				var name = $(this).attr('name').replace('billing', 'shipping');
				var value = ($('#copy_billing_details').is(':checked')) ? $(this).val() : '';
				
				$('input[name="'+name+'"]').val(value);
			}
		});
	
	});
});
</script>

<?php $this->load->view('public/templates/footer') ?>