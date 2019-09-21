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
		Shipping Rates for
		<?php echo $shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'name')];?>
	</div>
	<?php echo anchor('admin/insert_shipping_rate/'.$shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'id')], 'Insert New Shipping Rate', 'class="float-right btn btn-primary"') ?>
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
					<div data-toggle="tooltip" title="If checked, the row will be deleted upon the form being updated.">
						Delete
						<span class="fa fa-info-sign"></span>
					</div>
				</th>
			</tr>
		</thead>
	<?php if (!empty($shipping_rate_data)) { ?>	
		<tbody>
		<?php 
			foreach ($shipping_rate_data as $row) {
				$shipping_rate_id = $row[$this->flexi_cart_admin->db_column('shipping_rates', 'id')];
		?>
			<tr>
				<td>
					<input type="hidden" name="update[<?php echo $shipping_rate_id; ?>][id]" value="<?php echo $shipping_rate_id; ?>"/>
					<input type="hidden" name="update[<?php echo $shipping_rate_id; ?>][parent_id]" value="<?php echo $row[$this->flexi_cart_admin->db_column('shipping_rates', 'parent')]; ?>"/>
					<input type="text" name="update[<?php echo $shipping_rate_id; ?>][value]" value="<?php echo set_value('update['.$shipping_rate_id.'][value]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'value')]); ?>" class="form-control" style="width:100px"/>
				</td>
				<td>
					<input type="text" name="update[<?php echo $shipping_rate_id; ?>][tare_weight]" value="<?php echo set_value('update['.$shipping_rate_id.'][tare_weight]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'tare_weight')]); ?>" class="form-control" style="width:100px"/>
				</td>
				<td>
					<input type="text" name="update[<?php echo $shipping_rate_id; ?>][min_weight]" value="<?php echo set_value('update['.$shipping_rate_id.'][min_weight]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'min_weight')]); ?>" class="form-control" style="width:100px"/>
				</td>
				<td>
					<input type="text" name="update[<?php echo $shipping_rate_id; ?>][max_weight]" value="<?php echo set_value('update['.$shipping_rate_id.'][max_weight]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'max_weight')]); ?>" class="form-control" style="width:100px"/>
				</td>
				<td>
					<input type="text" name="update[<?php echo $shipping_rate_id; ?>][min_value]" value="<?php echo set_value('update['.$shipping_rate_id.'][min_value]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'min_value')]); ?>" class="form-control" style="width:100px"/>
				</td>
				<td>
					<input type="text" name="update[<?php echo $shipping_rate_id; ?>][max_value]" value="<?php echo set_value('update['.$shipping_rate_id.'][max_value]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'max_value')]); ?>" class="form-control" style="width:100px"/>
				</td>
				<td class="text-center">
					<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('shipping_rates', 'status')]; ?>
					<input type="hidden" name="update[<?php echo $shipping_rate_id; ?>][status]" value="0"/>
					<input type="checkbox" name="update[<?php echo $shipping_rate_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$shipping_rate_id.'][status]','1', $status); ?>/>
				</td>
				<td class="text-center">
					<input type="hidden" name="update[<?php echo $shipping_rate_id; ?>][delete]" value="0"/>
					<input type="checkbox" name="update[<?php echo $shipping_rate_id; ?>][delete]" value="1"/>
				</td>
			</tr>
		<?php } ?>	
		</tbody>
	</table>
	
	<input type="submit" name="update_shipping_rates" value="Update Shipping Rates" class="btn btn-success"/>
	<?php } else { ?>
		<div class="alert alert-warning">
			There are no rates for this shipping option setup to view.
			<a href="<?php echo site_url('admin/insert_shipping_rate/'.$shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'id')]) ?>">
				Insert New Shipping Rate
			</a>
		</div>
	<?php } ?>
<?php echo form_close();?>						

<?php $this->load->view('admin/templates/footer'); ?>