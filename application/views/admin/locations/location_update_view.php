<?php $this->load->view('admin/templates/header', array(
	'title' => 'Locations',
	'link' => 'location_types',
	'breadcrumbs' => array(
		0 => array('name'=>'Locations','link'=>'location_types'),
		1 => array('name'=>'Manage '.$location_type_data[$this->flexi_cart_admin->db_column('location_type', 'name')].'Locations','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/locations/location_sub_header'); ?>

<div class="page-header b-0">
	<div class="lead float-left">Manage <?php echo $location_type_data[$this->flexi_cart_admin->db_column('location_type', 'name')] ?> Locations</div>
	<a href="<?php echo site_url('admin/insert_location/'.$location_type_data[$this->flexi_cart_admin->db_column('location_type', 'id')]) ?>" class="btn btn-success float-right">
		<span class="fa fa-plus"></span>
		<?php echo $location_type_data[$this->flexi_cart_admin->db_column('location_type', 'name')] ?>
	</a>
	<div class="clearfix"></div>
</div>

<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>

<?php if (empty($location_data)): ?>
	<div class="alert alert-warning">
		There are no locations within this location type setup to view.
		<?php echo anchor('admin/insert_location'.$location_type_data[$this->flexi_cart_admin->db_column('location_type', 'id')],
		'Insert New '.$location_type_data[$this->flexi_cart_admin->db_column('location_type', 'name')], 'class="alert-link"') ?>
	</div>
<?php else: ?>
	<?php echo form_open(current_url()); ?>
		<table class="table table-flat table-striped">
			<thead>
				<tr>
					<th>
						<div data-toggle="tooltip" title="Name of the location.">
							Name <span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="Sets the locations 'Parent'. For Example, 'New York' would have 'United States' as its parent.">
							Parent Location <span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="Locations can be grouped together with other non-related locations into Shipping Zones. Shipping rates can then be applied to all locations within these zones. For example, 'Eastern Europe' and 'Western Europe'.">
							Shipping Zone <span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="Locations can be grouped together with other non-related locations into Tax Zones. Tax rates can then be applied to all locations within these zones. For example, 'European EU Countries' and 'European Non-EU Countries'.">
							Tax Zone <span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="If checked, the location will be set as 'active'.">
							Active <span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="If checked, the row will be deleted upon the form being updated.">
							Delete <span class="fa fa-info-sign"></span>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($location_data as $row) {
					$location_id = $row[$this->flexi_cart_admin->db_column('locations', 'id')];								
				?>
				<tr>
					<td class="form-group <?php echo (form_error('update['.$location_id.'][name]')) ? 'has-error' : '' ?>">
						<input type="hidden" name="update[<?php echo $location_id; ?>][id]" value="<?php echo $location_id; ?>"/>
						<input type="text" name="update[<?php echo $location_id; ?>][name]" value="<?php echo set_value('update['.$location_id.'][name]', $row[$this->flexi_cart_admin->db_column('locations', 'name')]); ?>" class="form-control "/>
						<?php echo form_error('update['.$location_id.'][name]'); ?>
					</td>
					<td>
						<?php $parent_location = $row[$this->flexi_cart_admin->db_column('locations', 'parent')];?>
						<select name="update[<?php echo $location_id; ?>][parent_location]" class="form-control ">
							<option value="0">No Parent Location</option>
						<?php 
							foreach($locations_inline as $location) { 
								$id = $location[$this->flexi_cart_admin->db_column('locations', 'id')];
						?>
							<option value="<?php echo $id; ?>" <?php echo set_select('update['.$location_id.'][parent_location]', $id, ($parent_location == $id)); ?>>
								<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')]; ?>
							</option>
						<?php } ?>
						</select>
					</td>
					<td>
						<?php $shipping_zone = $row[$this->flexi_cart_admin->db_column('locations', 'shipping_zone')];?>
						<select name="update[<?php echo $location_id; ?>][shipping_zone]" class="form-control ">
							<option value="0">No Shipping Zone</option>
						<?php 
							foreach($shipping_zones as $zone) { 
								$id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')];
						?>
							<option value="<?php echo $id; ?>" <?php echo set_select('update['.$location_id.'][shipping_zone]', $id, ($shipping_zone == $id)); ?>>
								<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')]; ?>
							</option>
						<?php } ?>
						</select>
					</td>
					<td>
						<?php $tax_zone = $row[$this->flexi_cart_admin->db_column('locations', 'tax_zone')];?>
						<select name="update[<?php echo $location_id; ?>][tax_zone]" class="form-control ">
							<option value="0">No Tax Zone</option>
						<?php 
							foreach($tax_zones as $zone) { 
								$id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')];
						?>
							<option value="<?php echo $id; ?>" <?php echo set_select('update['.$location_id.'][tax_zone]', $id, ($tax_zone == $id)); ?>>
								<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')]; ?>
							</option>
						<?php } ?>
						</select>
					</td>
					<td class="text-center">
						<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('locations', 'status')]; ?>
						<input type="hidden" name="update[<?php echo $location_id; ?>][status]" value="0"/>
						<input type="checkbox" name="update[<?php echo $location_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$location_id.'][status]', 0, $status); ?>/>
					</td>
					<td class="text-center">
						<input type="hidden" name="update[<?php echo $location_id; ?>][delete]" value="0"/>
						<input type="checkbox" name="update[<?php echo $location_id; ?>][delete]" value="1"/>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>					
		
		<input type="submit" name="update_locations" value="Update <?php echo $location_type_data['loc_type_name']; ?> Locations" class="btn btn-primary"/>
	<?php echo form_close(); ?>
<?php endif ?>

<?php $this->load->view('admin/templates/footer'); ?>