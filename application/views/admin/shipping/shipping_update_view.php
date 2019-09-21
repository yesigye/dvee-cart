<?php $this->load->view('admin/templates/header', array(
	'title' => 'Shipping',
	'link' => 'shipping',
	'breadcrumbs' => array(
		0 => array('name'=>'Shipping','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/shipping/shipping_sub_header'); ?>

<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>

<?php if (empty($shipping_data)): ?>
	<div class="alert alert-warning">
		There are no shipping options setup to view.
		<?php echo anchor('admin/insert_shipping', 'Insert New Shipping Option', 'Insert New Item Tax Rates', 'class="alert-link"') ?>
	</div>
<?php else: ?>
	<?php echo form_open(current_url()); ?>
		<div class="table-responsive">
			<table class="table table-flat table-striped">
				<thead>
					<tr>
						<th>
							<div data-toggle="tooltip" title="The name and a short description of the shipping option.">
								<span class="fa fa-asterisk text-danger"></span> 
								Option Name
								<span class="fa fa-info-sign"></span> 
							</div>
						</th>
						<th>
							<div data-toggle="tooltip" title="Set the location that the shipping option is applied to.">
								Location
								<span class="fa fa-info-sign"></span>
							</div>
						</th>
						<th>
							<div data-toggle="tooltip" title="Set the zone that the shipping option is applied to. Note: If a location is set, it has priority over a zone rule.">
								Zone
								<span class="fa fa-info-sign"></span>
							</div>
						</th>
						<th class="text-center">
							<div data-toggle="tooltip" title="If checked, sets whether the shipping option is displayed with options that are available for more specific locations. For example, if checked for 'United States', the option will also be displayed with 'New York' options.">
								Inc. Sub Locations
								<span class="fa fa-info-sign"></span>
							</div>
						</th>
						<th>
							<div data-toggle="tooltip" title="Manage the shipping rate tiers within the shipping option.">
								Shipping Rates
								<span class="fa fa-info-sign"></span>
							</div>
						</th>
						<th>
							<div data-toggle="tooltip" title="Sets the tax rate charged on the total value of shipping, but not the tax rate of any other values within the cart. Note: Leave blank to use the default cart tax rate.">
								Tax Rate (%)
								<span class="fa fa-info-sign"></span>
							</div>
						</th>
						<th class="text-center">
							<div data-toggle="tooltip" title="If checked, sets whether the shipping option can be included in cart discounts. For example, a 10% discount on the cart value could be excluded from including the shipping value.">
								Discount
								<span class="fa fa-info-sign"></span>
							</div>
						</th>
						<th class="text-center">
							<div data-toggle="tooltip" title="If checked, the shipping option will be set as 'active'.">
								Status
								<span class="fa fa-info-sign"></span>
							</div>
						</th>
						<th class="text-center">
							<div data-toggle="tooltip" title="If checked, the row will be deleted upon the form being updated.">
								Delete
								<span class="fa fa-info-sign"></span>
							</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($shipping_data as $row) {
						$shipping_id = $row[$this->flexi_cart_admin->db_column('shipping_options', 'id')];
					?>
					<tr>
						<td class="form-group <?php echo form_error('update['.$shipping_id.'][name]') ? 'has-error' : '' ?>">
							<input type="hidden" name="update[<?php echo $shipping_id; ?>][id]" value="<?php echo $shipping_id; ?>"/>
							<input type="text" name="update[<?php echo $shipping_id; ?>][name]" value="<?php echo set_value('update['.$shipping_id.'][name]', $row[$this->flexi_cart_admin->db_column('shipping_options', 'name')]); ?>" class="form-control input-sm"/>
							<?php echo form_error('update['.$shipping_id.'][name]') ?>
							<textarea name="update[<?php echo $shipping_id; ?>][description]" class="form-control input-sm"><?php echo set_value('update['.$shipping_id.'][description]', $row[$this->flexi_cart_admin->db_column('shipping_options', 'description')]); ?></textarea>
						</td>
						<td>
							<?php 
							$shipping_location = $row[$this->flexi_cart_admin->db_column('shipping_options', 'location')];
							foreach($locations_tiered as $location_type => $locations) { 
							?>
							<select name="update[<?php echo $shipping_id; ?>][location][]" id="shipping_<?php echo strtolower(url_title($location_type.'_'.$shipping_id, 'underscore'));?>" class="form-control input-sm">
								<option value="0" class="parent_id_0">- Select <?php echo $location_type; ?> -</option>
							<?php 
								// Note: CI's set_select() function does not return the empty '[]' from the name 'insert_option[location][]'.
								// Therefore, ensure it is set as "set_select('insert_option[location]', $id)".
								foreach($locations as $location) { 
									$id = $location[$this->flexi_cart_admin->db_column('locations', 'id')];
							?>
								<option value="<?php echo $id; ?>" class="parent_id_<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'parent')]; ?>" <?php echo set_select('update['.$shipping_id.'][location]', $id, ($shipping_location == $id)); ?>>
									<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')]; ?>
								</option>
							<?php } ?>
							</select><br/>
							<?php } ?>
						</td>
						<td>
							<?php $shipping_zone = $row[$this->flexi_cart_admin->db_column('shipping_options', 'zone')];?>
							<select name="update[<?php echo $shipping_id; ?>][zone]" class="form-control input-sm">
								<option value="0">No Shipping Zone</option>
							<?php 
								foreach($shipping_zones as $zone) { 
									$id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')];
							?>
								<option value="<?php echo $id; ?>" <?php echo set_select('update['.$shipping_id.'][zone]', $id, ($shipping_zone == $id)); ?>>
									<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')]; ?>
								</option>
							<?php } ?>
							</select>
						</td>
						<td class="text-center">
							<?php $inc_sub_locations = (bool)$row[$this->flexi_cart_admin->db_column('shipping_options', 'inc_sub_locations')]; ?>
							<input type="hidden" name="update[<?php echo $shipping_id; ?>][inc_sub_locations]" value="0"/>
							<input type="checkbox" name="update[<?php echo $shipping_id; ?>][inc_sub_locations]" value="1" <?php echo set_checkbox('update['.$shipping_id.'][inc_sub_locations]','1', $inc_sub_locations); ?>/>
						</td>
						<td class="text-center">
							<a href="<?php echo $base_url; ?>admin/shipping_rates/<?php echo $shipping_id;?>"
							class="btn btn-sm btn-info">
								<span class="fa fa-edit"></span>
							</a>
							<a href="<?php echo $base_url; ?>admin/insert_shipping_rate/<?php echo $shipping_id;?>"
							class="btn btn-sm btn-success">
								<span class="fa fa-plus"></span>
							</a> 
						</td>
						<td class="text-center">
							<input type="text" name="update[<?php echo $shipping_id; ?>][tax_rate]" value="<?php echo set_value('update['.$shipping_id.'][tax_rate]', $row[$this->flexi_cart_admin->db_column('shipping_options', 'tax_rate')]); ?>" placeholder="Default" class="form-control input-sm" style="width:80px" />
						</td>
						<td class="text-center">
							<?php $discount_inclusion = (bool)$row[$this->flexi_cart_admin->db_column('shipping_options', 'discount_inclusion')]; ?>
							<input type="hidden" name="update[<?php echo $shipping_id; ?>][discount_inclusion]" value="0"/>
							<input type="checkbox" name="update[<?php echo $shipping_id; ?>][discount_inclusion]" value="1" <?php echo set_checkbox('update['.$shipping_id.'][discount_inclusion]','1', $discount_inclusion); ?>/>
						</td>
						<td class="text-center">
							<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('shipping_options', 'status')]; ?>
							<input type="hidden" name="update[<?php echo $shipping_id; ?>][status]" value="0"/>
							<input type="checkbox" name="update[<?php echo $shipping_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$shipping_id.'][status]','1', $status); ?>/>
						</td>
						<td class="text-center">
							<input type="hidden" name="update[<?php echo $shipping_id; ?>][delete]" value="0"/>
							<input type="checkbox" name="update[<?php echo $shipping_id; ?>][delete]" value="1"/>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

			<input type="submit" name="update_shipping" value="Update Shipping Options" class="btn btn-primary"/>
		</div>
	<?php echo form_close(); ?>
<?php endif ?>

<script>
$(function() {
	// As this page is listing multiple tax options all on the same page, and therefore multiple location menus, use the jQuery 'each()' function to call the top level menu of each location type ('Country' in this example). 
	$('select[id^="shipping_country"]').each(function() 
	{
		var elem_id = $(this).attr('id');
		var shipping_id = elem_id.substring(elem_id.lastIndexOf('_')+1);
	
		// !IMPORTANT NOTE: The dependent_menu functions must be called in their reverse order - i.e. the most specific locations first.
		dependent_menu('shipping_state_'+shipping_id, 'shipping_post_zip_code_'+shipping_id, false, true);
		dependent_menu('shipping_country_'+shipping_id, 'shipping_state_'+shipping_id, ['shipping_post_zip_code_'+shipping_id], true);
	});
});
</script>

<?php $this->load->view('admin/templates/footer'); ?>