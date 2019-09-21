<?php $this->load->view('admin/templates/header', array(
	'title' => 'Update Currency',
	'link' => 'settings',
	'sub_link' => 'currency',
	'breadcrumbs' => array(
		0 => array('name'=>'Settings','link'=>'config'),
		1 => array('name'=>'Currencies','link'=>'currency'),
		2 => array('name'=>'Add New Currency','link'=>FALSE),
	)
)); ?>

<h4 class="lead">Insert New Currency</h4>
<p class="text-muted">The base cart currency used for coversions is GBP and the base value is 1.</p>

<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>

<?php echo form_open(current_url()); ?>	
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="info_req tooltip_trigger"
						title="The name of the currency.">
						Name
						<small class="faefa-danger"></small>
					</th>
					<th class="info_req tooltip_trigger"
						title="The exchange rate of the currency compared to the carts default currency.">
						Exchange Rate
						<small class="faefa-danger"></small>
					</th>
					<th class="info_req tooltip_trigger"
						title="The currency symbol to display with currency values. For example '$' to display '$9.99'.">
						Symbol HTML
						<small class="faefa-danger"></small>
					</th>
					<th class="spacer_75 text-center tooltip_trigger"
						title="If checked, the currency symbol will be suffixed to the end of the currency value rather than the front. For example<br/> Checked: '9.99&euro;',<br/> Unchecked: '&pound;9.99'.">
						Suffix
					</th>
					<th class="info_req tooltip_trigger"
						title="The character used to separate currencies in excess of a thousand.<br/> For example, the comma in '1,000'.">
						Thousand
						<small class="faefa-danger"></small>
					</th>
					<th class="info_req tooltip_trigger"
						title="The character used to separate a currencies decimal value.<br/> For example, the period in '99.99'.">
						Decimal
						<small class="faefa-danger"></small>
					</th>
					<th class="spacer_75 text-center tooltip_trigger" 
						title="If checked, the currency will be set as 'active'.">
						Status
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
					<td class="form-group <?php echo form_error('insert['.$row_id.'][name]') ? 'has-error' : '' ?>">
						<input type="text" name="insert[<?php echo $row_id; ?>][name]" value="<?php echo set_value('insert['.$row_id.'][name]');?>" class="form-control"/>
						<?php echo form_error('insert['.$row_id.'][name]') ?>
					</td>
					<td class="form-group <?php echo form_error('insert['.$row_id.'][exchange_rate]') ? 'has-error' : '' ?>">
						<input type="text" name="insert[<?php echo $row_id; ?>][exchange_rate]" value="<?php echo set_value('insert['.$row_id.'][exchange_rate]');?>" class="form-control validate_decimal" style="width:90px"/>
						<?php echo form_error('insert['.$row_id.'][exchange_rate]') ?>
					</td>
					<td class="form-group <?php echo form_error('insert['.$row_id.'][symbol]') ? 'has-error' : '' ?>">
						<input type="text" name="insert[<?php echo $row_id; ?>][symbol]" value="<?php echo set_value('insert['.$row_id.'][symbol]');?>" class="form-control validate_alpha" style="width:90px"/>
						<?php echo form_error('insert['.$row_id.'][symbol]') ?>
					</td>
					<td class="text-center form-group <?php echo form_error('insert['.$row_id.'][symbol_suffix]') ? 'has-error' : '' ?>">
						<input type="hidden" name="insert[<?php echo $row_id; ?>][symbol_suffix]" value="0"/>
						<input type="checkbox" name="insert[<?php echo $row_id; ?>][symbol_suffix]" value="1" <?php echo set_checkbox('insert['.$row_id.'][symbol_suffix]', '1'); ?>/>
						<?php echo form_error('insert['.$row_id.'][symbol_suffix]') ?>
					</td>
					<td class="form-group <?php echo form_error('insert['.$row_id.'][thousand]') ? 'has-error' : '' ?>">
						<input type="text" name="insert[<?php echo $row_id; ?>][thousand]" value="<?php echo set_value('insert['.$row_id.'][thousand]');?>" class="form-control validate_alpha" style="width:90px"/>
						<?php echo form_error('insert['.$row_id.'][thousand]') ?>
					</td>
					<td class="form-group <?php echo form_error('insert['.$row_id.'][decimal]') ? 'has-error' : '' ?>">
						<input type="text" name="insert[<?php echo $row_id; ?>][decimal]" value="<?php echo set_value('insert['.$row_id.'][decimal]');?>" class="form-control validate_alpha" style="width:90px"/>
						<?php echo form_error('insert['.$row_id.'][decimal]') ?>
					</td>
					<td class="text-center form-group <?php echo form_error('insert['.$row_id.'][status]') ? 'has-error' : '' ?>">
						<input type="hidden" name="insert[<?php echo $row_id; ?>][status]" value="0"/>
						<input type="checkbox" name="insert[<?php echo $row_id; ?>][status]" value="1" <?php echo set_checkbox('insert['.$row_id.'][status]', '1', TRUE); ?>/>
						<?php echo form_error('insert['.$row_id.'][status]') ?>
					</td>
					<td class="text-center">
						<input type="button" value="+" class="copy_row link_button"/>
						<input type="button" value="x" <?php echo ($i == 0) ? 'disabled="disabled"' : NULL;?> class="remove_row link_button"/>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<input type="submit" name="insert_currency" value="Insert New Currency" class="btn btn-primary my-3"/>
<?php echo form_close(); ?>						

<?php $this->load->view('admin/templates/footer'); ?>