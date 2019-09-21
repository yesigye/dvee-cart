<?php $this->load->view('admin/templates/header', array(
	'title' => 'Update Item Variation',
	'link' => 'items',
	'breadcrumbs' => array(
		0 => array('name'=>'Items','link'=>'items'),
		1 => array('name'=>$product->name,'link'=>'update_item/'.$product->id),
		2 => array('name'=>'Variations','link'=>'update_item_options/'.$product->id),
		3 => array('name'=>'Update Variation','link'=>FALSE),
	)
)); ?>


<?php echo form_open_multipart(current_url()) ?>
	<?php echo form_hidden('id', $product->id) ?>
		
	<?php $this->load->view('admin/items/item_update_header', array(
		'id' => $product->id,
		'active' => 'options',
	)); ?>

	<div class="page-header">
		<h4 class="lead">Update Product Variation</h4>
		<p>
			Product options are used to create variations of the same product. Variations may affect the product's price and weight.
			If set, a user may choose an item option before checkout.
		</p>
	</div>

	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<?php if (! empty($message)): ?>
			<div id="message"> <?=$message ?> </div>
		<?php endif ?>
	<?php endif ?>

	<div class="form-group <?php echo form_error('values[]') ? 'has-error' : '' ?>">
		<label for="">Options</label>
		<p class="help-block">Select Attribute combinations. <?php echo form_error('values[]') ? 'Select at least one attribute' : '&nbsp' ?></p>
		<?php if (!$product_options): ?>
			<div class="alert alert-danger">
				Select item attributes first.
			</div>
		<?php else: ?>
			<div class="row">
				<?php foreach ($product_options as $option): ?>
					<div class="col-md-2">
						<div class="form-group <?php echo form_error('values[]') ? 'has-error' : '' ?>">
							<label for="" class="control-label"><?php echo $option['name'] ?></label>
							<select class="form-control" name="values[<?php echo $option['id'] ?>]">
								<option value="0">Any <?php echo $option['name'] ?></option>
								<?php foreach ($option['values'] as $value): ?>
									<option value="<?php echo $value['id'] ?>" <?php echo (in_array($value['id'], $product_option->values)) ? 'selected="selected"' : '' ?>>
										<?php echo $value['name'] ?>
									</option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	<?php endif ?>
	<hr>
	<?php if ($product_options): ?>
		<div class="row">
			<div class="col-md-2">
				<div class="form-group <?php echo form_error('option_price') ? 'has-error' : '' ?>">
					<label class="control-label">Price</label>
					<input type="text" name="option_price" class="form-control" value="<?php echo set_value('option_price') ? set_value('option_price') : $product_option->price ?>">
	                <p class="help-block"><?php echo form_error('option_price') ? form_error('option_price') : '&nbsp' ?></p>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group <?php echo form_error('option_weight') ? 'has-error' : '' ?>">
					<label class="control-label">Weight</label>
					<input type="text" name="option_weight" class="form-control" value="<?php echo set_value('option_weight') ? set_value('option_weight') : $product_option->weight ?>">
					<p class="help-block"><?php echo form_error('option_weight') ? form_error('option_weight') : '&nbsp' ?></p>
				</div>
			</div>
		</div>
	<?php endif ?>

	<div class="lead page-header">Variant Images</div>
	<?php if ($product_option->images): ?>
		<?php $index = 0; ?>
		<div class="row">
			<?php foreach ($product_option->images as $image): ?>
				<div class="col-md-3 app-image-widget" data-id="<?php echo $image->id ?>">
					<div class="card">
						<div class="card-header text-right">
							<?php echo form_hidden('product_id', $product->id) ?>
							<?php echo form_hidden('file_id', $image->id) ?>
							<?php echo form_hidden('update_item_thumbnail', TRUE) ?>
							<button type="button" class="btn btn-xs btn-danger app-image-widget-delete" data-toggle="tooltip" data-placement="bottom" title="delete image">
								<span class="fa fa-times"></span>
							</button>
						</div>
						<img src="<?php echo $image->url ?>" alt="" class="img-fluid" data-toggle="modal" data-target="#app-carousel-modal">
					</div>
				</div>
			<?php endforeach ?>
		</div>
		<script>
		    $( ".app-image-widget-delete").click(function() {
		    	var container = $(this).closest('.app-image-widget');
		    	var imageID = container.attr('data-id');
		    	var button = $(this);
		        $.ajax({
		        	type: 'POST',
		        	data: {
		        		delete_item_image: true,
		        		id: imageID,
		        		<?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash() ?>'
		        	},
		            url: '<?php echo current_url(); ?>',
		            cache: true,
		            beforeSend: function(){
		            	button.html('<span class="fa fa-spinner"></span>')
		            },
		            success: function(data){
		                container.addClass('animated zoomOut');
		                setTimeout(function(){
			                container.remove();
		                }, 550);
		            },
		            complete: function(data){
		            	button.html('<span class="fa fa-times"></span>')
		            }
		        });
		    });
		</script>
	<?php else: ?>
		<div class="my-4 text-muted">
			You have no images for this Variant.
		</div>
	<?php endif ?>

	<p class="text-muted mt-4">
		You can upload a maximum of <?php echo $upload_limit ?> <?php echo ($product->images) ? 'more' : '' ?> images.
	</p>
	<div class="form-group <?php echo form_error('files[]') ? 'has-error' : '' ?>">
		<input type="file" name="files[]" multiple class="form-control">
	</div>

	<hr>

	<input type="submit" name="update_option" class="btn btn-lg btn-primary" value="Update Product Option">

<?php echo form_close() ?>

<?php $this->load->view('admin/templates/footer') ?>