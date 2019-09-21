<?php $this->load->view('admin/templates/header', array(
	'title' => 'Shipping',
	'link' => 'shipping',
	'breadcrumbs' => array(
		0 => array('name'=>'Shipping','link'=>'shipping'),
		1 => array('name'=>'Shipping Rates','link'=>'shipping_rates/'.$shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'id')]),
		2 => array('name'=>$shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'name')],'link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/shipping/shipping_sub_header'); ?>

<div class="page-header b-0">
	<div class="lead float-left">
		Add Shipping Rates for
		<?php echo $shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'name')];?>
	</div>
	<a href="<?php echo $base_url; ?>admin/shipping_rates/<?php echo $shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'id')];?>" class="btn btn-success float-right">
		Manage <?php echo $shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'name')];?> Rates
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
				<th>
					<div data-toggle="tooltip" title="<strong>Field Required</strong><br/>The shipping rate of the shipping option tier.">
						Rate (&pound;)
						<span class="fa fa-info-sign"></span>
					</div>
				</th>
				<th>
					<div data-toggle="tooltip" title="The tare weight represents the weight of the packaging material required for shipping. The weight is included when matching shipping options with the weight of the cart items.">
						Tare Weight (g)
						<span class="fa fa-info-sign"></span>
					</div>
				</th>
				<th>
					<div data-toggle="tooltip" title="Sets the minimum weight required to activate the shipping option tier. <br/>Note: The 'tare weight' will be included when weighing the cart items.">
						Min Weight (g)
						<span class="fa fa-info-sign"></span>
					</div>
				</th>
				<th>
					<div data-toggle="tooltip" title="Sets the maximum weight permitted to activate the shipping option tier. <br/>Note: The 'tare weight' will be included when weighing the cart items.">
						Max Weight (g)
						<span class="fa fa-info-sign"></span>
					</div>
				</th>
				<th>
					<div data-toggle="tooltip" title="Sets the minimum value of the cart that is required to activate the shipping option tier.">
						Min Value (&pound;)
						<span class="fa fa-info-sign"></span>
					</div>
				</th>
				<th>
					<div data-toggle="tooltip" title="Sets the maximum value of the cart that is permitted to activate the shipping option tier.">
						Max Value (&pound;)
						<span class="fa fa-info-sign"></span>
					</div>
				</th>
				<th class="text-center">
					<div data-toggle="tooltip" title="If checked, the shipping rate tier will be set as 'active'.">
						Status
						<span class="fa fa-info-sign"></span>
					</div>
				</th>
				<th class="text-center">
					<div data-toggle="tooltip" title="Copy or remove a specific row and its data.">
						Copy / Remove
						<span class="fa fa-info-sign"></span>
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
				<td>
					<input type="text" name="insert[<?php echo $row_id; ?>][value]" value="<?php echo set_value('insert['.$row_id.'][value]', '0.00');?>" class="form-control" style="width:100px""/>
				</td>
				<td>
					<input type="text" name="insert[<?php echo $row_id; ?>][tare_weight]" value="<?php echo set_value('insert['.$row_id.'][tare_weight]', '0');?>" class="form-control" style="width:100px""/>
				</td>
				<td>
					<input type="text" name="insert[<?php echo $row_id; ?>][min_weight]" value="<?php echo set_value('insert['.$row_id.'][min_weight]', '0');?>" class="form-control" style="width:100px""/>
				</td>
				<td>
					<input type="text" name="insert[<?php echo $row_id; ?>][max_weight]" value="<?php echo set_value('insert['.$row_id.'][max_weight]',' 9999');?>" class="form-control" style="width:100px""/>
				</td>
				<td>
					<input type="text" name="insert[<?php echo $row_id; ?>][min_value]" value="<?php echo set_value('insert['.$row_id.'][min_value]', '0.00');?>" class="form-control" style="width:100px""/>
				</td>
				<td>
					<input type="text" name="insert[<?php echo $row_id; ?>][max_value]" value="<?php echo set_value('insert['.$row_id.'][max_value]', '9999.00');?>" class="form-control" style="width:100px""/>
				</td>
				<td class="text-center">
					<input type="hidden" name="insert[<?php echo $row_id; ?>][status]" value="0"/>
					<input type="checkbox" name="insert[<?php echo $row_id; ?>][status]" value="1" <?php echo set_checkbox('insert['.$row_id.'][status]', '1', TRUE); ?>/>
				</td>
				<td class="text-center">
					<input type="button" value="+" class="copy_row link_button"/>
					<input type="button" value="x" <?php echo ($i == 0) ? 'disabled="disabled"' : NULL;?> class="remove_row link_button"/>
				</td>
			</tr>
		<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8">
				</td>
			</tr>
		</tbody>
	</table>

	<input type="submit" name="insert_shipping_rate" value="Insert Shipping Option Rates" class="btn btn-primary"/>
<?php echo form_close();?>

<?php $this->load->view('admin/templates/footer'); ?>