<?php $this->load->view('admin/templates/header', array(
	'title' => 'Admin Profile',
	'link' => 'admin',
	'sub_link' => 'profile',
	'breadcrumbs' => array(
		1 => array('name'=>'Profile','link'=>FALSE)
	)
)); ?>

<div class="lead page-header">
    <span class="fa fa-user" style="margin-right:10px"></span>
    Edit profile
</div>

<?php if (validation_errors()): ?>
	<div class="alert alert-danger animated fadeInDown" id="message">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<?php echo validation_errors(); ?>
	</div>
<?php endif ?>

<?php echo form_open_multipart(uri_string()); ?>
	<div class="row">
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="form-group <?= form_error('userfile') ? 'has-error' : '' ?>">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <label class="panel-title control-label" for="userfile">
                        	LOGO
                        </label>
                    </div>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail text-warning">
                            <img src="<?= base_url($user->logo) ?>">
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
            </div>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-9">
            <div class="row">
	            <div class="col-md-4">
	                <div class="form-group <?= form_error('username') ? 'has-error' : '' ?>">
	                    <label class="control-label" for="name">Username <?= form_error('username') ? '('.form_error('username').')' : '' ?></label>
	                    <input class="form-control" type="text" name="username" value="<?= set_value('username') ? set_value('username') : $user->username ?>">
	                </div>
                </div>
	            <div class="col-md-4">
	                <div class="form-group <?= form_error('password') ? 'has-error' : '' ?>">
	                    <label class="control-label" for="name">Password <?= form_error('password') ? '('.form_error('password').')' : '' ?></label>
	                    <input class="form-control" type="text" name="password" value="<?= set_value('password') ? set_value('password') : '' ?>">
	                </div>
                </div>
	            <div class="col-md-4">
	                <div class="form-group <?= form_error('password_confirm') ? 'has-error' : '' ?>">
	                    <label class="control-label" for="name">Repeat password <?= form_error('password_confirm') ? '('.form_error('password_confirm').')' : '' ?></label>
	                    <input class="form-control" type="text" name="password_confirm" value="<?= set_value('password_confirm') ? set_value('password_confirm') : '' ?>">
	                </div>
                </div>
	            <div class="col-md-4">
	                <div class="form-group <?= form_error('email') ? 'has-error' : '' ?>">
	                    <label class="control-label" for="name">Email address <?= form_error('email') ? '('.form_error('email').')' : '' ?></label>
	                    <input class="form-control" type="text" name="email" value="<?= set_value('email') ? set_value('email') : $user->email ?>">
	                </div>
	            </div>
                <div class="col-md-8">
                    <div class="form-group <?= form_error('company_name') ? 'has-error' : '' ?>">
                        <label class="control-label" for="company_name">Company name <?= form_error('company_name') ? '(required)' : '' ?></label>
                        <input class="form-control" type="text" name="company_name" value="<?= set_value('company_name') ? set_value('company_name') : $user->name ?>">
                    </div>
                </div>
	            <div class="col-md-4">
	                <div class="form-group <?= form_error('company_address') ? 'has-error' : '' ?>">
	                    <label class="control-label" for="company_address">Physical address <?= form_error('company_address') ? '(required)' : '' ?></label>
	                    <input class="form-control" type="text" name="company_address" value="<?= set_value('company_address') ? set_value('company_address') : $user->address ?>">
	                </div>
	            </div>
	            <div class="col-md-4">
	                <div class="form-group <?= form_error('company_p_o_box') ? 'has-error' : '' ?>">
	                    <label class="control-label" for="company_p_o_box">Postal address <?= form_error('company_p_o_box') ? '(required)' : '' ?></label>
	                    <input class="form-control" type="text" name="company_p_o_box" value="<?= set_value('company_p_o_box') ? set_value('company_p_o_box') : $user->postal ?>">
	                </div>
	            </div>
	            <div class="col-md-4">
	                <div class="form-group <?= form_error('company_phone') ? 'has-error' : '' ?>">
	                    <label class="control-label" for="company_phone">Company phone <?= form_error('company_phone') ? '(required)' : '' ?></label>
	                    <input class="form-control" type="text" name="company_phone" value="<?= set_value('company_phone') ? set_value('company_phone') : $user->phone ?>">
	                </div>
	            </div>
            </div>
        </div>
    </div>

    <hr>

	<input type="button" class="btn btn-lg btn-primary" value="UPDATE PROFILE" data-toggle="modal" data-target="#enter-password" />


    <div class="modal fade" id="enter-password">
        <div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">
						Enter your current password
					</h4>
				</div>
				<div class="modal-body">
                    <input class="form-control" type="password" name="old_password" value="">
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-lg btn-block btn-primary" name="edit_user" value="Continue" />
				</div>
			</div>
		</div>
    </div>

    <?php if ( validation_errors() AND form_error('old_password') ): ?>
    	<script type="text/javascript">
    	$('#enter-password').modal('show')
    	</script>
    <?php endif ?>
<?php echo form_close() ?>

<?php $this->load->view('admin/templates/footer') ?>