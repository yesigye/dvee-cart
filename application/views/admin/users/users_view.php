<?php $this->load->view('admin/templates/header', array(
	'title' => 'Users',
	'link' => 'users',
	'breadcrumbs' => array(
		0 => array('name'=>'Users','link'=>FALSE),
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
<?php endif ?>

<?php
// No Users returned and it is not a result of filtering
if ( ! $users AND ! $_SERVER['QUERY_STRING']): ?>

	<div class="alert alert-warning">
		You have no users yet.
	</div>
<?php else: ?>
	<div id="docs-widget">
		<?php if (!$users): ?>
			<div class="alert alert-warning">
				Your filtering options returned no results.
				<?= anchor(current_url(), 'Reset filter', 'class="alert-link"') ?>
			</div>
		<?php else: ?>
		<?php $this->load->view('admin/users/users_widget_view', array(
			'users' => $users,
			'action' => array('edit','delete'),
			'widget_key' => 'DOC'
		)) ?>
		<?php endif ?>
	</div>
<?php endif; ?>

<?php $this->load->view('admin/templates/footer') ?>