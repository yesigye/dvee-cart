<?php $this->load->view('admin/templates/header', array(
	'title' => 'Manage Pages',
	'link' => 'extras',
	'sub_link' => 'pages',
	'breadcrumbs' => array(
		0 => array('name'=>'Pages','link'=>'pages'),
		1 => array('name'=>$page_data->name,'link'=>FALSE)
	)
)); ?>

<?php if (validation_errors()): ?>
		<div class="alert alert-danger"><?php echo validation_errors() ?></div>
<?php else: ?>
	<?php if (! empty($message)): ?>
		<div id="message"> <?=$message ?> </div>
	<?php endif ?>
<?php endif ?>


<?php echo form_open(current_url()) ?>
	<div class="form-group <?= form_error('name') ? 'has-error' : '' ?>">
		<label class="control-label" for="name">Page Name</label>
		<input class="form-control" type="text" name="name" placeholder="for example; events" value="<?= set_value('name') ? set_value('name') : $page_data->name ?>" />
		<div class="text-danger"><?= form_error('name') ? form_error('name') : '&nbsp' ?></div>
	</div>
	<div class="form-group <?= form_error('body') ? 'has-error' : '' ?>">
		<label class="control-label" for="body">Compose Page Body</label>
		<textarea class="form-control" name="body" id="editor" rows="8"><?= set_value('body') ? set_value('body') : $page_data->body ?></textarea>
		<div class="text-danger"><?= form_error('body') ? form_error('body') : '&nbsp' ?></div>
	</div>
	<div class="form-group">
		<input type="submit" name="update_page" value="Update Page" class="btn btn-lg btn-success" />
	</div>
<?php echo form_close() ?>

<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.6.1/standard-all/ckeditor.js"></script>
<script>
	$(document).ready(function() {
		CKEDITOR.replace('editor');
	});
</script>

<?php $this->load->view('admin/templates/footer'); ?>