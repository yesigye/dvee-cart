<?php $this->load->view('admin/templates/header', array(
	'title' => 'Locations',
	'link' => 'location_types',
	'breadcrumbs' => array(
		0 => array('name'=>'Locations','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/locations/location_sub_header'); ?>

<div class="page-header b-0">
	<div class="lead float-left">Locations Types</div>
	<a href="<?php echo site_url('admin/insert_location_type') ?>" class="btn btn-primary float-right">
		<span class="fa fa-plus"></span> Location Type
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

<?php if (empty($location_type_data)): ?>
	<div class="alert alert-warning">
		There are no location types setup to view.
		<?php echo anchor('admin/insert_location_type', 'Insert New Location Type', 'class="alert-link"') ?>
	</div>
<?php else: ?>
	<?php echo form_open(current_url()); ?>
		<table class="table table-flat table-striped">
			<thead>
				<tr>
					<th>
						<div data-toggle="tooltip" title="The name for the type of locations that will be related. For example, 'Country', 'State' etc.">
							Location Type <span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="Sets the location types 'Parent'. For Example, 'State' would have 'Country' as its parent.">
							Parent Location Type <span class="fa fa-info-sign"></span> 
						</div>
					</th>
					<th class="text-center">
						Locations
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="If checked, the row will be deleted upon the form being updated.">
							Delete <span class="fa fa-info-sign"></span>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($location_type_data as $row): ?>
					<?php $location_type_id = $row[$this->flexi_cart_admin->db_column('location_type', 'id')]; ?>
					<tr>
						<td class="form-group <?php echo (form_error('update['.$location_type_id.'][name]')) ? 'has-error' : '' ?>">
							<input type="hidden" name="update[<?php echo $location_type_id; ?>][id]" value="<?php echo $location_type_id; ?>"/>
							<input type="text" name="update[<?php echo $location_type_id; ?>][name]" value="<?php echo set_value('update['.$location_type_id.'][name]', $row[$this->flexi_cart_admin->db_column('location_type', 'name')]); ?>" class="form-control "/>
							<?php echo form_error('update['.$location_type_id.'][name]') ?>
						</td>
						<td>
							<?php $parent_location_type = $row[$this->flexi_cart_admin->db_column('location_type', 'parent')];?>
							<select name="update[<?php echo $location_type_id; ?>][parent_location_type]" class="form-control ">
								<option value="0">No Parent Location Type</option>
							<?php 
								foreach($location_type_data as $location_type) { 
									$id = $location_type[$this->flexi_cart_admin->db_column('location_type', 'id')];
							?>
								<option value="<?php echo $id; ?>" <?php echo set_select('update['.$location_type_id.'][parent_location_type]', $id, ($parent_location_type == $id)); ?>>
									<?php echo $location_type[$this->flexi_cart_admin->db_column('location_type', 'name')]; ?>
								</option>
							<?php } ?>
							</select>
						</td>
						<td class="text-center">
							<a href="<?php echo $base_url; ?>admin/locations/<?php echo $location_type_id;?>"
							class="btn btn-success" data-toggle="tooltip"
							title = "Edit locations of type '<?php echo $row[$this->flexi_cart_admin->db_column('location_type', 'name')] ?>'">
								<span class="fa fa-edit"></span>
							</a> 
							<a href="<?php echo $base_url; ?>admin/insert_location/<?php echo $location_type_id;?>"
							class="btn btn-primary" data-toggle="tooltip"
							title = "Add location of type '<?php echo $row[$this->flexi_cart_admin->db_column('location_type', 'name')] ?>'"
							>
								<span class="fa fa-plus"></span>
							</a> 
						</td>
						<td class="text-center">
							<input type="hidden" name="update[<?php echo $location_type_id; ?>][delete]" value="0"/>
							<input type="checkbox" name="update[<?php echo $location_type_id; ?>][delete]" value="1"/>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		
		<input type="submit" name="update_location_types" value="Update Location Types" class="btn btn-success"/>
	<?php echo form_close(); ?>						
<?php endif ?>

<?php $this->load->view('admin/templates/footer'); ?>