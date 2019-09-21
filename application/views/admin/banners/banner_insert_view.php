<?php $this->load->view('admin/templates/header', array(
	'title' => 'Insert Banner',
	'link' => 'extras',
	'sub_link' => 'banners',
	'breadcrumbs' => array(
		0 => array('name'=>'Banners','link'=>'banners'),
		1 => array('name'=>'Insert a new banner','link'=>FALSE)
	)
)); ?>

<div class="lead page-header b-0">Insert New Banner</div>

<?php if (validation_errors()): ?>
	<div class="alert alert-danger">
		Correct the errors in the form and try again
	</div>
<?php else: ?>
	<?php if (! empty($message)): ?>
		<div id="message"> <?=$message ?> </div>
	<?php endif ?>
<?php endif ?>

<?php echo form_open_multipart(current_url()) ?>
	<div class="row">
		<div class="col-md-8">
			<div class="panel <?php echo form_error('userfile') ? 'panel-danger' : 'panel-default' ?>">
				<div class="panel-heading">
					<div class="panel-title">Banner Type</div>
				</div>
				<div class="panel-body">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Image</a></li>
						<li role="presentation">
							<a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
								HTML <sapn class="text-muted">(overrides Image)</sapn>
							</a>
						</li>
					</ul>
					<div class="tab-content" style="margin-top:20px">
						<div role="tabpanel" class="tab-pane active" id="home">
							<div class="panel">
								<div class="fileinput fileinput-item-thumb fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail text-muted">
										<p class="text-muted" style="margin: 40px 0">NO IMAGE SELECTED</p>
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail">
									</div>
									<div class="btn-group btn-block">
										<div class="btn btn-sm btn-info btn-file">
											<span class="fileinput-new">Select</span>
											<span class="fileinput-exists">Change</span>
											<input type="file" name="userfile">
										</div>
										<a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="caption">Image Caption</label>
								<input type="text" class="form-control" name="caption" value="<?php echo set_value('caption') ? set_value('caption') : '' ?>" />
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="profile">
							<label for="html_text" class="control-label">HTML Text</label>
							<textarea class="form-control" name="html_text" rows="8"><?php echo set_value('html_text') ? set_value('html_text') : '' ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group <?php echo form_error('title') ? 'has-error' : '' ?>">
				<label for="title" class="control-label">Title</label>
				<input class="form-control" type="text" name="title" value="<?php echo set_value('title') ? set_value('title') : '' ?>" />
				<div class="text-danger"><?php echo form_error('title') ?></div>
			</div>
			<div class="form-group">
				<label for="url" class="control-label">Url link</label>
				<input class="form-control" type="text" name="url" value="<?php echo set_value('url') ? set_value('url') : '' ?>" />
			</div>
			<div class="form-group <?php echo form_error('start_date') ? 'has-error' : '' ?>">
				<label for="start_date" class="control-label">Start date</label>
				<input type="text" class="form-control" name="start_date" value="<?php echo (set_value('start_date')) ? set_value('start_date') : '' ?>" />
				<div class="text-danger"><?php echo form_error('start_date') ?></div>
			</div>
			<div class="form-group <?php echo form_error('end_date') ? 'has-error' : '' ?>">
				<label for="end_date" class="control-label">End date</label>
				<input type="text" class="form-control" name="end_date" value="<?php echo (set_value('end_date')) ? set_value('end_date') : '' ?>" />
				<div class="text-danger"><?php echo form_error('end_date') ?></div>
			</div>
		</div>
	</div>
    <div class="form-group">
		<input type="submit" class="btn btn-primary" name="insert_banner" value="Insert New Banner" />
    </div>
<?php echo form_close() ?>

<?php $this->load->view('admin/templates/footer') ?>