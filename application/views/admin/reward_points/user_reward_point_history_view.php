<?php $this->load->view('admin/templates/header', array(
	'title' => 'Reward Points',
	'link' => 'reward_points',
	'breadcrumbs' => array(
		0 => array('name'=>'Reward Points','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/reward_points/reward_points_sub_header'); ?>

<div class="page-header">
	<h4 class="lead">Manage User Reward Points</h4>
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
	
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
		
		<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
		<?php } ?>
										
			<h1><?php echo $user_data['user_name'];?> : Earnt Reward Point History</h1>
			<p>
				<a href="<?php echo $base_url; ?>admin/user_reward_points">Manage Reward Points</a> |
				<a href="<?php echo $base_url; ?>admin/convert_reward_points/<?php echo $user_data['user_id'];?>">Convert Reward Points</a>
			</p>

			<table>
				<thead>
					<tr>
						<th class="spacer_100 tooltip_trigger"
							title="The order number that the reward points were earnt from.">
							Order Number
						</th>
						<th class="spacer_100 text-center tooltip_trigger"
							title="The date that the order was placed.">
							Date Ordered
						</th>
						<th class="tooltip_trigger"
							title="The specific item that the reward points were earnt from.">
							Item Ordered
						</th>
						<th class="spacer_100 text-center tooltip_trigger"
							title="The total reward points earnt from the item ordered.">
							Total Points
						</th>
						<th class="spacer_125 text-center tooltip_trigger"
							title="The number of reward points that are 'pending' and 'active'.">
							Pending / Active Points
						</th>
						<th class="spacer_125 text-center tooltip_trigger"
							title="The number of reward points that have been converted to vouchers and the number that have expired before being converted.">
							Converted / Expired Points
						</th>
					</tr>
				</thead>
			<?php if (! empty($points_awarded_data)) { ?>
				<tbody>
				<?php foreach ($points_awarded_data as $row) { ?>
					<tr>
						<td>
							<?php $order_number = $row[$this->flexi_cart_admin->db_column('reward_points', 'order_number')]; ?>
							<a href="<?php echo $base_url; ?>admin/order_details/<?php echo $order_number; ?>">
								<?php echo $order_number; ?>
							</a>
						</td>
						<td class="text-center">
							<?php echo date('jS M Y' ,strtotime($row[$this->flexi_cart_admin->db_column('reward_points', 'order_date')]));?>
						</td>
						<td>
							<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'description')]; ?>
						</td>
						<td class="text-center">
						<?php if ($row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_cancelled')] > 0) { ?>
							<span class="tooltip_trigger" title="Points cancelled due to returned items : <?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_cancelled')]; ?>">
								<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_total')]; ?> total
							</span>
						<?php 
							} else { 
								echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_total')].' total';
							} 
						?>
						</td>
						<td class="text-center">
							<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_pending')]; ?> pending,<br/>								
						<?php if ($row[$this->flexi_cart_admin->db_column('reward_points', 'activate_date')]) { ?>
							<span class="tooltip_trigger" title="Active Since : <?php echo date('jS M Y' ,strtotime($row[$this->flexi_cart_admin->db_column('reward_points', 'activate_date')])); ?>">
								<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_active')]; ?> active
							</span>
						<?php 
							} else { 
								echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_active')].' active';
							} 
						?>
						</td>
						<td class="text-center">
							<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_converted')]; ?> converted,<br/>
						<?php if ($row[$this->flexi_cart_admin->db_column('reward_points', 'activate_date')]) { ?>
							<span class="tooltip_trigger" title="Expire Date : <?php echo date('jS M Y' ,strtotime($row[$this->flexi_cart_admin->db_column('reward_points', 'expire_date')])); ?>">
								<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_expired')]; ?> expired
							</span>
						<?php 
							} else { 
								echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_active')].' active';
							} 
						?>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			<?php } else { ?>
				<tbody>
					<tr>
						<td colspan="6">
							There are no reward points available for this user to view.
						</td>
					</tr>
				</tbody>
			<?php } ?>
			</table>	
			
			<br/>
			<h1><?php echo $user_data['user_name'];?> : Converted Reward Point History</h1>
			<p>
				<a href="<?php echo $base_url; ?>admin/user_reward_points">Manage Reward Points</a> |
				<a href="<?php echo $base_url; ?>admin/convert_reward_points/<?php echo $user_data['user_id'];?>">Convert Reward Points</a>
			</p>

			<table>
				<thead>
					<tr>
						<th class="spacer_150 tooltip_trigger"
							title="The reward voucher code.">
							Voucher Code
						</th>
						<th class="spacer_100 tooltip_trigger"
							title="The order number that the reward points were earnt and converted from.">
							Order Number
						</th>
						<th class="tooltip_trigger"
							title="The specific item that the reward points were earnt and converted from.">
							Item Ordered
						</th>
						<th class="spacer_125 text-center tooltip_trigger"
							title="The number of reward points that were converted.">
							Points Converted
						</th>
						<th class="spacer_125 text-center tooltip_trigger"
							title="The date the reward points were converted.">
							Date Converted
						</th>
					</tr>
				</thead>
			<?php if (! empty($points_converted_data)) { ?>
				<tbody>
				<?php foreach ($points_converted_data as $voucher_data) { ?>
					<?php foreach ($voucher_data['reward_points'] as $points_row => $points_data) { ?>
					<tr <?php echo ($points_row == 0) ? 'style="border-top:3px double #666;"' : NULL;?>>
						<td>
						<?php if ($points_row == 0) { ?>
							<?php echo $voucher_data[$this->flexi_cart_admin->db_column('discounts', 'code')]; ?>
						<?php } else { ?>
							&nbsp;
						<?php } ?>
						</td>
						<td>
							<?php $order_number = $points_data[$this->flexi_cart_admin->db_column('reward_points', 'order_number')]; ?>
							<a href="<?php echo $base_url; ?>admin/order_details/<?php echo $order_number; ?>">
								<?php echo $order_number; ?>
							</a>
						</td>
						<td>
							<?php echo $points_data[$this->flexi_cart_admin->db_column('reward_points', 'description')]; ?>
						</td>
						<td class="text-center">
							<?php echo $points_data[$this->flexi_cart_admin->db_column('reward_points_converted', 'points')]; ?>
						</td>
						<td class="text-center">
							<?php echo date('jS M Y' ,strtotime($points_data[$this->flexi_cart_admin->db_column('reward_points_converted', 'date')])); ?>
						</td>
					</tr>
					<?php } ?>
				<?php } ?>
				</tbody>
			<?php } else { ?>
				<tbody>
					<tr>
						<td colspan="5">
							There are no reward point conversions available for this user to view.
						</td>
					</tr>
				</tbody>
			<?php } ?>
			</table>				

		</div>
	</div>
	
<?php $this->load->view('admin/templates/footer'); ?>