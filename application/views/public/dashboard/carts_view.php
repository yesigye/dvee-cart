<?php $this->load->view('public/templates/header', array(
	'title' => 'Dashboard',
	'link' => 'account',
)) ?>

<?php $this->load->view('public/dashboard/dashboard_header', array('active' => 'carts')) ?>

<hr class="mt-0 mb-4">

<div class="lead mb-3">Saved Carts</div>

<?php echo form_open(current_url()); ?>
	<?php if (empty($saved_cart_data)): ?>
	<div class="my-4 text-muted">You have no saved carts</div>
	<?php else: ?>
	<table class="table">
		<thead>
			<tr>
				<th>Details</th>
				<th class="text-right">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($saved_cart_data as $row): ?>
				<tr>
					<?php $cart_data = unserialize($row['cart_data_array']) ?>
					<td>
						<b># <?php echo $row['cart_data_id'] ?>:</b>
						<?php echo $cart_data['summary']['total_items'] ?> items in the cart
						<div class="text-muted">
							Total:
							<?php echo $cart_data['settings']['currency']['symbol'].' '.$cart_data['summary']['total'] ?>
						</div>
						<div class="small text-muted">
							Saved on 
							<?php echo date('jS M Y @ H:i', strtotime($row[$this->flexi_cart->db_column('db_cart_data','date')])); ?>
						</div>
					</td>
					<td class="text-right">
						<div class="btn-group">
							<a href="<?php echo site_url('load_cart_data/'.$row[$this->flexi_cart->db_column('db_cart_data','id')]) ?>" class="btn btn-sm btn-primary">
								Load
							</a>
							<a href="<?php echo site_url('delete_cart_data/'.$row[$this->flexi_cart->db_column('db_cart_data','id')]) ?>" class="btn btn-sm btn-danger">
								Remove
							</a>
						</div>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>
<?php echo form_close(); ?>

</div>
</div>
</div>

<?php $this->load->view('public/templates/footer') ?>