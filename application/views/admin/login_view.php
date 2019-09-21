
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $owner->name ?> Dashboard</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css') ?>" />
</head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-lg-5 center-block" style="margin:auto;float:initial;margin-top:2.5%">
                    <?php echo form_open(current_url()); ?>
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-sm-3 col-md-2">
                                        <img alt="Brand" src="<?= base_url($owner->logo) ?>" alt="" style="width:50px">
                                    </div>
                                    <div class="col-sm-9 col-md-10">
                                        <strong><?php echo $owner->name ?> </strong>
                                        <p class="text-muted">Login into dashboard</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Alerts -->
                            <?php if ($message): ?>
								<?php echo $message ?>
                            <?php elseif ($this->session->userdata('login_redirect')): ?>
                                <p class="bg-warning py-1 px-3">Your session expired.</p>
                            <?php endif ?>
                            <!-- End of alerts -->
                                
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="username" class="col-3 pr-0 pt-1">Username</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>" name="username" value="<?= set_value('username') ?>" required/>
                                        <?php if (form_error('username')): ?>
                                            <div class="invalid-feedback"><?php echo form_error('username') ?></div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-3 pr-0 pt-1">Password</label>
                                    <div class="col-9">
                                        <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" name="password" value="<?= set_value('password') ?>" required/>
                                        <?php if (form_error('password')): ?>
                                            <div class="invalid-feedback"><?php echo form_error('password') ?></div>
                                        <?php endif ?>
                                        <div class="text-right small">
                                            <a href="<?php echo site_url('forgot-password') ?>"><?php echo lang('form_forgot_password') ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group <?php echo form_error('remember') ? 'has-error' : '' ?>">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember" <?= set_value('remember') ? 'checked="checked"' : '' ?>>
                                        <label class="custom-control-label" for="customCheck1">Remeber me</label>
                                    </div>
                                </div> 

                                <button type="submit" name="login" value="1" class="btn btn-lg btn-block btn-primary">
									Login
                                </button>
                            </div>
                        <?php echo form_close() ?>
                    </div>
                    <div class="my-5 text-center text-muted">
                        <?php echo '&copy '.date('Y').' '.$owner->name ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>