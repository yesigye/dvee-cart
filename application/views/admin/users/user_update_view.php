<?php $this->load->view('admin/templates/header', array(
	'title' => 'Users',
	'link' => 'users',
	'breadcrumbs' => array(
		0 => array('name'=>'Users','link'=>'users'),
		1 => array('name'=>$person ? $person->username : 'Not found','link'=>FALSE),
	)
)); ?>

<?php if (validation_errors()): ?>
	<div class="alert alert-danger">
		Correct the errors in the form and try again
	</div>
<?php else: ?>
	<?php if (! empty($message)): ?>
		<div id="message"> <?=$message ?> </div>
	<?php endif ?>
<?php endif; ?>

<div class="lead b-0 text-right">
	<img src="<?php echo base_url($person->avatar) ?>" alt="" style="width:20px" class="rounded">
	<?php echo $person->username ?>
</div>


<?php if (! $person): ?>
<div class="my-4 text-muted">This user has been removed</div>
<?php else: ?>

<ul class="nav nav-tabs my-1" role="tablist">
    <li role="presentation" class="nav-item">
        <a class="nav-link active" href="#details" aria-controls="details" role="tab" data-toggle="tab">User Details</a>
    </li>
    <li role="presentation" class="nav-item">
        <a class="nav-link" href="#points" aria-controls="points" role="tab" data-toggle="tab">Reward Points</a>
    </li>
    <li role="presentation" class="nav-item">
        <a class="nav-link" href="#vouchers" aria-controls="vouchers" role="tab" data-toggle="tab">Reward Vouchers</a>
    </li>
</ul>

