<?php $this->load->view('admin/templates/header', array(
	'title' => 'Orders',
	'link' => 'orders',
	'sub_link' => 'status',
	'breadcrumbs' => array(
		0 => array('name'=>'Orders','link'=>'orders'),
		1 => array('name'=>'Order Statuses','link'=>FALSE),
	)
)); ?>

<div class="page-header b-0">
	<h4 class="lead float-left">Manage Order Statuses</h4>
	<a href="<?php echo site_url('admin/insert_order_status') ?>" class="btn btn-primary float-right">
		<span class="fa fa-plus"></span> Order Status
	</a>
	<div class="clearfix"></div>
</div>
				
<?php if (! empty($message)) { ?>
	<div id="message"><?= $message; ?></div>
<?php } ?> 

<p class="text-right">
</p>

<?php echo form_open(current_url()); ?>
	<?php if (empty($order_status_data)): ?>
		<div class="alert alert-warning">
			There are no order statuses setup to view.
			<?php echo anchor('admin/insert_order_status', 'Insert New Order Status', 'class="alert-link"') ?>
		</div>
	<?php else: ?>
		<table class="table table-flat table-striped">
			<thead>
				<tr>
					<th title="The name/description of the order status.">
						Description
					</th>
					<th class="text-center" title="If checked, it indicates that the order status 'Cancels' the order.">
						Cancel Order
					</th>
					<th class="text-center" title="If checked, it indicates that the order status is the default status that is applied to a 'saved' order.">
						Save Default
					</th>
					<th class="text-center" title="If checked, it indicates that the order status is the default status that is applied to a 'resaved' order.">
						Resave Default
					</th>
					<th class="text-center" title="If checked, the row will be deleted upon the form being updated.">
						Delete
					</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($order_status_data as $row): ?>
				<?php $status_id = $row[$this->flexi_cart_admin->db_column('order_status', 'id')]; ?>
				<tr>
					<td>
						<input type="hidden" name="update[<?php echo $status_id; ?>][id]" value="<?php echo $status_id; ?>"/>
						<input type="text" name="update[<?php echo $status_id; ?>][status]" class="form-control" value="<?php echo set_value('update['.$status_id.'][status]', $row[$this->flexi_cart_admin->db_column('order_status', 'status')]);?>"/>
					</td>
					<td class="text-center">
						<?php $cancelled = (bool)$row[$this->flexi_cart_admin->db_column('order_status', 'cancelled')]; ?>
						<input type="hidden" name="update[<?php echo $status_id; ?>][cancelled]" value="0"/>
						<input type="checkbox" name="update[<?php echo $status_id; ?>][cancelled]" value="1" <?php echo set_checkbox('update['.$status_id.'][cancelled]', '1', $cancelled); ?>/>
					</td>
					<td class="text-center">
						<?php $save_default = (bool)$row[$this->flexi_cart_admin->db_column('order_status', 'save_default')]; ?>
						<input type="hidden" name="update[<?php echo $status_id; ?>][save_default]" value="0"/>
						<input type="checkbox" name="update[<?php echo $status_id; ?>][save_default]" value="1" <?php echo set_checkbox('update['.$status_id.'][save_default]', '1', $save_default); ?>/>
					</td>
					<td class="text-center">
						<?php $resave_default = (bool)$row[$this->flexi_cart_admin->db_column('order_status', 'resave_default')]; ?>
						<input type="hidden" name="update[<?php echo $status_id; ?>][resave_default]" value="0"/>
						<input type="checkbox" name="update[<?php echo $status_id; ?>][resave_default]" value="1" <?php echo set_checkbox('update['.$status_id.'][resave_default]', '1', $resave_default); ?>/>
					</td>
					<td class="text-center">
						<input type="hidden" name="update[<?php echo $status_id; ?>][delete]" value="0"/>
						<input type="checkbox" name="update[<?php echo $status_id; ?>][delete]" value="1"/>
					</td>
				</tr>
			<?php endforeach ?>
			</tbody>
		</table>
		
		<input type="submit" name="update_order_status" value="Update Order Status" class="btn btn-success"/>
	<?php endif ?>			
<?php echo form_close();?>

<?php $this->load->view('admin/templates/footer'); ?>