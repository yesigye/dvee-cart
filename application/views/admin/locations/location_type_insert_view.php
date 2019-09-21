<?php $this->load->view('admin/templates/header', array(
	'title' => 'Locations',
	'link' => 'locations',
	'sub_link' => 'location_types',
	'breadcrumbs' => array(
		0 => array('name'=>'Locations','link'=>'location_types'),
		1 => array('name'=>'Insert New Location Type','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/locations/location_sub_header'); ?>

<div class="page-header b-0">
	<div class="lead float-left">Insert Locations Type</div>
	<a href="<?php echo site_url('admin/location_types') ?>" class="btn btn-success float-right">
		Location Types
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


<?php echo form_open(current_url()); ?>
	<table class="table table-flat table-striped">
		<thead>
			<tr>
				<th class="spacer_250 info_req tooltip_trigger"
					title="The name for the type of locations that will be related. <br/>For example, 'Country', 'State' etc.">
					Location Type
					<span class="fa fa-asterisk text-danger"></span>
				</th>
				<th class="tooltip_trigger"
					title="Sets the location types 'Parent'. For Example, 'State' would have 'Country' as its parent.">
					Parent Location Type 
				</th>
				<th class="spacer_125 text-center tooltip_trigger" 
					title="Copy or remove a specific row and its data.">
					Copy / Remove
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
					<input type="text" name="insert[<?php echo $row_id; ?>][name]" value="<?php echo set_value('insert['.$row_id.'][name]');?>" class="form-control  validate_alpha"/>
					<?php echo form_error('insert['.$row_id.'][name]') ?>
				</td>
				<td>
					<select name="insert[<?php echo $row_id; ?>][parent_location_type]" class="form-control ">
						<option value="0">No Parent Location Type</option>
					<?php 
						foreach($location_type_data as $location_type) { 
							$id = $location_type[$this->flexi_cart_admin->db_column('location_type', 'id')];
					?>
						<option value="<?php echo $id; ?>" <?php echo set_select('insert['.$row_id.'][parent_location_type]', $id); ?>>
							<?php echo $location_type[$this->flexi_cart_admin->db_column('location_type', 'name')]; ?>
						</option>
					<?php } ?>
					</select>
				</td>
				<td class="text-center">
					<input type="button" value="+" class="copy_row link_button"/>
					<input type="button" value="x" <?php echo ($i == 0) ? 'disabled="disabled"' : NULL;?> class="remove_row link_button"/>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	
	<input type="submit" name="insert_location_type" value="Insert New Location Types" class="btn btn-primary"/>
<?php echo form_close();?>

<?php $this->load->view('admin/templates/footer'); ?>