<?php $this->load->view('admin/templates/header', array(
	'title' => 'Orders',
	'link' => 'orders',
	'breadcrumbs' => array(
		0 => array('name'=>'Orders','link'=>FALSE),
	)
)); ?>

<div class="lead page-header b-0">Orders</div>

<?php if (! empty($message)): ?>
	<div id="message"><?= $message ?></div>
<?php endif ?>
			
<?php if (empty($order_data)): ?>
	<div class="alert alert-warning">There are no orders available to view.</div>
<?php else: ?>
	<table class="table table-flat table-striped">
		<thead>
			<tr>
				<th class="">Order Number</th>
				<th class="">Customer Name</th>
				<th class="text-center">Total Items</th>
				<th class="text-center">Total Value</th>
				<th class="text-center">Date</th>
				<th class="text-center">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($order_data as $row): $order_number = $row[$this->flexi_cart_admin->db_column('order_summary', 'order_number')]; ?>
			<tr>
				<td>
					<a href="<?php echo $base_url; ?>admin/order_details/<?php echo $order_number; ?>"><?php echo $order_number; ?></a>
				</td>
				<td>
					<?php echo $row['ord_demo_bill_name']; ?>
				</td>
				<td class="text-center">
					<?php echo number_format($row[$this->flexi_cart_admin->db_column('order_summary', 'total_items')]); ?>
				</td>
				<td class="text-center">
					<?php echo '&pound;'.$row[$this->flexi_cart_admin->db_column('order_summary', 'total')]; ?>
				</td>
				<td class="text-center">
					<?php echo date('jS M Y', strtotime($row[$this->flexi_cart_admin->db_column('order_summary', 'date')])); ?>
				</td>
				<td class="text-center">
					<?php echo $row[$this->flexi_cart_admin->db_column('order_status', 'status')]; ?>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>				
<?php endif ?>

<?php $this->load->view('admin/templates/footer'); ?>