<?php $this->load->view('public/templates/header', array(
	'title' => 'Cart',
	'link' => 'cart',
)) ?>

<?php if (empty($cart_items)): ?>
<div class="row">
	<div class="col-md-6 col-lg-5 m-auto py-4 text-center">
		<h2>Checkout</h2>
		<div class="lead py-3 text-muted">
			You currently have no items in your shopping cart!
		</div>
		<?php if ($saved_cart_data): ?>
		<button data-toggle="modal" data-target="#load-cart-modal" class="btn btn-lg btn-block btn-outline-secondary">
			<small><span class="fa fa-download mr-1"></span> Load saved cart</small>
		</button>
		<?php endif ?>
	</div>
</div>
<?php else: ?>
<div class="container">
	<div class="py-4 bg-secondary text-white text-center">
		<h2>Checkout</h2>
		<p class="lead">
			Review your cart and checkout details
		</p>
	</div>
	<?php if(isset($error)): ?>
	<div class="alert rounded-0 bg-danger text-white"> <?php echo $error ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
            <span class="sr-only">Close</span>
        </button>
	</div>
	<?php endif ?>

	<div class="row mt-3">
		<div class="col-md-6 order-md-2 mb-4">
			<h4 class="d-flex justify-content-between align-items-center mb-3">
				<span class="small text-uppercase">Your cart</span>
				<span class="badge badge-secondary badge-pill"><?php echo count($cart_items) ?></span>
			</h4>

			<div class="text-right mb-2">
				<?php echo form_open(current_url()) ?>
					<div class="btn-group">
						<a href="<?= site_url('save_cart_data') ?>" class="btn btn-sm btn-outline-secondary">
							<span class="fa fa-save mr-1"></span> Save
						</a>
						<button type="button" data-toggle="modal" data-target="#load-cart-modal" class="btn btn-sm btn-outline-secondary">
							<span class="fa fa-download mr-1"></span> Load
						</button>
						<input type="submit" name="destroy" value="Destroy Cart" class="btn btn-sm btn-danger" title="Destroy Cart will reset the cart to default values.">
					</div>
				<?php echo form_close() ?>
			</div>
			
			<ul class="list-group mb-3">
				<?php foreach($cart_items as $row): $i = 0; $i++; ?>
				<li class="list-group-item d-flex justify-content-between lh-condensed">
					<div class="media text-truncate">
						<?php if (isset($row['thumb'])): ?>
							<img src="<?php echo $row['thumb'] ?>" class="media-object mr-2 mt-2" style="height:30px;">
						<?php else: ?>
							<i class="fa fa-picture text-muted media-object mr-2 mt-2" style="font-size:30px;"></i>
						<?php endif ?>
						<div class="media-body">
							<div class="" title="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></div>
							<div class="text-muted small" title="<?php echo $this->flexi_cart->item_options($row['row_id'], TRUE) ?>">
								<?php echo $this->flexi_cart->item_options($row['row_id'], TRUE) ?>
							</div>
						</div>
					</div>
					<span class="text-muted">

					</span>
					<div class="text-muted text-right">
						<?php if ($row['discount_quantity'] > 0): ?>
						<!-- If an item discount exists, strike out the standard item total and display the discounted item total. -->
						<s> <?php echo $row['price_total'] ?> </s> <?php echo $row['discount_price_total'] ?>
						<?php else: ?>
						<?php echo $row['price_total'] ?>
						<?php endif ?>
						<div>
							<a class="badge badge-danger" href="<?php echo site_url('delete_cart_item/'.$row['row_id']) ?>">Remove</a>
						</div>
					</div>
				</li>
				<?php endforeach ?>

				<?php if ($discount_data = $this->flexi_cart->discount_codes()): ?>
				<li class="list-group-item d-flex justify-content-between bg-light">
					<div class="text-success">
						<div class="my-0">Voucher code</div>
						<?php 
							// Get an array of all discount codes.
							// Returns array keys are 'id', 'code' and 'description'.
							foreach($reward_vouchers as $voucher):
						?>
						<small> <?php echo $voucher['code']; ?> </small>
						<?php endforeach ?>
					</div>
					<div class="text-success text-right">
						- <?php echo $this->flexi_cart->reward_voucher_total() ?> <br>
						<a class="badge badge-danger" href="<?php echo site_url('unset_discount/'.$voucher['code']) ?>">Remove</a>
					</div>
				</li>
				<?php endif ?>

				<li class="list-group-item d-flex justify-content-between">
					<div>
						<div class="my-0">Shipping</div>
						<small class="text-muted"> <?php echo $this->flexi_cart->total_weight() ?> </small>
						
						<?php if (! $this->flexi_cart->location_shipping_status()): ?>
						<!-- None shipping location disclaimer -->
						<div class="text-danger">
							There are items in your cart that cannot be shipped to your current shipping location.
						</div>
						<?php endif ?>
					</div>
					<span class="text-muted"><?php echo $this->flexi_cart->shipping_total() ?></span>
				</li>

				<?php if ($this->flexi_cart->surcharge_status()): ?>
				<li class="list-group-item d-flex justify-content-between">
					<span>Surcharge</span>
					<span class="text-muted"><?php echo $this->flexi_cart->surcharge_total() ?></span>
				</li>
				<?php endif ?>

				<li class="list-group-item d-flex justify-content-between">
					<span><?php echo $this->flexi_cart->tax_name()." @ ".$this->flexi_cart->tax_rate(); ?></span>
					<span class="text-muted"><?php echo $this->flexi_cart->tax_total() ?></span>
				</li>

				<li class="list-group-item d-flex justify-content-between">
					<span>Total</span>
					<strong><?php echo $this->flexi_cart->total() ?></strong>
				</li>
				
				<li class="list-group-item d-flex justify-content-between bg-light text-success">
					<div class="my-0">Savings</div>
					<span class=""><?php echo $this->flexi_cart->cart_savings_total() ?></span>
				</li>

				<?php if ($this->flexi_cart->total_reward_points()): ?>
				<li class="list-group-item d-flex justify-content-between bg-light text-success">
					<div>Reward points to earn</div>
					<span class="">
						<?php echo $this->flexi_cart->total_reward_points() ?>
					</span>
				</li>
				<?php endif ?>
			</ul>

			<?php echo form_open(current_url(), 'class="card p-2"') ?>
				<div class="input-group">
					<input type="text" name="discount[]" class="form-control" placeholder="Voucher code">
					<div class="input-group-append">
						<button type="submit" name="update_discount" value="1" class="btn btn-secondary">Redeem</button>
					</div>
				</div>
			<?php echo form_close() ?>
			
			<a href="<?php echo site_url('paypal') ?>" class="btn btn-warning btn-lg btn-block my-3">
				<small>Go to paypal checkout</small>
			</a>
		</div>

		<div class="col-md-6 order-md-1">
			<?= form_open('cart', 'class="needs-validation" novalidate=""') ?>
				<div class="lead text-uppercase">Billing address</div>
				<p class="text-muted small">The billing address should be the same as that on your card</p>
				<?php // Only require firstname, lastname and email if the user is a guest
					if( ! $this->ion_auth->logged_in()): ?>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="firstName">First name</label>
						<input type="text" class="form-control <?= form_error('first_name') ? 'is-invalid' : '' ?>" id="firstName" name="first_name" value="<?php echo set_value('first_name') ?>" required>
						<?php if (form_error('first_name')): ?>
						<div class="invalid-feedback"><?php echo form_error('first_name') ?></div>
						<?php endif ?>
					</div>

					<div class="col-md-6 mb-3">
						<label for="lastName">Last name</label>
						<input type="text" class="form-control <?= form_error('last_name') ? 'is-invalid' : '' ?>" id="lastName" name="last_name" value="<?php echo set_value('last_name') ?>" required>
						<?php if (form_error('last_name')): ?>
						<div class="invalid-feedback"><?php echo form_error('last_name') ?></div>
						<?php endif ?>
					</div>

					<div class="col-md-6 mb-3">
						<label for="email">Email</label>
						<input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?php echo set_value('email') ?>" required>
						<?php if (form_error('email')): ?>
						<div class="invalid-feedback"><?php echo form_error('email') ?></div>
						<?php endif ?>
					</div>

					<div class="col-md-6 mb-3">
						<label for="phone">Phone <span class="text-muted">(<small>Optional</small>)</span></label>
						<input type="text" class="form-control <?= form_error('phone') ? 'is-invalid' : '' ?>" id="phone" name="phone" value="<?php echo set_value('phone') ?>">
						<?php if (form_error('phone')): ?>
						<div class="invalid-feedback"><?php echo form_error('phone') ?></div>
						<?php endif ?>
					</div>
				</div>
				<?php endif ?>
				
				<div id="cart_billing" class="row">
					<div class="col-md-6 mb-3">
						<label for="country">Country</label>
						<?php if ($countries): // Specific countries were set by admin ?>
						<select class="custom-select d-block w-100 <?= form_error('billing[country]') ? 'is-invalid' : '' ?>" name="billing[country]" id="country">
							<option value="">Choose...</option>
							<?php foreach($countries as $country): ?>
							<option value="<?php echo $country['loc_id']; ?>" <?php echo set_select('billing[country]', $country['loc_id']) ? set_select('billing[country]', $country['loc_id']) : (($this->flexi_cart->match_shipping_location_id($country['loc_id'])) ? 'selected="selected"' : NULL); ?>>
								<?php echo $country['loc_name'];?>
							</option>
							<?php endforeach ?>
						</select>
						<?php else: ?>
						<input type="text" class="form-control <?= form_error('billing[country]') ? 'is-invalid' : '' ?>" name="billing[country]" id="country" placeholder="United States" value="<?php echo set_value('billing[country]') ?>"  required>
						<?php endif ?>
						<?php if (form_error('billing[country]')): ?>
						<div class="invalid-feedback"><?php echo form_error('billing[country]') ?></div>
						<?php endif ?>
					</div>

					<div class="col-md-6 mb-3">
						<label for="state">State</label>
						<?php if ($states): // Specific states were set by admin ?>
						<select class="custom-select d-block w-100 <?= form_error('billing[state]') ? 'is-invalid' : '' ?>" name="billing[state]" id="state">
							<option value="">Choose...</option>
							<?php foreach($states as $state): ?>
							<option value="<?php echo $state['loc_id'];?>" <?php echo set_select('billing[state]', $country['loc_id']) ? set_select('billing[state]', $country['loc_id']) : (($this->flexi_cart->match_shipping_location_id($state['loc_id'])) ? 'selected="selected"' : NULL);?>>
								<?php echo $state['loc_name'];?>
							</option>
							<?php endforeach ?>
						</select>
						<?php else: ?>
						<input type="text" class="form-control <?= form_error('billing[state]') ? 'is-invalid' : '' ?>" name="billing[state]" id="state" placeholder="e.g. United States" value="<?php echo set_value('billing[state]') ?>" required>
						<?php endif ?>
						<?php if (form_error('billing[state]')): ?>
						<div class="invalid-feedback"><?php echo form_error('billing[state]') ?></div>
						<?php endif ?>
					</div>

					<div class="col-md-4 mb-3">
						<label for="city">City</label>
						<input type="text" class="form-control <?= form_error('bill_city') ? 'is-invalid' : '' ?>" name="bill_city" id="city" placeholder="e.g. New York City" value="<?php echo set_value('bill_city') ?>" required>
						<?php if (form_error('bill_city')): ?>
						<div class="invalid-feedback"><?php echo form_error('bill_city') ?></div>
						<?php endif ?>
					</div>
					<div class="col-md-5 mb-3">
						<label for="street">Street <span class="text-muted">(<small>Optional</small>)</span></label>
						<input type="text" class="form-control" name="bill_street" id="street" placeholder="e.g. 1234 Main St" value="<?php echo set_value('bill_street') ?>">
					</div>
					<div class="col-md-3 mb-3">
						<label for="zip">Zip</label>
						<input type="text" class="form-control <?= form_error('billing[postal_code]') ? 'is-invalid' : '' ?>" name="billing[postal_code]" placeholder="e.g. 10101" value="<?php echo $this->flexi_cart->shipping_location_name(3);?>">
						<?php if (form_error('billing[postal_code]')): ?>
						<div class="invalid-feedback"><?php echo form_error('billing[postal_code]') ?></div>
						<?php endif ?>
					</div>
					<div class="col-md-12 mb-3">
						<label for="shipoption">Shipping Options</label>
						<select class="custom-select d-block w-100" name="shipping[db_option]" id="shipoption">
							<option value="0"> - Shipping Options - </option>
							<?php if (! empty($shipping_options)): ?>
								
							<?php foreach($shipping_options as $shipping): ?>
							<option value="<?php echo $shipping['id'];?>" <?php echo set_select('shipping[db_option]', $shipping['id']) ? set_select('shipping[db_option]', $shipping['id']) : (($shipping['id'] == $this->flexi_cart->shipping_id()) ? 'selected="selected"' : NULL); ?>>
								<?php echo $shipping['name']." : ".$shipping['description'];?>
							</option>
							<?php endforeach ?>

							<?php else: ?>
							<option value="0">
								We'll quote you prior to dispatch.
							</option>
							<?php endif ?>
						</select>
						<div class="invalid-feedback">Please select a shopping option.</div>
					</div>
				</div>

				<hr class="mb-4">
				<div class="mb-3 custom-control custom-checkbox" data-toggle="collapse" data-target="#shipping-info">
					<input type="hidden" name="same_address" value="0">
					<input type="checkbox" class="custom-control-input" id="same-address" name="same_address" value="1" checked>
					<label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
				</div>
				
				<div class="collapse" id="shipping-info">
					<div class="lead text-uppercase">Shipping address</div>
					<p class="text-muted small">Where do you what your items delivered? this may affect tax rates</p>
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="ship_country">Country</label>
							<input type="text" class="form-control" name="shipping[country]" id="ship_country" placeholder="United States" required>
							<div class="invalid-feedback">Please select a valid country.</div>
						</div>
						<div class="col-md-6 mb-3">
							<label for="ship_state">State</label>
							<input type="text" class="form-control" name="shipping[state]" id="ship_state" placeholder="New York" required>
							<div class="invalid-feedback">Please provide a valid state.</div>
						</div>
						<div class="col-md-4 mb-3">
							<label for="ship_city">City</label>
							<input type="text" class="form-control" name="shipping[city]" id="ship_city" placeholder="New York City" required>
							<div class="invalid-feedback">Please enter your shipping address.</div>
						</div>
						<div class="col-md-5 mb-3">
							<label for="ship_street">Street <span class="text-muted">(<small>Optional</small>)</span></label>
							<input type="text" class="form-control" name="shipping[street]" id="ship_street" placeholder="1234 Main St">
						</div>
						<div class="col-md-3 mb-3">
							<label for="zip">Zip</label>
							<input type="text" class="form-control" name="shipping[postal_code]" placeholder="10101">
							<div class="invalid-feedback">Zip code is required.</div>
						</div>
					</div>
					<hr>
				</div>
				
				<hr class="mb-4">

				<div class="mb-3 lead text-uppercase">Payment</div>
				<div class="row">
					<div class="col-md-6 mb-3">
						<label for="cc-name">Name on card</label>
						<input type="text" class="form-control <?= form_error('card_name') ? 'is-invalid' : '' ?>" name="card_name" id="cc-name" value="<?php echo set_value('card_name') ?>" required>
						<?php if (form_error('card_name')): ?>
						<div class="invalid-feedback"><?php echo form_error('card_name') ?></div>
						<?php else: ?>
						<small class="text-muted">Full name as displayed on card</small>
						<?php endif ?>
					</div>

					<div class="col-md-6 mb-3">
						<label for="cc-number">Credit card number</label>
						<input type="text" class="form-control <?= form_error('card_number') ? 'is-invalid' : '' ?>" name="card_number" id="cc-number" value="<?php echo set_value('card_number') ?>" required>
						<?php if (form_error('card_number')): ?>
						<div class="invalid-feedback"><?php echo form_error('card_number') ?></div>
						<?php endif ?>
					</div>

					<div class="col-md-6 mb-3">
						<label for="cc-expiration-month">Expiration</label>
						<div class="input-group">
							<select type="text" class="custom-select" name="card_month" id="cc-expiration-month" required>
								<?php for ($i=1; $i < 13; $i++): ?>
								<option value="<?php echo $i ?>" <?php echo set_select('card_month', $i) ?>><?php echo $i ?></option>
								<?php endfor ?>
							</select>
							<div class="input-group-prepend">
								<div class="input-group-text text-muted">/</div>
							</div>
							<select type="text" class="custom-select" name="card_year" id="cc-expiration-year" required>
								<?php for ($y=2016; $y < 2050; $y++): ?>
								<option value="<?php echo $y ?>" <?php echo set_select('card_year', $y) ?>><?php echo $y ?></option>
								<?php endfor ?>
							</select>
						</div>
						<div class="invalid-feedback">Expiration date required</div>
					</div>
					<div class="col-md-4 mb-3">
						<label for="cc-cvv">CVV</label>
						<input type="text" class="form-control <?= form_error('card_cvv') ? 'is-invalid' : '' ?>" name="card_cvv" id="cc-cvv" placeholder="123" value="<?php echo set_value('card_cvv') ?>" required>
						<?php if (form_error('card_cvv')): ?>
						<div class="invalid-feedback"><?php echo form_error('card_cvv') ?></div>
						<?php endif ?>
					</div>
				</div>
				<button type="submit" name="checkout" value="1" class="btn btn-primary btn-lg btn-block text-uppercase">
					<small>Pay</small>
				</button>
			<?= form_close() ?>
		</div>
	</div>
