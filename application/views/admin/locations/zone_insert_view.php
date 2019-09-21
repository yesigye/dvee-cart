<?php $this->load->view('admin/templates/header', array(
	'title' => 'Zones',
	'link' => 'zones',
	'sub_link' => 'insert_zone',
	'breadcrumbs' => array(
		0 => array('name'=>'Zones','link'=>'zones'),
		1 => array('name'=>'Insert New Location Zone','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/locations/location_sub_header'); ?>

<div class="lead page-header b-0">Insert a new Zone</div>

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
					<div data-toggle="tooltip" title="The name of the zone.">
						<span class="faefa-danger"></span>
						Name
						<span class="faofaspan>
					</div>
				</th>
				<th>
					<div data-toggle="tooltip" title="A brief description of the purpose of the zone and the regions covered.">
						Description
						<span class="faofaspan>
					</div>
				</th>
				<th class="text-center">
					<div data-toggle="tooltip" title="If checked, the zone will be set as 'active'.">
						Active
						<span class="faofaspan>
					</div>
				</th>
				<th class="text-center">
					<div data-toggle="tooltip" title="If checked, the row will be deleted upon the form being updated.">
						Delete
						<span class="faofaspan>
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
				<td class="form-group <?php echo form_error('insert['.$row_id.'][name]') ? 'has-error' : '' ?>">
					<input type="text" name="insert[<?php echo $row_id; ?>][name]" value="<?php echo set_value('insert['.$row_id.'][name]');?>" class="form-control "/>
					<?php echo form_error('insert['.$row_id.'][name]') ?>
				</td>
				<td>
					<textarea name="insert[<?php echo $row_id; ?>][description]" class="form-control "><?php echo set_value('insert['.$row_id.'][description]');?></textarea>
				</td>
				<td class="text-center">
					<input type="hidden" name="insert[<?php echo $row_id; ?>][status]" value="0"/>
					<input type="checkbox" name="insert[<?php echo $row_id; ?>][status]" value="1" <?php echo set_checkbox('insert['.$row_id.'][status]', '1', TRUE); ?>/>
				</td>
				<td class="text-center">
					<input type="button" value="+" class="copy_row btn btn-sm btn-default"/>
					<input type="button" value="x" <?php echo ($i == 0) ? 'disabled="disabled"' : NULL;?> class="remove_row btn btn-sm btn-default"/>
				</td>
			</tr>
		<?php } ?>
		</tbody>
	</table>

	<input type="submit" name="insert_zone" value="Insert New Location Zones" class="btn btn-primary"/>
<?php echo form_close(); ?>

<?php $this->load->view('admin/templates/footer'); ?>