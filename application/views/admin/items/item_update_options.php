<?php $this->load->view('admin/templates/header', array(
	'title' => 'Update Item Variation',
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
		'active' => 'options',
	)); ?>

	<?php if (validation_errors()): ?>
	<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<?php if (! empty($message)): ?>
			<div id="message"> <?=$message ?> </div>
		<?php endif ?>
	<?php endif ?>

	<?php if (empty($product_variants)): ?>
		<div class="my-5 text-muted">You have no options for this item.</div>
	<?php else: ?>
		<div class="row">
			<div class="col-8">
				<abbr title="Combine different attributes to create a product option. each option can have a different price or weight.">
					Product Options
				</abbr>
			</div>
			<div class="col-4 text-right">
				<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-insert">Add Option</button>
			</div>
		</div>
		<p class="text-muted mt-3">
			Strike out values indicate that they have been over-written by the values set for the product options.
		</p>
		<div class="table-responsive">
			<table class="table">
				<thead class="bg-faded">
					<tr>
						<th>Attributes</th>
						<th class="text-center">Price</th>
						<th class="text-center">Weight</th>
						<th class="text-center">
							<abbr title="The default options will be the pre-selected options when a user views this product">Default</abbr>	
						</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<div class="media">
								<img src="<?php echo $product->thumb ?>" class="align-self-center mr-2" alt="" style="height:35px">
								<div class="media-body small">
								<?php foreach ($product_options as $option): ?>
									<b><?php echo $option['name'] ?>:</b> <?php echo 'Any '.$option['name'] ?>
									<br>
								<?php endforeach ?>
								</div>
							</div>
						</td>
						<td class="text-center"><?php echo $product->price ?></td>
						<td class="text-center"><?php echo $product->weight ?></td>
						<td class="text-center">
							<?php
								$orignial_is_deafult = true;
								foreach ($product_variants as $key => $variant) {
									if($variant->default) { $orignial_is_deafult = false; break; }
								}
							?>
							<label for="opt-origin" class="d-inline-block m-0 custom-control custom-radio">
								<input type="radio" name="default_option" value class="custom-control-input" id="opt-origin"
								<?php echo ($orignial_is_deafult) ? 'checked' : '' ?>
								>
								<div class="custom-control-label"></div>
							</label>
						</td>
						<td class="text-center small text-muted">No actions for orignial</td>
					</tr>
					<?php foreach ($product_variants as $key => $variant): ?>
					<tr>
						<td>
							<div class="media">
								<?php if (!empty($variant->images)): ?>
									<img src="<?php echo $variant->images[0]->url ?>" class="align-self-center mr-2" alt="" style="height:35px">
								<?php else: ?>
									<span class="fa fa-picture text-muted"></span>
								<?php endif ?>
								<div class="media-body small">
								<?php foreach ($product_options as $option): ?>
									<b><?php echo $option['name'] ?>:</b>
									<?php
										$value_name = 'Any '.$option['name'];
										foreach ($option['values'] as $value) {
											if (in_array($value['id'], $variant->options_set)) $is_checked = 'checked';
											if ($value_name == 'Any '.$option['name'] && in_array($value['id'], $variant->options_set)) {
												$value_name = $value['name'];
											}
										}
									?>
									<?php echo $value_name ?>
									<br>
								<?php endforeach ?>
								</div>
							</div>
						</td>
						<td class="text-center">
							<?php if ($variant->price > 0): ?>
								<strike class="text-danger"><?php echo $product->price ?></strike>
								<?php echo $variant->price ?>
							<?php else: ?>
								<?php echo $product->price ?>
							<?php endif ?>
						</td>
						<td class="text-center">
							<?php if ($variant->weight > 0): ?>
								<div class="text-danger" style="text-decoration:line-through;"><?php echo $product->weight ?></div>
								<?php echo $variant->weight ?>
							<?php else: ?>
								<?php echo $product->weight ?>
							<?php endif ?>
						</td>
						<td class="text-center">
							<label for="opt-<?php echo $variant->id ?>" class="d-inline-block m-0 custom-control custom-radio">
								<input type="radio" name="default_option" value="<?php echo $variant->id ?>" class="custom-control-input" id="opt-<?php echo $variant->id ?>"
								<?php echo ($variant->default) ? 'checked' : '' ?>
								>
								<div class="custom-control-label"></div>
							</label>
						</td>
						<td class="text-center">
							<div class="btn-group">
								<?php echo anchor('admin/update_item_option/'.$product->id.'/'.$variant->id, 'Edit', 'class="btn btn-sm btn-primary"') ?>
								<?php echo anchor('admin/delete_item_options/'.$product->id.'/'.$variant->id, 'Delete', 'class="btn btn-sm btn-danger"') ?>
							</div>
						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>

		<div class="text-right mt-3">
			<input type="submit" name="update_defaults" value="Update Defaults" class="btn btn-success">
		</div>
	<?php endif ?>

	<div class="modal fade" id="modal-insert">
		<div class="modal-dialog">
			<div class="modal-content border-0">
				<div class="modal-header bg-primary text-white">
					Add Product Option
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="help-block">Select Attribute combinations</p>
					<?php if (!$product_options): ?>
						<div class="alert alert-danger">
							Select item attributes first.
						</div>
					<?php else: ?>
						<div class="row">
							<?php foreach ($product_options as $option): ?>
								<div class="col-sm-4 col-md-6">
									<div class="form-group">
										<label for="" class="control-label"><?php echo $option['name'] ?></label>
										<select class="form-control input-sm" name="option[<?php echo $option['id'] ?>]">
											<option value="">Any <?php echo $option['name'] ?></option>
											<?php foreach ($option['values'] as $value): ?>
												<option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
							<?php endforeach ?>
						</div>
					<?php endif ?>
					<?php if ($product_options): ?>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group <?php echo form_error('option_file') ? 'has-error' : '' ?>">
								<label class="control-label">Upload Images</label>
								<p class="text-muted">
									<small>
										You can upload a maximum of <?php echo $upload_limit ?> <?php echo ($product->images) ? 'more' : '' ?> images.
									</small>
								</p>
								<input type="file" name="files[]" class="form-control input-sm" multiple>
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="control-label">Price</label>
								<input type="text" name="option_price" class="form-control input-sm">
							</div>
						</div>
						<div class="col-sm-6 col-md-6">
							<div class="form-group">
								<label class="control-label">Weight</label>
								<input type="text" name="option_weight" class="form-control input-sm">
							</div>
						</div>
					</div>
					<input type="submit" name="add_option" class="btn btn-primary mt-3" value="Submit">
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
<?php echo form_close() ?>

<?php $this->load->view('admin/templates/footer') ?>