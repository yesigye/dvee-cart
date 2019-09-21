<?php $this->load->view('admin/templates/header', array(
	'title' => 'Zones',
	'link' => 'zones',
	'breadcrumbs' => array(
		0 => array('name'=>'Locations','link'=>'location_types'),
	)
)); ?>

<?php $this->load->view('admin/locations/location_sub_header'); ?>

<div class="d-flex justify-content-between mb-3">
	<div class="lead">Locations Zones</div>
	<a href="<?php echo site_url('admin/insert_zone') ?>" class="btn btn-primary">
		<span class="fa fa-plus"></span> Zone
	</a>
</div>

<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>

<?php if (empty($location_zone_data)): ?>
	<div class="alert alert-warning">
		There are no zones setup to view.
		<?php echo anchor('admin/insert_zone', 'Insert New Zone', 'class="alert-link"') ?>
	</div>
<?php else: ?>
	<?php echo form_open(current_url()); ?>
		<table class="table table-flat table-striped">
			<thead>
				<tr>
					<th>
						<div data-toggle="tooltip" title="The name of the zone.">
							<span class="fa fa-danger"></span>
							Name
							<span class="fa fa-info-circle small">
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="A brief description of the purpose of the zone and the regions covered.">
							Description
							<span class="fa fa-info-circle small">
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="If checked, the zone will be set as 'active'.">
							Active
							<span class="fa fa-info-circle small">
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="If checked, the row will be deleted upon the form being updated.">
							Delete
							<span class="fa fa-info-circle small">
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($location_zone_data as $row) {
					$location_zone_id = $row[$this->flexi_cart_admin->db_column('location_zones', 'id')];
				?>
				<tr>
					<td class="form-group <?php echo form_error('update['.$location_zone_id.'][name]') ? 'has-error' : '' ?>">
						<input type="hidden" name="update[<?php echo $location_zone_id; ?>][id]" value="<?php echo $location_zone_id; ?>"/>
						<input type="text" name="update[<?php echo $location_zone_id; ?>][name]" value="<?php echo set_value('update['.$location_zone_id.'][name]',$row[$this->flexi_cart_admin->db_column('location_zones', 'name')]); ?>" class="form-control "/>
						<?php echo form_error('update['.$location_zone_id.'][name]') ?>
					</td>
					<td>
						<textarea name="update[<?php echo $location_zone_id; ?>][description]" class="form-control"><?php echo set_value('update['.$location_zone_id.'][description]',$row[$this->flexi_cart_admin->db_column('location_zones', 'description')]); ?></textarea>
					</td>
					<td class="text-center">
						<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('location_zones', 'status')]; ?>
						<input type="hidden" name="update[<?php echo $location_zone_id; ?>][status]" value="0"/>
						<input type="checkbox" name="update[<?php echo $location_zone_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$location_zone_id.'][status]','1', $status); ?>/>
					</td>
					<td class="text-center">
						<input type="hidden" name="update[<?php echo $location_zone_id; ?>][delete]" value="0"/>
						<input type="checkbox" name="update[<?php echo $location_zone_id; ?>][delete]" value="1"/>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
		<input type="submit" name="update_zones" value="Update Zones" class="btn btn-success"/>
	<?php echo form_close(); ?>
<?php endif ?>

<?php $this->load->view('admin/templates/footer'); ?>