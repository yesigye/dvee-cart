<?php $this->load->view('admin/templates/header', array(
	'title' => 'Update Item Attributes',
	'link' => 'items',
	'breadcrumbs' => array(
		0 => array('name'=>'Items','link'=>'items'),
		1 => array('name'=>$product->name,'link'=>FALSE),
	)
)); ?>


<?php echo form_open_multipart(current_url()) ?>
	<?php echo form_hidden('id', $product->id) ?>
		
	<?php $this->load->view('admin/items/item_update_header', array(
		'id' => $product->id,
		'active' => 'attributes',
	)); ?>

	<?php if (isset($product->category->id)): ?>
		<p class="my-4">
			To change product attributes, update the attributes of the category that the product belongs to.
			<?php echo anchor('admin/update_attribute/'.$product->category->id, 'Change Attributes') ?>
		</p>
	<?php endif ?>

	<?php if (validation_errors()): ?>
			<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<?php if (! empty($message)): ?>
			<div id="message"> <?=$message ?> </div>
		<?php endif ?>
	<?php endif ?>

	<?php if (isset($product->attributes)): ?>
		<?php if ($product->attributes): ?>
			<?php $index = 0; ?>
			<div class="row">
				<?php foreach ($product->attributes as $attribute): ?>
					<div class="col-md-3">
						<div class="card mb-3">
							<div class="card-header bg-secondary text-white">
								<strong><?php echo $attribute->name ?></strong>
							</div>
							<ul class="list-group list-group-flush" style="max-height:250px;overflow:auto">
								<?php foreach ($attribute->descriptions as $description): ?>
								<li class="list-group-item">
									<label class="custom-control custom-checkbox m-0" for="<?php echo "attributes[$index]".$attribute->id.'_'.$description->id ?>">
										<?php echo form_checkbox(
											"attributes[$index]",
											$attribute->id.'_'.$description->id, $description->checked,
											[
												'id' => "attributes[$index]".$attribute->id.'_'.$description->id,
												'class' => 'custom-control-input'
											]
										); ?>
										<div class="custom-control-label">
											<?php echo $description->name; $index++ ?>
										</div>
									</label>
								</li>
								<?php endforeach ?>
							</ul>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		<?php else: ?>
			<div class="my-5 text-muted">
				No product attributes are set for this category.
				<?php echo anchor('admin/update_attribute/'.$product->category->id, 'Set Attributes', 'class="alert-link"') ?>
			</div>
		<?php endif ?>
	<?php else: ?>
		<div class="my-5 text-muted">
			This product is not assigned to any category.
			<?php echo anchor('admin/update_item/'.$product->id, 'Assign a Category', 'class="alert-link"') ?>
		</div>
	<?php endif ?>

	<?php echo form_submit('update_attributes', 'Update Item Attributes', 'class="btn btn-success my-4"') ?>
	
<?php echo form_close() ?>

<?php $this->load->view('admin/templates/footer') ?>