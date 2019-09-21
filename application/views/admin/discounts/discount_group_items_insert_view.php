<?php $this->load->view('admin/templates/header', array(
	'title' => 'Update Discount Group',
	'link' => 'discounts',
	'sub_link' => 'groups',
	'breadcrumbs' => array(
		1 => array('name'=>'Discount Groups','link'=>'discount_groups'),
		2 => array('name'=>$group_data[$this->flexi_cart_admin->db_column('discount_groups', 'name')],'link'=>'update_discount_group/'.$group_data[$this->flexi_cart_admin->db_column('discount_groups', 'id')]),
		3 => array('name'=>'Insert New Items','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/discounts/discounts_sub_header', array(
	'active' => 'group'
)); ?>

<div class="page-header">
	<h4 class="lead">
		Insert New Items to "<?php echo $group_data[$this->flexi_cart_admin->db_column('discount_groups', 'name')]; ?>" discount group.
	</h4>
	<p>Items can be grouped together and a discount can then be applied to the group.</p>
</div>
			
<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>
										
<?php
// No products returned and it is not a result of filtering
if ( ! $products AND ! $_SERVER['QUERY_STRING']): ?>
	<div class="alert alert-warning">
		You currently have no items to view.
	</div>
<?php else: ?>
	<?php echo form_open(current_url()) ?>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-form navbar-left">
					<input type="submit" name="insert_selected" value="Insert to Discount Group" class="btn btn-success">
				</div>
				<div class="navbar-form navbar-right">
					<div class="form-group input-group">
						<input type="text" name="q" class="form-control" placeholder="Type Keywords" value="<?php echo $this->input->get('q') ?>">
						<span class="input-group-btn">
							<div class="btn-group" role="group" aria-label="Basic example">
								<input type="submit" name="search" value="Search" class="btn btn-primary">
							</div>
						</span>
					</div>
				</div>
			</div>
		</nav>

		<?php if (!$products): ?>
			<div class="alert alert-warning">
				Your filtering options returned no results.
				<?= anchor(current_url(), 'Reset filter', 'class="alert-link"') ?>
			</div>
		<?php else: ?>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th class="text-center"><?php echo form_checkbox('select_all') ?></th>
							<th class="text-center">Thumb</th>
							<th>Name</th>
							<th>Category</th>
							<th class="text-center">Quantity</th>
							<th class="text-center">Price</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<?php foreach ($products as $key => $product): ?>
						<tr id="<?php echo $product->id ?>">
							<td class="text-center"><?php echo form_checkbox('selected[]', $product->id) ?></td>
							<td class="text-center">
								<img src="<?php echo base_url($product->thumb) ?>" alt="" style="height:30px">
							</td>
							<td><?php echo $product->name ?></td>
							<td><?php echo $product->category ?></td>
							<td class="text-center"><?php echo $product->quantity ?></td>
							<td class="text-center"><?php echo $product->price ?></td>
							<td class="text-center">
								<?php echo anchor('admin/update_item/'.$product->id, 'Edit') ?>
							</td>
						</tr>
					<?php endforeach ?>
				</table>
			</div>
			<?php echo $pagination ?>
		<?php endif; ?>
	<?php echo form_close() ?>
<?php endif; ?>

<?php $this->load->view('admin/templates/footer'); ?>