<?php $this->load->view('admin/templates/header', array(
	'title' => 'Taxes',
	'link' => 'tax',
	'breadcrumbs' => array(
		0 => array('name'=>'Manage Taxes','link'=>FALSE),
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

<?php if (empty($tax_data)): ?>
	<div class="alert alert-warning">
		There are no taxes setup to view for this item.
		<?php echo anchor('admin/insert_tax', 'Insert New Tax', 'class="alert-link"') ?>
	</div>
<?php else: ?>
	<?php echo form_open(current_url()); ?>
		<table class="table table-flat table-striped">
			<thead>
				<tr>
					<th>
						<div data-toggle="tooltip" title="The name of the tax rate.">
							<span class="fa fa-asterisk text-danger"></span>
							Name
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="Set the location that the tax rate is applied to.">
							Location
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="Set the zone that the tax rate is applied to. Note: If a location is set, it has priority over a zone rule.">
							Zone
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="Sets the tax rate as a percentage.">
							<span class="fa fa-asterisk text-danger"></span>
							Tax Rate (%)
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="If checked, the tax rate will be set as 'active'.">
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
				foreach ($tax_data as $row) {
					$tax_id = $row[$this->flexi_cart_admin->db_column('tax', 'id')];
				?>
				<tr>
					<td class="form-group <?php echo form_error('update['.$tax_id.'][name]') ? 'has-error' : '' ?>">
						<input type="hidden" name="update[<?php echo $tax_id; ?>][id]" value="<?php echo $tax_id; ?>"/>
						<input type="text" name="update[<?php echo $tax_id; ?>][name]" value="<?php echo set_value('update['.$tax_id.'][name]', $row[$this->flexi_cart_admin->db_column('tax', 'name')]); ?>" class="form-control"/>
						<?php echo form_error('update['.$tax_id.'][name]') ?>
					</td>
					<td>
						<?php 
						$tax_location = $row[$this->flexi_cart_admin->db_column('tax', 'location')];								
						foreach($locations_tiered as $location_type => $locations) { 
						?>
						<select name="update[<?php echo $tax_id; ?>][location][]" id="tax_<?php echo strtolower(url_title($location_type.'_'.$tax_id, 'underscore'));?>" class="form-control">
							<option value="0" class="parent_id_0">- Select <?php echo $location_type; ?> -</option>
							<?php 
							// Note: CI's set_select() function does not return the empty '[]' from the name 'insert['.$tax_id.'][location][]'.
							// Therefore, ensure it is set as "set_select('insert['.$tax_id.'][location]', $id)".
							foreach($locations as $location) { 
								$id = $location[$this->flexi_cart_admin->db_column('locations', 'id')];
							?>
							<option value="<?php echo $id; ?>" class="parent_id_<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'parent')]; ?>" <?php echo set_select('update['.$tax_id.'][location]', $id, ($tax_location == $id)); ?>>
								<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')]; ?>
							</option>
							<?php } ?>
						</select>
						<?php } ?>
					</td>
					<td>
						<?php $tax_zone = $row[$this->flexi_cart_admin->db_column('tax', 'zone')];?>
						<select name="update[<?php echo $tax_id; ?>][zone]" class="form-control">
							<option value="0">No Tax Zone</option>
							<?php 
							foreach($tax_zones as $zone) { 
								$id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')];
							?>
							<option value="<?php echo $id; ?>" <?php echo set_select('update['.$tax_id.'][zone]', $id, ($tax_zone == $id)); ?>>
								<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')]; ?>
							</option>
							<?php } ?>
						</select>
					</td>
					<td class="form-group <?php echo form_error('update['.$tax_id.'][rate]') ? 'has-error' : '' ?>">
						<input type="text" name="update[<?php echo $tax_id; ?>][rate]" value="<?php echo set_value('update['.$tax_id.'][rate]', round($row[$this->flexi_cart_admin->db_column('tax', 'rate')],4)); ?>" class="form-control validate_decimal" style="width:90px"/>
						<?php echo form_error('update['.$tax_id.'][rate]') ?>
					</td>
					<td class="text-center">
						<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('tax', 'status')]; ?>
						<input type="hidden" name="update[<?php echo $tax_id; ?>][status]" value="0"/>
						<input type="checkbox" name="update[<?php echo $tax_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$tax_id.'][status]','1', $status); ?>/>
					</td>
					<td class="text-center">
						<input type="hidden" name="update[<?php echo $tax_id; ?>][delete]" value="0"/>
						<input type="checkbox" name="update[<?php echo $tax_id; ?>][delete]" value="1"/>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
		<input type="submit" name="update_tax" value="Update Taxes" class="btn btn-success"/>
	<?php echo form_close();?>						

<?php endif ?>

<script>
$(function() {
	// As this page is listing multiple tax options all on the same page, and therefore multiple location menus, use the jQuery 'each()' function to call the top level menu of each location type ('Country' in this example). 
	$('select[id^="tax_country"]').each(function() 
	{
		var elem_id = $(this).attr('id');
		var tax_id = elem_id.substring(elem_id.lastIndexOf('_')+1);
	
		// !IMPORTANT NOTE: The dependent_menu functions must be called in their reverse order - i.e. the most specific locations first.
		dependent_menu('tax_state_'+tax_id, 'tax_post_zip_code_'+tax_id, false, true);
		dependent_menu('tax_country_'+tax_id, 'tax_state_'+tax_id, ['tax_post_zip_code_'+tax_id], true);
	});
});
</script>

<?php $this->load->view('admin/templates/footer'); ?>