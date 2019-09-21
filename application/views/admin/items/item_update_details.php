<?php $this->load->view('admin/templates/header', array(
	'title' => 'Update Item Details',
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
		'active' => 'details',
	)); ?>

	<?php if (validation_errors()): ?>
			<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<?php if (! empty($message)): ?>
			<div id="message"> <?=$message ?> </div>
		<?php endif ?>
	<?php endif ?>

	<div class="row">
    	<div class="col-sm-12 col-md-3 form-group <?php echo form_error('userfile') ? 'has-error' : '' ?>">
			<?php echo form_hidden('crop_x', '') ?>
			<?php echo form_hidden('crop_y', '') ?>
			<?php echo form_hidden('crop_width', '') ?>
			<?php echo form_hidden('crop_height', '') ?>
			<div class="card <?php echo form_error('userfile') ? 'border-danger' : '' ?>" style="margin:0">
				<label class="card-header">Thumbnail</label>
				<div class="fileinput fileinput-item-thumb fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail text-muted">
						<img src="<?php echo $product->thumb ?>">
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail">
					</div>
					<div class="btn-group btn-block">
						<button class="btn btn-file rounded-0">
							<span class="fileinput-new">Select image</span>
							<span class="fileinput-exists">Change</span>
							<input type="file" name="userfile">
						</button>
						<a href="#" class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
					</div>
				</div>
			</div>
			<p class="help-block"><?php echo form_error('userfile') ? form_error('userfile') : '&nbsp' ?></p>
	    </div>
        <div class="col-sm-12 col-md-9">
		    <div class="row">
		        <div class="col-sm-12 col-md-6">
		            <div class="form-group <?php echo form_error('name') ? 'has-error' : '' ?>">
		                <label class="control-label" for="name">Name</label>
		                <input type="text" class="form-control" name="name" value="<?php echo set_value('name') ? set_value('name') : $product->name ?>" />
		                <p class="help-block"><?php echo form_error('name') ? form_error('name') : '&nbsp' ?></p>
		            </div>
		        </div>
		        <div class="col-sm-12 col-md-6">
		            <div class="form-group <?php echo form_error('tags') ? 'has-error' : '' ?>">
		                <label class="control-label" for="tags">Tags</label>
		                <input type="text" class="form-control" name="tags" value="<?php echo set_value('tags') ? set_value('tags') : $product->tags ?>" />
		                <p class="text-muted small"><?php echo form_error('tags') ? form_error('tags') : 'Separate each tag by a comma.' ?></p>
		            </div>
		        </div>
				<div class="col-sm-12 col-md-6">
					<div class="form-group <?php echo form_error('category') ? 'has-error' : '' ?>">
						<label class="control-label" for="category">Category</label>
							<?php
							$options = array();
							foreach ($categories as $category)
							{
								$options[$category['id']] = $category['name'];
							}
							 ?>
						<?php echo form_dropdown('category', $options, $product->category_id, 'class="form-control"'); ?>
		                <p class="help-block"><?php echo form_error('category') ? form_error('category') : '&nbsp' ?></p>
					</div>
				</div>
                <div class="col-sm-6 col-md-6">
                   	<div class="form-group <?php echo form_error('price') ? 'has-error' : '' ?>">
                        <label class="control-label" for="price">Price</label>
                        <div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><?php echo $this->flexi_cart_admin->currency_symbol(TRUE); ?></span>
							</div>
							<input type="text" class="form-control" id="inputPrice" placeholder="Item price" name="price" value="<?php echo set_value('price') ? set_value('price') : $product->price ?>"/>
                        </div>
		                <p class="help-block"><?php echo form_error('price') ? form_error('price') : '&nbsp' ?></p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group <?php echo form_error('stock') ? 'has-error' : '' ?>">
                        <label class="control-label" for="stock">Stock Quantity</label>
                        <input type="number" class="form-control" name="stock" value="<?php echo set_value('stock') ? set_value('stock') : $product->quantity ?>" />
		                <p class="help-block"><?php echo form_error('Stock') ? form_error('Stock') : '&nbsp' ?></p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group <?php echo form_error('weight') ? 'has-error' : '' ?>">
                        <label class="control-label" for="weight">Weight (<?php echo $this->flexi_cart_admin->weight_symbol(); ?>)</label>
                        <input type="text" class="form-control" name="weight"  value="<?php echo set_value('weight') ? set_value('weight') : $product->weight ?>" />
		                <p class="help-block"><?php echo form_error('weight') ? form_error('weight') : '&nbsp' ?></p>
                    </div>
                </div>
		    </div>
	    </div>
	</div>

	<div class="form-group">
		<label class="control-label" for="description">Description</label>
		<textarea rows="6" class="form-control" name="description"><?php echo set_value('description') ? set_value('description') : $product->description ?></textarea>
	</div>

	<?php echo form_submit('update_item', 'Update Item Details', 'class="btn btn-lg btn-success"') ?>
	
<?php echo form_close() ?>

<script type="text/javascript" src="<?= base_url('assets/js/cropper.min.js') ?>"></script>
<script>
	$(document).ready(function() {
		$('.fileinput-item-thumb').on('change.bs.fileinput', function (e) {
			$('.fileinput-preview img').cropper({
				aspectRatio: 1 / 1,
				crop: function(e) {
					$('input[name="crop_width"]').val(e.width);
					$('input[name="crop_height"]').val(e.height);
					$('input[name="crop_x"]').val(e.x);
					$('input[name="crop_y"]').val(e.y);
				}
			});
		})

        $('.fileinput-item-image').on('change.bs.fileinput', function (e) {
            var key = $(this).attr('data-key');
            $(this).find('.fileinput-preview img').cropper({
                aspectRatio: 1 / 1,
                crop: function(e) {
                    $('input[name="crop_width['+key+']"]').val(e.width);
                    $('input[name="crop_height['+key+']"]').val(e.height);
                    $('input[name="crop_x['+key+']"]').val(e.x);
                    $('input[name="crop_y['+key+']"]').val(e.y);
                }
            });
        })
	});
</script>

<?php $alert = $this->session->flashdata('alert') ?>

<?php if (isset($alert['location'])): ?>
	<script>
		$(document).ready(function() {
			$('#app-tabs a[href="#app-tab-<?php echo $alert['location'] ?>"]').tab("show")
		})
	</script>
<?php endif ?>

<?php $this->load->view('admin/templates/footer') ?>