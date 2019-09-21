<?php $this->load->view('public/templates/header', array(
	'title' => 'Dashboard',
	'link' => 'account',
)) ?>

<?php $this->load->view('public/dashboard/dashboard_header', array('active' => 'points')) ?>

<div class="row">
	<div class="col-md-9">
		<div class="card mb-3">
			<div class="card-header bg-dark text-white py-2">
				Reward Points Converted
				<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#modal-convert-voucher">Convert Points</button>
			</div>
			<?php if (empty($points_converted_data)): ?>
				<div class="card-body text-muted">
					There are no reward points conversions available.
				</div>
			<?php else: ?>
				<table class="table table-striped">
					<thead class="">
						<tr>
							<th>
								Code
							</th>
							<th>
								<abbr data-toggle="tooltip" title="The Order # that the reward points were earnt and converted from.">
									Order #
									
								</abbr>
							</th>
							<th>
								<abbr data-toggle="tooltip" title="The specific item that the reward points were earnt and converted from.">
									Item Ordered
									
								</abbr>
							</th>
							<th class="text-center">
								<abbr data-toggle="tooltip" title="The number of reward points that were converted.">
									Converted
									
								</abbr>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($points_converted_data as $voucher_data): ?>
							<?php foreach ($voucher_data['reward_points'] as $points_row => $points_data): ?>
								<tr>
									<td>
										<?php if ($points_row == 0): ?>
											<?php echo $voucher_data[$this->flexi_cart_admin->db_column('discounts', 'code')]; ?>
											<div class="text-muted small">
												<?php echo date('jS M Y' ,strtotime($points_data[$this->flexi_cart_admin->db_column('reward_points_converted', 'date')])); ?>
											</div>
										<?php else: ?>
											&nbsp;
										<?php endif ?>
									</td>
									<td>
										<?php $order_number = $points_data[$this->flexi_cart_admin->db_column('reward_points', 'order_number')]; ?>
										<a href="<?php echo site_url('user_dashboard/order/'.$order_number) ?>">
											<?php echo $order_number; ?>
										</a>
									</td>
									<td>
										<?php echo $points_data[$this->flexi_cart_admin->db_column('reward_points', 'description')]; ?>
									</td>
									<td class="text-center">
										<?php echo $points_data[$this->flexi_cart_admin->db_column('reward_points_converted', 'points')]; ?>
									</td>
								</tr>
							<?php endforeach ?>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<div class="card">
			<div class="card-header bg-dark text-white">
				Reward Points History
			</div>
			<?php if (empty($points_awarded_data)): ?>
			<div class="card-body text-muted">
				There are no reward points available.
			</div>
			<?php else: ?>
			<div style="height:500px;overflow:auto;">
				<table class="table table-striped">
					<thead class="">
						<tr>
							<th>
								<abbr data-toggle="tooltip" title="The Order number that the reward points were earnt from.">
									Order #
								</abbr>
							</th>
							<th class="text-right">
								<abbr data-toggle="tooltip" title="The total reward points earnt from the item ordered.">
									Total
								</abbr>
							</th>
							<th class="text-right text-muted">
								<abbr data-toggle="tooltip" title="The number of reward points that are 'pending'.">
									Pending
								</abbr>
							</th>
							<th class="text-right text-success">
								<abbr data-toggle="tooltip" title="The number of reward points that are 'active'.">
									Active
								</abbr>
							</th>
							<th class="text-right text-info">
								<abbr data-toggle="tooltip" title="The number of reward points that have been converted to vouchers.">
									Converted
								</abbr>
							</th>
							<th class="text-right text-danger">
								<abbr data-toggle="tooltip" title="The number of reward points that have expired before being converted.">
									Expired
								</abbr>
							</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($points_awarded_data as $row) { ?>
						<tr>
							<td>
								<?php $order_number = $row[$this->flexi_cart_admin->db_column('reward_points', 'order_number')]; ?>
								<a href="<?php echo site_url('user_dashboard/order/'.$order_number) ?>">
									<?php echo $order_number; ?>
								</a>
								<div class="small text-muted">
									<?php echo date('jS M Y' ,strtotime($row[$this->flexi_cart_admin->db_column('reward_points', 'order_date')]));?>
								</div>
							</td>
							<td class="text-right">
								<?php if ($row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_cancelled')] > 0): ?>
								<span class="tooltip_trigger" title="Points cancelled due to returned items : <?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_cancelled')]; ?>">
									<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_total')]; ?>
								</span>
								<?php else: ?>
									<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_total')]; ?>
								<?php endif ?>
							</td>
							<td class="text-right text-muted">
								<span class="tooltip_trigger" title="Activates On : <?php echo date('jS M Y' ,strtotime($row[$this->flexi_cart_admin->db_column('reward_points', 'activate_date')])); ?>">
									<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_pending')]; ?>
								</span>
							</td>
							<td class="text-right text-success">
								<?php if ($row[$this->flexi_cart_admin->db_column('reward_points', 'activate_date')]): ?>
									<span class="tooltip_trigger" title="Active Since : <?php echo date('jS M Y' ,strtotime($row[$this->flexi_cart_admin->db_column('reward_points', 'activate_date')])); ?>">
										<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_active')]; ?>
									</span>
								<?php else: ?>
									<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_active')]; ?>
								<?php endif ?>
							</td>
							<td class="text-right text-info">
								<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_converted')]; ?>
							</td>
							<td class="text-right text-danger">
								<?php if ($row[$this->flexi_cart_admin->db_column('reward_points', 'activate_date')]): ?>
									<span class="tooltip_trigger" title="Expire Date : <?php echo date('jS M Y' ,strtotime($row[$this->flexi_cart_admin->db_column('reward_points', 'expire_date')])); ?>">
										<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_expired')]; ?>
									</span>
								<?php else: ?>
									<?php echo $row[$this->flexi_cart_admin->db_column('reward_points', 'row_points_active')]; ?>
								<?php endif ?>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<?php endif ?>
		</div>
	</div>
	<div class="col-md-3">
		<div class="card">
			<div class="card-header bg-dark text-white">
				Summary
			</div>
			<?php echo form_open(current_url()); ?>
				<table class="table table-striped" style="margin:0;font-size:100%">
					<tbody>
						<tr>
							<th>
								Total
								<span class="fa fa-info-sign text-info" data-toggle="tooltip" title="The number of reward points that have been earnt by the user. Any cancelled or refunded items are not included in the total."></span>
							</th>
							<td class="text-right">
								<?php echo $reward_data['total_points']; ?>
							</td>
						</tr>
						<tr>
							<th>
								Pending
								<span class="fa fa-info-sign text-info" data-toggle="tooltip" title="The number of reward points that are pending activation. Once an ordered item has been 'Completed' (Shipped), the earnt points will be enabled after a set number of days."></span>
							</th>
							<td class="text-right">
								<?php echo $reward_data['total_points_pending']; ?>
							</td>
						</tr>
						<tr>
							<th>
								Active
								<span class="fa fa-info-sign text-info" data-toggle="tooltip"  title="The number of reward points that have been earnt by the user, which are active and can be converted to vouchers."></span>
							</th>
							<td class="text-right">
								<?php echo $reward_data['total_points_active']; ?>
							</td>
						</tr>
						<tr>
							<th>
								Expired
								<span class="fa fa-info-sign text-info" data-toggle="tooltip" title="The number of reward points that have expired before they were converted to a reward voucher."></span>
							</th>
							<td class="text-right">
								<?php echo $reward_data['total_points_expired']; ?>
							</td>
						</tr>
						<tr>
							<th>
								Converted
								<span class="fa fa-info-sign text-info" data-toggle="tooltip" title="The number of reward points that have been converted to reward vouchers by the user."></span>
							</th>
							<td class="text-right">
								<?php echo $reward_data['total_points_converted']; ?>
							</td>
						</tr>
						<tr>
							<th>
								Cancelled
								<span class="fa fa-info-sign text-info" data-toggle="tooltip" title="The number of reward points that have been cancelled due to an ordered item being cancelled or refunded."></span>
							</th>
							<td class="text-right">
								<?php echo $reward_data['total_points_cancelled']; ?>
							</td>
						</tr>
					</tbody>
				</table>				
			<?php echo form_close(); ?>
		</div>
	</div>
</div>


<div class="modal fade" id="modal-convert-voucher">
	<div class="modal-dialog">
		<div class="modal-content border-0">
			<div class="modal-header bg-primary text-white">
				Convert Points to Vouchers
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php if ($conversion_tiers): ?>
					<?php echo form_open(current_url()); ?>
						<div class="form-group text-muted">
							<strong>
								<?php echo $reward_data[$this->flexi_cart_admin->db_column('reward_points','total_points_active')]; ?>
							</strong>
							total active reward points.
						</div>
						<div class="input-group">
							<select name="reward_points" class="form-control">
								<?php foreach($conversion_tiers as $value) { ?>
									<option value="<?php echo $value; ?>" <?php echo set_select('reward_points', $value); ?>>
										<?php echo $value; ?>
									</option>
								<?php } ?>
							</select>
							<div class="input-group-append">
								<input type="submit" name="convert_reward_points" value="Convert" class="btn btn-primary"/>
							</div>
						</div>
						<div class="text-muted mt-2">
							<div class="mb-1">
								Set the number of points that are to be converted to a reward voucher.
							</div>
							<div class="mb-1">
								<?php foreach($conversion_tiers as $value): ?>
								<div>
									<b><?php echo $value; ?></b> point voucher worth <b>&pound;<?php echo $this->flexi_cart_admin->calculate_reward_point_value($value); ?></b>
								</div>
								<?php endforeach ?>
							</div>
							Maximum available for this user is <b><?php echo $max_conversion_points; ?></b> points, worth
							<b>&pound;<?php echo $this->flexi_cart_admin->calculate_reward_point_value($max_conversion_points); ?></b>
						</div>
					<?php echo form_close(); ?>
				<?php else: ?>
					<div class="text-muted">This user does not have enough active reward points to convert to a voucher.</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>


</div>
</div>
</div>

<?php $this->load->view('public/templates/footer') ?>