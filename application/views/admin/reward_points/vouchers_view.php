<?php $this->load->view('admin/templates/header', array(
	'title' => 'Reward Vouchers',
	'link' => 'vouchers',
	'breadcrumbs' => array(
		0 => array('name'=>'Reward Points','link'=>'user_reward_points'),
		1 => array('name'=>'Reward Vouchers','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/reward_points/reward_points_sub_header', array('active'=>'vouchers')); ?>

<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>

<?php if (empty($voucher_data)): ?>
	<div class="lead text-muted">
		There are no vouchers available to view.
	</div>
<?php else: ?>
	<?php echo form_open(current_url());?>
		<table class="table table-flat table-striped">
			<thead>
				<tr>
					<th>
						<div data-toggle="tooltip" title="The code used to apply the reward voucher.">
							Voucher Code
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="The user that the voucher was created by.">
							User Name
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="Indicates whether the reward voucher has been used or not.">
							Availability
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="The currency value of the reward voucher.">
							Value
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="The expiry date the voucher must be used by.">
							Expire Date
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="If checked, the reward voucher will be set as 'active'.">
							Status
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($voucher_data as $row) {
					$voucher_id = $row[$this->flexi_cart_admin->db_column('discounts', 'id')];
				?>
				<tr>
					<td>
						<input type="hidden" name="update[<?php echo $voucher_id; ?>][id]" value="<?php echo $row[$this->flexi_cart_admin->db_column('discounts', 'id')]?>"/>
						<?php echo $row[$this->flexi_cart_admin->db_column('discounts', 'code')]; ?>
					</td>
					<td>
						<img src="<?php echo base_url($row['avatar']) ?>" alt="" style="width:25px">
						<?php echo anchor('admin/update_user/'.$row['id'], $row['username']); ?>
					</td>
					<td>
					<?php if ($row[$this->flexi_cart_admin->db_column('discounts', 'usage_limit')] > 0) { ?>
						Available
					<?php } else { ?>
						Used
					<?php } ?>
					</td>
					<td class="text-center">
						&pound;<?php echo $row[$this->flexi_cart_admin->db_column('discounts', 'value_discounted')]; ?>
					</td>
					<td>
						<?php echo date('jS M Y', strtotime($row[$this->flexi_cart_admin->db_column('discounts', 'expire_date')])); ?>
					</td>
					<td class="text-center">
						<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('discounts', 'status')]; ?>
						<input type="hidden" name="update[<?php echo $voucher_id; ?>][status]" value="0"/>
						<input type="checkbox" name="update[<?php echo $voucher_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$voucher_id.'][status]','1', $status); ?>/>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>				
		
		<input type="submit" name="update_vouchers" value="Update Vouchers" class="btn btn-primary"/>
	<?php echo form_close(); ?>						
<?php endif ?>

<?php $this->load->view('admin/templates/footer'); ?>