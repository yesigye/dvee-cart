<?php $this->load->view('admin/templates/header', array(
	'title' => 'Users',
	'link' => 'users',
	'breadcrumbs' => array(
		0 => array('name'=>'Users','link'=>'users'),
		1 => array('name'=>'Add a User','link'=>FALSE),
	)
)); ?>

<div class="lead page-header b-0">Insert New User</div>

<?php if (validation_errors()): ?>
	<div class="alert alert-danger">
		Correct the errors in the form and try again
	</div>
<?php else: ?>
	<?php if (! empty($message)): ?>
		<div id="message"> <?=$message ?> </div>
	<?php endif ?>
<?php endif ?>

<?php echo form_open_multipart(current_url()); ?>
<div class="row">
	<div class="col-xs-12 col-sm-4 col-md-3">
		<div class="form-group <?= form_error('userfile') ? 'has-error' : '' ?>">
			<?= form_hidden('crop_x', '') ?>
			<?= form_hidden('crop_y', '') ?>
			<?= form_hidden('crop_width', '') ?>
			<?= form_hidden('crop_height', '') ?>
			<label class="control-label" for="userfile">Profile Photo</label>
			<div class="panel panel-default">
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail text-warning">
						<div style="margin:3rem 0">No image selected</div>
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail">
					</div>
					<div class="btn-group btn-block">
						<div class="btn btn-success btn-file">
							<span class="fileinput-new">Select image</span>
							<span class="fileinput-exists">Change</span>
							<input type="file" name="userfile">
						</div>
						<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
					</div>
				</div>
			</div>
			<div class="text-danger"><?= form_error('userfile') ? form_error('userfile') : '&nbsp' ?></div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-8 col-md-9">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group <?= form_error('first_name') ? 'has-error' : '' ?>">
					<label class="control-label" for="first_name">First Name</label>
					<input class="form-control" type="text" name="first_name" value="<?= set_value('first_name') ?>" />
					<div class="text-danger"><?= form_error('first_name') ? form_error('first_name') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6">
				<div class="form-group <?= form_error('last_name') ? 'has-error' : '' ?>">
					<label class="control-label" for="last_name">Last Name</label>
					<input class="form-control" type="text" name="last_name" value="<?= set_value('last_name') ?>" />
					<div class="text-danger"><?= form_error('last_name') ? form_error('last_name') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('username') ? 'has-error' : '' ?>">
					<label class="control-label" for="username">Username</label>
					<input class="form-control" type="text" name="username" value="<?= set_value('username') ?>" />
					<div class="text-danger"><?= form_error('username') ? form_error('username') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('password') ? 'has-error' : '' ?>">
					<label class="control-label" for="password">Password</label>
					<input class="form-control" type="password" name="password" value="<?= set_value('password') ?>" />
					<div class="text-danger"><?= form_error('password') ? form_error('password') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('password_confirm') ? 'has-error' : '' ?>">
					<label class="control-label" for="password_confirm">confirm Password</label>
					<input class="form-control" type="password" name="password_confirm" value="<?= set_value('password_confirm') ?>" />
					<div class="text-danger"><?= form_error('password_confirm') ? form_error('password_confirm') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('email') ? 'has-error' : '' ?>">
					<label class="control-label" for="email">Email</label>
					<input class="form-control" type="email" name="email" value="<?= set_value('email') ?>" />
					<div class="text-danger"><?= form_error('email') ? form_error('email') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('address') ? 'has-error' : '' ?>">
					<label class="control-label" for="address">Address</label>
					<input class="form-control" type="text" name="address" value="<?= set_value('address') ?>" />
					<div class="text-danger"><?= form_error('address') ? form_error('address') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-4">
				<div class="form-group <?= form_error('phone') ? 'has-error' : '' ?>">
					<label class="control-label" for="phone">Phone</label>
					<input class="form-control" type="phone" name="phone" value="<?= set_value('phone') ?>" />
					<div class="text-danger"><?= form_error('phone') ? form_error('phone') : '&nbsp' ?></div>
				</div>
			</div>
		</div>
	</div>
</div>

<input type="submit" name="create_user" value="Add User" class="btn btn-primary" />

<?php echo form_close();?>


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

<?php $this->load->view('admin/templates/footer') ?>