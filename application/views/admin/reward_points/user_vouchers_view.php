<?php $this->load->view('admin/templates/header', array(
	'title' => 'Reward Vouchers',
	'link' => 'vouchers',
	'breadcrumbs' => array(
		0 => array('name'=>'Reward Points','link'=>'user_reward_points'),
		1 => array('name'=>'Reward Vouchers','link'=>'vouchers'),
		2 => array('name'=>$user_data['user_name'].' : Reward Vouchers','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/reward_points/reward_points_sub_header'); ?>

<div class="page-header">
	<h4 class="lead"><?php echo $user_data['user_name'];?> : Reward Vouchers</h4>
	<p>Users can earn reward points when they purchase items. When they earn enough points, they can be converted to a voucher worth a monetary value.</p>
	<p>The voucher is stored as a code in the database that when entered on their next purchase, will deduct the vouchers value from their cart total.</p>
	<p>The conversion and monetary value of reward points and vouchers can all be set via the cart configuration.</p>
</div>

<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>

<?php if (empty($voucher_data)): ?>
	<div class="alert alert-warning">
		There are no vouchers available to view for this user.
	</div>
<?php else: ?>
	<p class="text-right">
		<?php echo anchor('admin/user_reward_point_history/'.$user_data['user_id'], 'View Reward Point History', 'class="btn btn-info"') ?>
		<?php echo anchor('admin/convert_reward_points/'.$user_data['user_id'], 'Convert Reward Points', 'class="btn btn-success"') ?>
	</p>
	<?php echo form_open(current_url());?>
		<table>
			<thead>
				<tr>
					<th class="tooltip_trigger"
						title="The code used to apply the reward voucher.">
						Voucher Code
					</th>
					<th class="spacer_100 text-center tooltip_trigger"
						title="Indicates whether the reward voucher has been used or not.">
						Availability
					</th>
					<th class="spacer_100 text-center tooltip_trigger"
						title="The currency value of the reward voucher.">
						Value
					</th>
					<th class="spacer_100 text-center tooltip_trigger"
						title="The expiry date the voucher must be used by.">
						Expire Date
					</th>
					<th class="spacer_100 text-center tooltip_trigger" 
						title="If checked, the reward voucher will be set as 'active'.">
						Status
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
					<td class="text-center">
					<?php if ($row[$this->flexi_cart_admin->db_column('discounts', 'usage_limit')] > 0) { ?>
						Available
					<?php } else { ?>
						Used
					<?php } ?>
					</td>
					<td class="text-center">
						&pound;<?php echo $row[$this->flexi_cart_admin->db_column('discounts', 'value_discounted')]; ?>
					</td>
					<td class="text-center">
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
			<tfoot>
				<tr>
					<td colspan="5">
						<input type="submit" name="update_vouchers" value="Update Vouchers" class="link_button large"/>
					</td>
				</tr>
			</tfoot>
		</table>				
	<?php echo form_close(); ?>
<?php endif ?>

<?php $this->load->view('admin/templates/footer'); ?>