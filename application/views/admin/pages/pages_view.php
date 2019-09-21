<?php $this->load->view('admin/templates/header', array(
	'title' => 'Manage Pages',
	'link' => 'extras',
	'sub_link' => 'pages',
	'breadcrumbs' => array(
		0 => array('name'=>'Pages','link'=>FALSE)
	)
)); ?>

<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the pages you want to delete first.</div>
<?php else: ?>
	<?php if (! empty($message)): ?>
		<div id="message"> <?=$message ?> </div>
	<?php endif ?>
<?php endif ?>

<?php if ($pages): ?>
	<?php echo form_open(current_url()) ?>
		<p>
			<button type="submit" name="delete_selected" value="Delete Selected" class="btn btn-danger">
				<span class="fa fa-remove"></span> Selected
			</button>
			<a href="<?php echo site_url('admin/insert_page') ?>" class="btn btn-success">
				<span class="fa fa-plus"></span> Page
			</a>
		</p>

		<table class="table table-flat table-striped">
			<thead>
				<tr>
					<th class="text-center"><?php echo form_checkbox('select_all') ?></th>
					<th>Page Name</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($pages as $key => $page): ?>
					<tr>
						<td class="text-center"><?php echo form_checkbox('selected[]', $page->id) ?></td>
						<td><?php echo $page->name ?></td>
						<td class="text-center">
							<a href="<?php echo site_url('admin/update_page/'.$page->id) ?>" class="btn btn-info">
								<span class="fa fa-edit"></span> Edit
							</a>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	<?php echo form_close() ?>
<?php else: ?>
	<div class="alert alert-warning">
		You have no pages setup.
		<?php echo anchor('admin/insert_page', 'Insert New Page', 'class="alert-link"') ?>
	</div>
<?php endif ?>



<?php $this->load->view('admin/templates/footer'); ?>