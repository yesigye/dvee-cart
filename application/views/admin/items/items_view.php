<?php $this->load->view('admin/templates/header', array(
	'link' => 'items',
	'breadcrumbs' => array(
		0 => array('name'=>'Products','link'=>FALSE)
	)
)); ?>

<?php if (validation_errors()): ?>
	<div class="alert alert-danger"><?php echo validation_errors() ?></div>
<?php else: ?>
	<?php if (! empty($message)): ?>
		<div id="message"> <?=$message ?> </div>
	<?php endif ?>
<?php endif ?>

<?php
// No products returned and it is not a result of filtering
if ( ! $products AND ! $_SERVER['QUERY_STRING']): ?>
	<div class="my-4 text-muted">
		You currently have no items setup. <?php echo anchor('admin/insert_item', 'Insert New Item', 'class="alert-link"') ?>
	</div>
<?php else: ?>
	<?php echo form_open(current_url()) ?>
		<div class="clearfix mb-3">
			<div class="float-left">
				<input type="submit" name="delete_selected" value="Delete Selected" class="btn btn-sm btn-danger">
				<?php echo anchor('admin/insert_item', 'Insert New Product', 'class="btn btn-sm btn-success"') ?>
			</div>
			<div class="form-group float-right">
				<div class="input-group">
					<input type="text" name="p_query" class="form-control form-control-sm" placeholder="Type Keywords" value="<?php echo $this->input->get('p_query') ?>">
					<span class="input-group-append">
						<button type="submit" name="p_search" value="Search" class="btn btn-sm btn-primary">
							<span class="fa fa-search"></span>
						</button>
					</span>
				</div>
			</div>
		</div>

		<?php if (!$products): ?>
			<div class="my-4 text-muted">
				Your filtering options returned no results.
				<?= anchor(current_url(), 'Reset filter', 'class="alert-link"') ?>
			</div>
		<?php else: ?>
			<div class="table-responsive">
				<table class="table table-striped">
					<thead class="">
						<tr>
							<th class="text-center"><?php echo form_checkbox('select_all') ?></th>
							<th class="text-center">
								<span class="fa fa-picture"></span>
							</th>
							<th>Name</th>
							<th>Category</th>
							<th class="text-center">Quantity</th>
							<th class="text-center">Price</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<?php foreach ($products as $key => $product): ?>
						<tr id="<?php echo $product->id ?>">
							<td class="text-center">
								<?php echo form_checkbox('selected[]', $product->id) ?>
							</td>
							<td class="text-center">
								<img src="<?php echo base_url($product->thumb) ?>" alt="" style="height:30px">
							</td>
							<td>
								<input type="text" name="update[<?php echo $product->id ?>][name]" value="<?php echo $product->name ?>" class="form-control input-sm">
							</td>
							<td>
								<?php
									$options = array('' => 'Not Set Yet');
									if ($product->category)
									{
										$selected_option = $product->category_id;
									}
									else
									{
										$selected_option = '';
									}
									foreach ($categories as $category)
									{
										$options[$category['id']] = $category['name'];
									}
								?>
								<?php echo form_dropdown('update['.$product->id.'][category]', $options, $selected_option, 'class="form-control input-sm"'); ?>
							</td>
							<td class="text-center">
								<input type="number" name="update[<?php echo $product->id ?>][quantity]" value="<?php echo $product->quantity ?>" class="form-control input-sm" style="width:100px">
							</td>
							<td class="text-center">
								<input type="number" name="update[<?php echo $product->id ?>][price]" value="<?php echo $product->price ?>" class="form-control input-sm" style="width:100px">
							</td>
							<td class="text-center">
								<?php echo anchor('admin/update_item/'.$product->id, 'Edit', 'class="btn btn-sm btn-primary"') ?>
							</td>
						</tr>
					<?php endforeach ?>
				</table>
			</div>
			<div class="text-right">
				<?php echo $pagination ?>
			</div>
			<button type="submit" name="update_items" value="update" class="btn btn-lg btn-success">Update Items</button>
		<?php endif; ?>
	<?php echo form_close() ?>
<?php endif; ?>


<?php $this->load->view('admin/templates/footer'); ?>