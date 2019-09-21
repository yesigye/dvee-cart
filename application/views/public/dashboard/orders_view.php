<?php $this->load->view('public/templates/header', array(
	'title' => 'Dashboard',
	'link' => 'account',
)) ?>

<?php $this->load->view('public/dashboard/dashboard_header', array('active' => 'orders')) ?>

<?php if (empty($order_data)): ?>
	<div class="my-4 text-muted">You have not placed any orders yet.</div>
<?php else: ?>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="">Order Number</th>
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
						<?php echo anchor('user_dashboard/order/'.$order_number, $order_number) ?>
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
	</div>			
<?php endif ?>

</div>
</div>
</div>

<?php $this->load->view('public/templates/footer') ?>