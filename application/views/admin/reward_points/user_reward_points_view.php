<?php $this->load->view('admin/templates/header', array(
	'title' => 'Reward Points',
	'link' => 'reward_points',
	'breadcrumbs' => array(
		0 => array('name'=>'Reward Points','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/reward_points/reward_points_sub_header', array('active'=>'points')); ?>

<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>

<?php if (empty($user_data)): ?>
	<div class="alert alert-warning">
		There are no users available to view.
	</div>
<?php else: ?>
	<?php echo form_open(current_url()); ?>
		<table class="table table-flat table-striped">
			<thead>
				<tr>
					<th>User Name</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="The number of reward points that have been earnt by the user. Any cancelled or refunded items are not included in the total.">
							Total
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="The number of reward points that are pending activation. Once an ordered item has been 'Completed' (Shipped), the earnt points will be enabled after a set number of days.">
							Pending
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="The number of reward points that have been earnt by the user, which are active and can be converted to vouchers.">
							Active
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="The number of reward points that have expired before they were converted to a reward voucher.">
							Expired
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="The number of reward points that have been converted to reward vouchers by the user.">
							Converted
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="The number of reward points that have been cancelled due to an ordered item being cancelled or refunded.">
							Cancelled
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" <div data-toggle="tooltip" title="View the customers history of reward point earnings and conversions.">
							History
							<span class="fa fa-info-sign"></span>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($user_data as $row) { ?>
					<tr>
						<td>
							<img src="<?php echo base_url($row['avatar']) ?>" alt="" style="width:30px">
							<?php echo $row['username']; ?>
						</td>
						<td class="text-center">
							<?php echo $row['total_points']; ?>
						</td>
						<td class="text-center">
							<?php echo $row['total_points_pending']; ?>
						</td>
						<td class="text-center">
							<?php echo $row['total_points_active']; ?>
						</td>
						<td class="text-center">
							<?php echo $row['total_points_expired']; ?>
						</td>
						<td class="text-center">
							<?php echo $row['total_points_converted']; ?>
						</td>
						<td class="text-center">
							<?php echo $row['total_points_cancelled']; ?>
						</td>
						<td class="text-center">
							<a href="<?php echo site_url('admin/update_user/'.$row['user_id']) ?>" class="btn btn-info">
								View
							</a>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>				
	<?php echo form_close(); ?>
<?php endif ?>
	
<?php $this->load->view('admin/templates/footer'); ?>