</div>

<script>
$(function() {
	// Ajax Cart Update Example
	// Submit the cart form if a billing option select or input element is changed.
	// $('select[name^="billing"], input[name^="billing"]').on('change', function() // UX mess
	$('select[name^="billing"]').on('change', function()
	{
		// Loop through billing select and input fields creating object of their names and values that will then be submitted via 'post'
		var data = new Object();
		$('select[name^="billing"], input[name^="billing"]').each(function() {
			data[$(this).attr('name').replace("billing", "shipping")] = $(this).val();
		});
		
		// Set 'update' so controller knows to run update method.
		data['update'] = true;

		// !IMPORTANT NOTE: As of CI 2.0, if csrf (cross-site request forgery) protection is enabled via CI's config,
		// this must be included to submit the token.
		data['csrf_test_name'] = $('input[name="csrf_test_name"]').val();

		// $('#cart_content').load('<?php echo current_url();?> #ajax_content', data);
		$.ajax({
			type: 'POST',
			data: data,
			url: '<?php echo current_url(); ?>',
			cache: true,
			beforeSend: function(){
			},
			success: function(data){
				$('body').html(data)
				// container.addClass('animated zoomOut');
				// setTimeout(function(){
					//  container.remove();
				// }, 550);
			},
			complete: function(data){
				$('body').append(data)
			}
		});
	});
});
</script>
<?php endif ?>

