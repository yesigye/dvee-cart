<?php $this->load->view('admin/templates/header', array(
	'title' => 'Manage Banners',
	'link' => 'extras',
	'sub_link' => 'banners',
	'breadcrumbs' => array(
		0 => array('name'=>'Banners','link'=>FALSE)
	)
)); ?>

<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check banners that you want to delete.</div>
<?php else: ?>
	<?php if (! empty($message)): ?>
		<div id="message"> <?=$message ?> </div>
	<?php endif ?>
<?php endif ?>

<?php if ($banners): ?>
	<?php echo form_open(current_url()) ?>
		<p>
			<button type="submit" name="delete_selected" value="Delete Selected" class="btn btn-danger">
				<span class="fa fa-remove"></span> Selected
			</button>
			<a href="<?php echo site_url('admin/insert_banner') ?>" class="btn btn-success">
				<span class="fa fa-plus"></span> Banner
			</a>
		</p>

		<table class="table table-flat table-striped">
			<thead>
				<tr>
					<th class="text-center"><?php echo form_checkbox('select_all') ?></th>
					<th>Title</th>
					<th class="text-center">Preview</th>
					<th class="text-center">Status</th>
					<th class="text-center">Days Left</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($banners as $key => $banner): ?>
					<tr>
						<td class="text-center"><?php echo form_checkbox('selected[]', $banner->id) ?></td>
						<td>
							<?php echo $banner->title ?>
						</td>
						<td class="text-center">
							<img src="<?php echo base_url($banner->image) ?>" alt="" style="height:45px">
						</td>
						<td class="text-center">
							<?php if (date('Y-m-d') <= $banner->end_date): ?>
								<span class="label label-success">running</span>
							<?php elseif (date('Y-m-d') <= $banner->end_date): ?>
								<span class="label label-warning">pending</span>
							<?php else: ?>
								<span class="label label-danger">expired</span>
							<?php endif ?>
						</td>
						<td class="text-center">
							<?php echo $banner->days_left ?>
						</td>
						<td class="text-center">
							<a href="<?php echo site_url('admin/update_banner/'.$banner->id) ?>" class="btn btn-info">
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
		You have no banners setup.
		<?php echo anchor('admin/insert_banner', 'Insert Banners', 'class="alert-link"') ?>
	</div>
<?php endif ?>

<?php $this->load->view('admin/templates/footer') ?>