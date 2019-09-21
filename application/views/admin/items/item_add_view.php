<?php $this->load->view('admin/templates/header', array(
	'title' => 'Insert item',
	'link' => 'items',
	'sub_link' => 'add',
	'breadcrumbs' => array(
		0 => array('name'=>'Items','link'=>'items'),
		1 => array('name'=>'Insert Item','link'=>FALSE)
	)
)); ?>

<?php echo form_open_multipart(current_url()) ?>
	<div class="lead page-header">
		Add a new item
	</div>

	<?php if (validation_errors()): ?>
			<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<?php if (! empty($message)): ?>
			<div id="message"> <?=$message ?> </div>
		<?php endif ?>
	<?php endif ?>

	<div class="row">
		<div class="col-md-12">
		    <div class="row">
		        <div class="col-sm-12 col-md-3 form-group <?php echo form_error('userfile') ? 'has-error' : '' ?>">
					<?php echo form_hidden('crop_x', '') ?>
					<?php echo form_hidden('crop_y', '') ?>
					<?php echo form_hidden('crop_width', '') ?>
					<?php echo form_hidden('crop_height', '') ?>
					<div class="panel <?php echo form_error('userfile') ? 'panel-danger' : 'panel-default' ?>" style="margin:0">
						<div class="panel-heading">Thumbnail</div>
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-new thumbnail text-muted">
							<h1 style="margin: 2rem 0;"> <span class="fa fa-picture"></span> </h1>
							</div>
							<div class="fileinput-preview fileinput-exists thumbnail">
							</div>
							<div class="btn-group btn-block">
								<div class="btn btn-default btn-file">
									<span class="fileinput-new">Select</span>
									<span class="fileinput-exists">Change</span>
									<input type="file" name="userfile">
								</div>
								<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
							</div>
						</div>
					</div>
					<p class="help-block"><?php echo form_error('userfile') ? form_error('userfile') : '&nbsp' ?></p>
			    </div>
		        <div class="col-sm-12 col-md-9">
				    <div class="row">
				        <div class="col-sm-12 col-md-4">
				            <div class="form-group <?php echo form_error('name') ? 'has-error' : '' ?>">
				                <label class="control-label" for="name">Name</label>
				                <input type="text" class="form-control" name="name" value="<?php echo set_value('name') ?>" />
				                <p class="help-block"><?php echo form_error('name') ? form_error('name') : '&nbsp' ?></p>
				            </div>
				        </div>
				        <div class="col-sm-12 col-md-4">
				            <div class="form-group <?php echo form_error('tags') ? 'has-error' : '' ?>">
				                <label class="control-label" for="tags">Tags</label>
				                <input type="text" class="form-control" name="tags" value="<?php echo set_value('tags') ?>" />
				                <p class="help-block"><?php echo form_error('tags') ? form_error('tags') : 'Separate each tag by a comma.' ?></p>
				            </div>
				        </div>
						<div class="col-sm-12 col-md-4">
							<div class="form-group <?php echo form_error('category') ? 'has-error' : '' ?>">
								<label class="control-label" for="category">Category</label>
								<select name="category" class="form-control" id="input-category">
									<?php foreach ($categories as $category): ?>
										<option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
									<?php endforeach ?>
								</select>
				                <p class="help-block"><?php echo form_error('category') ? form_error('category') : '&nbsp' ?></p>
							</div>
						</div>
		                <div class="col-sm-6 col-md-4">
		                   	<div class="form-group <?php echo form_error('price') ? 'has-error' : '' ?>">
		                        <label class="control-label" for="price">Price</label>
		                        <div class="input-group">
		                            <span class="input-group-addon" id="basic-addon1"><?php echo $this->flexi_cart_admin->currency_symbol(TRUE); ?></span>
		                            <input type="text" class="form-control" id="inputPrice" placeholder="Item price" name="price" value="<?php echo set_value('price') ?>"/>
		                        </div>
				                <p class="help-block"><?php echo form_error('price') ? form_error('price') : '&nbsp' ?></p>
		                    </div>
		                </div>
		                <div class="col-sm-6 col-md-4">
		                    <div class="form-group <?php echo form_error('stock') ? 'has-error' : '' ?>">
		                        <label class="control-label" for="stock">Stock Quantity</label>
		                        <input type="number" class="form-control" name="stock" value="<?php echo set_value('stock') ?>" />
				                <p class="help-block"><?php echo form_error('stock') ? form_error('stock') : '&nbsp' ?></p>
		                    </div>
		                </div>
		                <div class="col-sm-6 col-md-4">
		                    <div class="form-group <?php echo form_error('weight') ? 'has-error' : '' ?>">
		                        <label class="control-label" for="weight">Weight (<?php echo $this->flexi_cart_admin->weight_symbol(); ?>)</label>
		                        <input type="text" class="form-control" name="weight"  value="<?php echo set_value('weight') ?>" />
				                <p class="help-block"><?php echo form_error('weight') ? form_error('weight') : '&nbsp' ?></p>
		                    </div>
		                </div>
				    </div>
			    </div>
			</div>

			<div class="form-group <?php echo form_error('description') ? 'has-error' : '' ?>">
				<label class="control-label" for="description">Description</label>
				<textarea rows="5" class="form-control" name="description" id="editor"><?php echo set_value('description') ?></textarea>
                <p class="help-block"><?php echo form_error('description') ? form_error('description') : '&nbsp' ?></p>
			</div>
		</div>
	</div>

	<?php echo form_submit('add_item', 'Insert New Product', 'class="btn btn-primary"') ?>
<?php echo form_close() ?>

<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.6.1/standard-all/ckeditor.js"></script>
<script type="text/javascript" src="<?= base_url('assets/js/cropper.min.js') ?>"></script>
<script>
	$(document).ready(function() {
		CKEDITOR.replace('editor');
		$('.fileinput').on('change.bs.fileinput', function (e) {
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
	});
</script>

<?php $this->load->view('admin/templates/footer') ?>