<div class="tab-content pt-3">
	<div role="tab" class="tab-pane active" id="details">
		<p class="lead mb-4">Update user profile information</p>
		
		<?php echo form_open_multipart(current_url()) ?>
			<?php echo form_hidden('id', $person->id) ?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-3">
					<div class="form-group">
						<?= form_hidden('crop_x', '') ?>
						<?= form_hidden('crop_y', '') ?>
						<?= form_hidden('crop_width', '') ?>
						<?= form_hidden('crop_height', '') ?>
						<div class="card">
							<div class="card-header">
								<label class="card-title m-0" for="userfile">Profile Photo</label>
							</div>
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-new thumbnail text-warning">
									<img src="<?= base_url($person->avatar) ?>">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail">
								</div>
								<div class="btn-group btn-block">
									<div class="btn bg-transparent float btn-file">
										<span class="fileinput-new">Select image</span>
										<span class="fileinput-exists">Change</span>
										<input type="file" name="userfile">
									</div>
									<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-9">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group <?php echo form_error('first_name') ? 'has-error' : '' ?>">
								<label class="control-label" for="first_name">First Name</label>
								<input class="form-control" type="text" name="first_name" value="<?= set_value('first_name') ? set_value('first_name') : $person->first_name ?>" />
								<div class="text-danger"><?php echo form_error('first_name') ? form_error('first_name') : '&nbsp' ?></div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<div class="form-group <?php echo form_error('last_name') ? 'has-error' : '' ?>">
								<label class="control-label" for="last_name">Last Name</label>
								<input class="form-control" type="text" name="last_name" value="<?= set_value('last_name') ? set_value('last_name') : $person->last_name ?>" />
								<div class="text-danger"><?php echo form_error('last_name') ? form_error('last_name') : '&nbsp' ?></div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group <?php echo form_error('email') ? 'has-error' : '' ?>">
								<label class="control-label" for="email">Email</label>
								<input class="form-control" type="email" name="email" value="<?= set_value('email') ? set_value('email') : $person->email ?>" />
								<div class="text-danger"><?php echo form_error('email') ? form_error('email') : '&nbsp' ?></div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group <?php echo form_error('phone') ? 'has-error' : '' ?>">
								<label class="control-label" for="phone">Phone</label>
								<input class="form-control" type="phone" name="phone" value="<?= set_value('phone') ? set_value('phone') : $person->phone ?>" />
								<div class="text-danger"><?php echo form_error('phone') ? form_error('phone') : '&nbsp' ?></div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group <?php echo form_error('postal') ? 'has-error' : '' ?>">
								<label class="control-label" for="postal">Postal Address</label>
								<input class="form-control" type="text" name="postal" value="<?= set_value('postal') ? set_value('postal') : $person->postal ?>" />
								<div class="text-danger"><?php echo form_error('postal') ? form_error('postal') : '&nbsp' ?></div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group <?php echo form_error('address') ? 'has-error' : '' ?>">
								<label class="control-label" for="address">Line Address</label>
								<input class="form-control" type="text" name="address" value="<?= set_value('address') ? set_value('address') : $person->address ?>" />
								<div class="text-danger"><?php echo form_error('address') ? form_error('address') : '&nbsp' ?></div>
							</div>
						</div>
					</div>

					<div class="alert bg-light pb-0">
						<b>Change login details</b>
						<p class="small">The user will not be able to login unless informed of the changes.</p>
						
						<div class="row">
							<div class="col-xs-12 col-sm-4 col-md-4">
								<div class="form-group <?php echo form_error('username') ? 'has-error' : '' ?>">
									<label class="control-label" for="username">Username</label>
									<input class="form-control" type="text" name="username" value="<?= set_value('username') ? set_value('username') : $person->username ?>" />
									<div class="text-danger"><?php echo form_error('username') ? form_error('username') : '&nbsp' ?></div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4">
								<div class="form-group <?php echo form_error('password') ? 'has-error' : '' ?>">
									<label class="control-label" for="password1">Password</label>
									<input class="form-control" type="password" name="password" value="<?= set_value('password') ?>" />
									<div class="text-danger"><?php echo form_error('password') ? form_error('password') : '&nbsp' ?></div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4">
								<div class="form-group <?php echo form_error('password_confirm') ? 'has-error' : '' ?>">
									<label class="control-label" for="password_confirm">confirm Password</label>
									<input class="form-control" type="password" name="password_confirm" value="<?= set_value('password_confirm') ?>" />
									<div class="text-danger"><?php echo form_error('password_confirm') ? form_error('password_confirm') : '&nbsp' ?></div>
								</div>
							</div>
						</div>
					</div>
					<input type="submit" name="edit_user" value="Update User Profile" class="btn btn-primary mt-2" />
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
	
	<div role="tab" class="tab-pane" id="points">
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
										Voucher Code
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
											Points&nbspConverted
											
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
												<a href="<?php echo site_url('admin/order_details/'.$order_number) ?>">
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
										<a href="<?php echo site_url('admin/order_details/'.$order_number) ?>">
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
	</div>

	<div role="tab" class="tab-pane" id="vouchers">
		<?php if (empty($voucher_data_array)): ?>
			<div class="my-4 text-muted">This user currently has no vouchers</div>
		<?php else: ?>
			<?php echo form_open(current_url()); ?>
				<table class="table table-striped">
					<thead class="">
						<tr>
							<th> 
								<abbr data-toggle="tooltip" title="The code used to apply the reward voucher.">
									Voucher Code
								</abbr>
							</th>
							<th class="text-center"> 
								<abbr data-toggle="tooltip" title="Indicates whether the reward voucher has been used or not.">
									Status
								</abbr>
							</th>
							<th class="text-center"> 
								<abbr data-toggle="tooltip" title="The currency value of the reward voucher.">
									Value
								</abbr>
							</th>
							<th class="text-center"> 
								<abbr data-toggle="tooltip" title="The expiry date the voucher must be used by.">
									Expire Date
								</abbr>
							</th>
							<th class="text-center"> 
								<abbr data-toggle="tooltip" title="If checked, the reward voucher will be set as 'active'.">
									Active
								</abbr>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach ($voucher_data_array as $row) {
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
								<label for="check_active" class="d-inline-block m-0 custom-control custom-switch">
									<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('discounts', 'status')]; ?>
									<input type="hidden" name="update[<?php echo $voucher_id; ?>][status]" value="0"/>
									<input class="custom-control-input" type="checkbox" id="check_active" name="update[<?php echo $voucher_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$voucher_id.'][status]','1', $status); ?>/>
									<div class="custom-control-label small">&nbsp</div>
								</label>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>				
				
				<div class="my-4 text-right">
					<input type="submit" name="update_vouchers" value="Update Vouchers" class="btn btn-success"/>
				</div>
			<?php echo form_close(); ?>
		<?php endif ?>
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

<script type="text/javascript" src="<?= base_url('assets/js/cropper.min.js') ?>"></script>
<script>
	$(document).ready(function() {
		$('.fileinput').on('change.bs.fileinput', function (e) {
			$('.fileinput-preview img').cropper({
				aspectRatio: 1 / 1,
				crop: function(e) {
					$('input[name="crop_width"]').val(e.width);
					$('input[name="crop_height"]').val(e.height);
					$('input[name="crop_x"]').val(e.x);
					$('input[name="crop_y"]').val(e.y);
				}
			});
		})
	});
</script>
<?php endif ?>

<?php $this->load->view('admin/templates/footer') ?>