<?php // Display saved cart session for user to load or delete ?>
<div class="modal fade" id="load-cart-modal" tabindex="-1" role="dialog" aria-labelledby="load-cart-modal" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content border-0">
			<div class="modal-header bg-secondary text-white">
				Load a cart
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-0">
				<?php if ($saved_cart_data): ?>
					<table class="table table-borderless table-striped table-hover m-0">
						<tbody>
							<?php foreach($saved_cart_data as $row): $cart = unserialize($row['cart_data_array']); ?>
								<tr>
									<td>
										<b># <?php echo $row['cart_data_id'] ?>:</b>
										<?php echo $cart['summary']['total_items'] ?> items in the cart
										<div class="small text-muted">
											Saved on : 
											<?php echo date('jS M Y @ H:i', strtotime($row[$this->flexi_cart->db_column('db_cart_data','date')])); ?>
										</div>
									</td>
									<td class="text-right">
										<div class="btn-group">
											<a href="<?php echo site_url('load_cart_data/'.$row[$this->flexi_cart->db_column('db_cart_data','id')]) ?>" class="btn btn-sm btn-primary">
												Load
											</a>
											<a href="<?php echo site_url('delete_cart_data/'.$row[$this->flexi_cart->db_column('db_cart_data','id')]) ?>" class="btn btn-sm btn-danger">
												Remove
											</a>
										</div>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				<?php else: ?>
					<div class="px-3 py-5 text-muted">
						<?php if ($user): ?>
							There are currently no saved carts to load.
						<?php else: ?>
							You must be logged in to load saved carts.
							<?php echo anchor('login', 'Login', 'class="alert-link"') ?>
						<?php endif ?>
					</div>
				<?php endif ?>
			</div>
			<div class="modal-footer small d-flex justify-content-start">
				Only saved carts for orders that have not been completed are listed
			</div>
        </div>
    </div>
</div>

<?php $this->load->view('public/templates/footer') ?>