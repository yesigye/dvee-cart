<?php $this->load->view('public/templates/header', array(
	'title' => 'Profile',
	'link' => 'account',
	'sub_link' => 'profile',
	'breadcrumbs' => array(
		0 => array('name'=>'Dashboard','link'=>'user_dashboard'),
		1 => array('name'=>'Profile','link'=>'profile'),
		2 => array('name'=>'Change Password','link'=>FALSE)
	)
)); ?>

<?php $this->load->view('public/dashboard/dashboard_header', array('active' => 'profile')) ?>

<?php echo form_open(current_url()); ?>

<div class="container">
	<div class="mb-4">
		<h4>Change your password</h4>
		Enter your new password to change your old password, If you have forgotten your password,
		the go to the <?php echo anchor('forgot_password', 'Forgot Password Page') ?>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6">
			<div class="form-group <?= form_error('password') ? 'has-error' : '' ?>">
				<label class="control-label" for="password">New Password</label>
				<input class="form-control" type="password" name="password" value="<?= set_value('password') ?>" />
				<div class="text-danger"><?= form_error('password') ? form_error('password') : '&nbsp' ?></div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6">
			<div class="form-group <?= form_error('password_confirm') ? 'has-error' : '' ?>">
				<label class="control-label" for="password_confirm">confirm  New Password</label>
				<input class="form-control" type="password" name="password_confirm" value="<?= set_value('password_confirm') ?>" />
				<div class="text-danger"><?= form_error('password_confirm') ? form_error('password_confirm') : '&nbsp' ?></div>
			</div>
		</div>
	</div>


	<input type="button" class="btn btn-primary mt-3" value="Update Password" data-toggle="modal" data-target="#confirm-alert-modal"/>
</div>

</div>
</div>
</div>

<div class="modal fade" id="confirm-alert-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				
				<h4 class="modal-title">Enter your old password</h4>
			</div>
			<div class="modal-body">
				<div class="form-group <?= form_error('old_password') ? 'has-error' : '' ?>">
					<input class="form-control" type="password" name="old_password" value="<?= set_value('old_password') ?>" />
					<div class="text-danger"><?= form_error('old_password') ? form_error('old_password') : '&nbsp' ?></div>
				</div>
				<input type="submit" class="btn btn-block btn-primary" name="change_password" value="Submit" />
			</div>
		</div>
	</div>
</div>

<?php echo form_close();?>


<?php $this->load->view('public/templates/footer') ?>