<?php $this->load->view('admin/templates/header', array(
	'title' => 'Cart Defaults',
	'link' => 'settings',
	'sub_link' => 'defaults',
	'breadcrumbs' => array(
		0 => array('name'=>'Settings','link'=>'config'),
		1 => array('name'=>'Cart Defaults','link'=>FALSE),
	)
)); ?>

<h4 class="lead">Cart Defaults</h4>
<p class="text-muted">
	The default values selected will be the options and values that are defined when a user first enters the site.
</p>

<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>

<?php echo form_open(current_url());?>
	<div class="form-group">
		Default Currency
		<div class="text-muted">Defines the default currency that prices are displayed in when a user first visits the site.</div>
		<select id="currency" name="update[currency]" class="form-control">
			<option value="0"> - Select Default Currency - </option>
			<?php 
			foreach($currency_data as $currency) { 
				$id = $currency[$this->flexi_cart_admin->db_column('currency', 'id')];
				$default = $default_currency[$this->flexi_cart_admin->db_column('currency', 'id')];
			?>
			<option value="<?php echo $id; ?>" <?php echo set_select('update[currency]', $id, ($default == $id)); ?>>
				<?php echo $currency[$this->flexi_cart_admin->db_column('currency', 'name')]; ?>
			</option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group">
		Default Shipping Location
		<div class="text-muted">Set the default location that shipping options and rates are displayed for.</div>
		<select id="shipping_location" name="update[shipping_location]" class="form-control">
			<option value="0"> - Select Default Shipping Location - </option>
			<?php 
			foreach($locations_inline as $location) { 
				$id = $location[$this->flexi_cart_admin->db_column('locations', 'id')];
				$default = $default_ship_location[$this->flexi_cart_admin->db_column('locations', 'id')];
			?>
			<option value="<?php echo $id; ?>" <?php echo set_select('update[shipping_location]', $id, ($default == $id)); ?>>
				<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')]; ?>
			</option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group">
		Default Shipping Option
		<div class="text-muted">Set the default shipping option that is displayed.</div>
		<select id="shipping_option" name="update[shipping_option]" class="form-control">
			<option value="0"> - Select Default Shipping Option - </option>
			<?php 
			foreach($shipping_data as $option) { 
				$id = $option[$this->flexi_cart_admin->db_column('shipping_options', 'id')];
				$default = $default_ship_option[$this->flexi_cart_admin->db_column('shipping_options', 'id')];
			?>
			<option value="<?php echo $id; ?>" <?php echo set_select('update[shipping_option]', $id, ($default == $id)); ?>>
				<?php echo $option[$this->flexi_cart_admin->db_column('shipping_options', 'name')]; ?>
			</option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group">
		Default Tax Location
		<div class="text-muted">Set the default location that the cart tax rate is based on.</div>
		<select id="tax_location" name="update[tax_location]" class="form-control">
			<option value="0"> - Select Default Tax Location - </option>
			<?php 
			foreach($locations_inline as $location) { 
				$id = $location[$this->flexi_cart_admin->db_column('locations', 'id')];
				$default = $default_tax_location[$this->flexi_cart_admin->db_column('locations', 'id')];
			?>
			<option value="<?php echo $id; ?>" <?php echo set_select('update[tax_location]', $id, ($default == $id)); ?>>
				<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')]; ?>
			</option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group">
		Default Tax Rate
		<div class="text-muted">Select the default tax rate that is displayed.</div>
		<select id="tax_rate" name="update[tax_rate]" class="form-control">
			<option value="0"> - Select Default Tax Rate - </option>
			<?php 
			foreach($tax_data as $tax_rate) { 
				$id = $tax_rate[$this->flexi_cart_admin->db_column('tax', 'id')];
				$default = $default_tax_rate[$this->flexi_cart_admin->db_column('tax', 'id')];								
			?>
			<option value="<?php echo $id; ?>" <?php echo set_select('update[tax_rate]', $id, ($default == $id)); ?>>
				<?php echo $tax_rate[$this->flexi_cart_admin->db_column('tax', 'name')]; ?>
			</option>
			<?php } ?>
		</select>
	</div>

	<input type="submit" name="update_defaults" value="Update Cart Defaults" class="btn btn-primary mt-4"/>
<?php echo form_close(); ?>
	
<?php $this->load->view('admin/templates/footer'); ?>