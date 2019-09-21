<?php $this->load->view('admin/templates/header', array(
	'title' => 'Locations',
	'link' => 'locations',
	'breadcrumbs' => array(
		0 => array('name'=>'Locations','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/locations/location_sub_header'); ?>

<div class="lead page-header b-0">Insert New <?php echo $location_type_data[$this->flexi_cart_admin->db_column('location_type', 'name')]; ?></div>

<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>
									
<?php echo form_open(current_url()); ?>
	<table class="table table-flat table-striped">
		<thead>
			<tr>
				<th>
					<div data-toggle="tooltip" title="Name of the location.">
						<span class="fa fa-asterisk text-danger"></span>
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
					<div data-toggle="tooltip" title="Copy or remove a specific row and its data.">
						Copy / Remove <span class="fa fa-info-sign"></span>
					</div>
				</th>
			</tr>
		</thead>
		<tbody>						
		<?php 
			for($i = 0; ($i == 0 || (isset($validation_row_ids[$i]))); $i++) { 
				$row_id = (isset($validation_row_ids[$i])) ? $validation_row_ids[$i] : $i;
		?>
			<tr>
				<td class="form-group <?php echo (form_error('insert['.$row_id.'][name]')) ? 'has-error' : '' ?>">
					<input type="text" name="insert[<?php echo $row_id; ?>][name]" value="<?php echo set_value('insert['.$row_id.'][name]');?>" class="form-control "/>
					<?php echo form_error('insert['.$row_id.'][name]') ?>
				</td>
				<td>
					<select name="insert[<?php echo $row_id; ?>][parent_location]" class="form-control ">
						<option value="0">No Parent Location</option>
					<?php 
						foreach($locations_inline as $location) { 
							$id = $location[$this->flexi_cart_admin->db_column('locations', 'id')];
					?>
						<option value="<?php echo $id; ?>" <?php echo set_select('insert['.$row_id.'][parent_location]', $id); ?>>
							<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')]; ?>
						</option>
					<?php } ?>
					</select>
				</td>
				<td>
					<select name="insert[<?php echo $row_id; ?>][shipping_zone]" class="form-control ">
						<option value="0">No Shipping Zone</option>
					<?php 
						foreach($shipping_zones as $zone) { 
							$id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')];
					?>
						<option value="<?php echo $id; ?>" <?php echo set_select('insert['.$row_id.'][shipping_zone]', $id); ?>>
							<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')]; ?>
						</option>
					<?php } ?>
					</select>
				</td>
				<td>
					<select name="insert[<?php echo $row_id; ?>][tax_zone]" class="form-control ">
						<option value="0">No Tax Zone</option>
					<?php 
						foreach($tax_zones as $zone) { 
							$id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')];
					?>
						<option value="<?php echo $id; ?>" <?php echo set_select('insert['.$row_id.'][tax_zone]', $id); ?>>
							<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')]; ?>
						</option>
					<?php } ?>
					</select>
				</td>
				<td class="text-center">
					<input type="hidden" name="insert[<?php echo $row_id; ?>][status]" value="0"/>
					<input type="checkbox" name="insert[<?php echo $row_id; ?>][status]" value="1" <?php echo set_checkbox('insert['.$row_id.'][status]', 1, TRUE); ?>/>
				</td>
				<td class="text-center">
					<input type="button" value="+" class="copy_row btn btn-sm btn-default"/>
					<input type="button" value="x" <?php echo ($i == 0) ? 'disabled="disabled"' : NULL;?> class="remove_row btn btn-sm btn-default"/>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	
	<input type="submit" name="insert_location" value="Insert New <?php echo $location_type_data[$this->flexi_cart_admin->db_column('location_type', 'name')]; ?> Locations" class="btn btn-primary"/>
<?php echo form_close();?>						

<?php $this->load->view('admin/templates/footer'); ?>