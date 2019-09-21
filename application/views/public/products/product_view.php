<?php
$breadcrumbs = array();
// Create page breadcrumbs from category tiers
foreach ($category->pagination as $tier) {
	// Add formatted names and links to the breadcrumbs
	array_push($breadcrumbs, array(
		'name' => $tier->name,
		'link' => 'category/'.$tier->slug.'/'.$tier->name
	));
}
// Add the product to the breadcrumbs
array_push($breadcrumbs, array(
	'name' => $product->name,
	'link' => FALSE // No need for linking this very page
));
?>

<?php $this->load->view('public/templates/header', array(
	'title' => $product->name,
	'link' => empty($category->pagination) ? '' : $category->pagination[0]->slug,
)); ?>

<div class="container border-top">
	<div class="lead mt-3 mb-5">
		<?php echo $product->name ?>
	</div>

	<div class="row">
		<!-- carousel -->
		<div class="col-xs-12 col-sm-6 col-md-7 col-lg-6">
			<div class="thumbnail text-center">
				<?php if ($variant AND !empty($variant->images) !== ''): ?>
					<?php // Variant Image takes priority over product Image(s) ?>
					<?php if (count($variant->images) == 1): // Only one image, no need for a carousel ?>
						<?php foreach ($variant->images as $key => $img): ?>
							<img src="<?php echo $img->url ?>" class="img-responsive" style="max-height:350px;display:initial">
						<?php endforeach ?>
					<?php else: // Multiple images, use bootstrap carousel ?>
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<?php foreach ($variant->images as $key => $img): ?>
									<li data-target="#carousel-example-generic" data-slide-to="<?php echo $key ?>" class="<?php echo ($key === 0) ? 'active' : '' ?>"></li>
								<?php endforeach ?>
							</ol>

							<div class="carousel-inner" role="listbox">
								<?php foreach ($variant->images as $key => $img): ?>
									<div class="text-center item <?= ($key == 0) ? 'active' : '' ?>">
										<img src="<?php echo $img->url ?>" class="img-responsive" style="max-height:350px;display:initial">
									</div>
								<?php endforeach ?>
							</div>
						</div>
					<?php endif ?>
				<?php else: ?>
					<?php if ($product->images): // There are product images ?>
						<?php if (count($product->images) == 1): // Only one image, no need for a carousel ?>
							<?php foreach ($product->images as $key => $img): ?>
								<img src="<?php echo $img->url ?>" class="img-responsive" style="max-height:350px;display:initial">
							<?php endforeach ?>
						<?php else: // Multiple images, use bootstrap carousel ?>
							<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators">
									<?php foreach ($product->images as $key => $img): ?>
										<li data-target="#carousel-example-generic" data-slide-to="<?php echo $key ?>" class="<?php echo ($key === 0) ? 'active' : '' ?>"></li>
									<?php endforeach ?>
								</ol>

								<div class="carousel-inner" role="listbox">
									<?php foreach ($product->images as $key => $img): ?>
										<div class="text-center item <?= ($key == 0) ? 'active' : '' ?>">
											<img src="<?php echo $img->url ?>" class="img-responsive" style="max-height:350px;display:initial">
										</div>
									<?php endforeach ?>
								</div>
							</div>
						<?php endif ?>
					<?php else: // No product images, use thumbnail ?>
						<img src="<?php echo $product->thumb ?>" class="img-responsive" style="display:initial">
					<?php endif ?>
				<?php endif ?>

			</div>

			<a href="<?php echo current_url() ?>">
				<img src="<?php echo $product->thumb ?>" alt="" style="height:50px" class="img-thumbnail hoverable">
			</a>
			<?php foreach ($variant_thumbs as $row): ?>
				<a href="<?php echo $row['link'] ?>">
					<img src="<?php echo $row['image'] ?>" alt="" style="height:50px" class="img-thumbnail hoverable">
				</a>
			<?php endforeach ?>
		</div>
		<!-- end of carousel -->

		<div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
			<div class="lead page-header text-right" style="margin:0">
				<label>
					<?php if ($variant AND $variant->price > 0): ?>
						<s class="text-danger"><?php echo $this->flexi_cart->get_currency_value($product->price) ?></s>
						<span class="text-success"><?php echo $this->flexi_cart->get_currency_value($variant->price) ?></span>
					<?php else: ?>
						<span class="text-success"><?php echo $this->flexi_cart->get_currency_value($product->price) ?></span>
					<?php endif ?>
				</label>
			</div>

			<div class="panel panel-default">
				<?php echo form_open(current_url(), 'class="panel-body"') ?>
					<?php echo form_hidden('id', $product->id) ?>
					<?php echo form_hidden('name', $product->name) ?>
					<?php echo form_hidden('name', $product->name) ?>

					<?php if ($variant AND !empty($variant->images) !== ''): ?>
						<?php // Variant Image takes priority over product Image(s) ?>
						<?php echo form_hidden('thumb', $variant->images[0]->url) ?>
					<?php else: ?>
						<?php echo form_hidden('thumb', $product->thumb) ?>
					<?php endif ?>

					<?php if ($variant AND $variant->price > 0): ?>
						<?php echo form_hidden('price', $variant->price) ?>
					<?php else: ?>
						<?php echo form_hidden('price', $product->price) ?>
					<?php endif ?>

					<?php if ($variant AND $variant->weight > 0): ?>
						<?php echo form_hidden('weight', $variant->weight) ?>
					<?php else: ?>
						<?php echo form_hidden('weight', $product->weight) ?>
					<?php endif ?>

					<div class="form-group">
						<label class="control-label">Quantity</label>
						<input type="number" name="quantity" class="form-control input-lg" value="1">
					</div>

					<div class="row">
						<?php foreach ($product_options as $option): ?>
							<!-- <div class="col-xs-6">
								<div class="list-group">
									<a class="list-group-item disabled">
										<strong><?php echo $option['name'] ?></strong>
									</a>
									<?php foreach ($option['values'] as $value): ?>
										<a href="<?php echo $value['link'] ?>" class="list-group-item <?php echo (in_array($value['id'], $variant_selected) ? 'active' : '') ?>">
											<?php echo $value['name'] ?>
										</a>
									<?php endforeach ?>
								</div>
							</div> -->
						<?php endforeach ?>


						<?php foreach ($product_options as $option): ?>
							<div class="col-xs-6">
								<div class="form-group <?php echo form_error('options[]') ? 'has-error' : '' ?>">
									<label for="" class="control-label"><?php echo $option['name'] ?></label>
									<select class="form-control" name="options[<?php echo $option['name'] ?>]">
										<option value="Any <?php echo $option['name'] ?>">Any <?php echo $option['name'] ?></option>
										<?php foreach ($option['values'] as $value): ?>
											<option value="<?php echo $value['name'] ?>" <?php echo (in_array($value['id'], $variant_selected)) ? 'selected="selected"' : '' ?>>
												<?php echo $value['name'] ?>
											</option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
						<?php endforeach ?>
					</div>
					<input type="submit" name="add_to_cart" value="Add to Cart" class="btn btn-lg btn-block btn-success">
				<?php echo form_close() ?>
			</div>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-12 col-lg-12">
			<div class="lead page-header">
				Description
			</div>
			<?php echo $product->description ?>
		</div>
	</div>

	<?php if ($related_products): ?>
		<p class="lead mt-5">Related Products</p>
		<?php $this->load->view('public/products/products_tiles_view', array(
			'type' => 'tiles',
			'cols' => 'col-md-3 col-lg-2-5',
			'products' => $related_products
		)) ?>
	<?php endif ?>
	
	<hr>

	<!-- Inqury Form. -->
	<p class="lead mt-5">Ask about the product</p>
	<?php echo form_open(current_url().'#form', 'class="tumbnail"') ?>
		<?php if (validation_errors()): ?>
			<div class="alert alert-danger animated fadeInDown" id="message">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				The form was submitted with errors, please check the form and try again.
			</div>
		<?php endif ?>
		<div class="row">
			<?php if ( ! $this->data['user']): // Don't include for logged in users. we shall get if from the DB. ?>
			<div class="col-xs-12 col-sm-4 col-md-4">
				<div class="form-group <?= form_error('name') ? 'has-error' : '' ?>">
					<label class="control-label" for="name">Your name</label>
					<input type="text" class="form-control" name="name" value="<?= set_value('name') ?>" />
					<div class="text-danger"><?= form_error('name') ? form_error('name') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4">
				<div class="form-group <?= form_error('phone') ? 'has-error' : '' ?>">
					<label class="control-label" for="phone">Phone</label>
					<input type="text" class="form-control" name="phone" value="<?= set_value('phone') ?>" />
					<div class="text-danger"><?= form_error('phone') ? form_error('phone') : '&nbsp' ?></div>
				</div>
			</div>
			<?php endif ?>

			<div class="col-xs-12 col-sm-4 col-md-4">
				<div class="form-group <?= form_error('target_price') ? 'has-error' : '' ?>">
					<label class="control-label" for="target_price">Target price (<?php echo $this->flexi_cart->currency_name() ?>)</label>
					<input type="text" class="form-control" name="target_price" value="<?= set_value('target_price') ? set_value('target_price') : $product->price ?>" />
					<div class="text-danger"><?= form_error('target_price') ? form_error('target_price') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4">
				<div class="form-group <?= form_error('order_quantity') ? 'has-error' : '' ?>">
					<label class="control-label" for="order_quantity">Order quantity</label>
					<input type="number" class="form-control" name="order_quantity" value="<?= set_value('order_quantity') ? set_value('order_quantity') : 1 ?>" />
					<div class="text-danger"><?= form_error('order_quantity') ? form_error('order_quantity') : '&nbsp' ?></div>
				</div>
			</div>

			<?php if ( ! $this->data['user']): // Don't include for logged in users. we shall get if from the DB. ?>
			<div class="col-xs-12 col-sm-4 col-md-4">
				<div class="form-group <?= form_error('email') ? 'has-error' : '' ?>">
					<label class="control-label" for="email">Email address</label>
					<input type="text" class="form-control" value="<?= set_value('email') ?>" />
					<div class="text-danger"><?= form_error('email') ? form_error('email') : '&nbsp' ?></div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4">
				<div class="form-group <?= form_error('location') ? 'has-error' : '' ?>">
					<label class="control-label" for="location">Location</label>
					<input type="text" class="form-control" name="location" value="<?= set_value('location') ?>" />
					<div class="text-danger"><?= form_error('location') ? form_error('location') : '&nbsp' ?></div>
				</div>
			</div>
			<?php endif ?>

			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group <?= form_error('inquiry') ? 'has-error' : '' ?>">
					<label class="control-label" for="inquiry">Write an inquiry</label>
					<textarea name="inquiry" id="inquiry" class="form-control" rows="8"><?= set_value('inquiry') ?></textarea>
					<div class="text-danger"><?= form_error('inquiry') ? form_error('inquiry') : '&nbsp' ?></div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<input type="submit" name="inquiry_product" value="Send Inquiry" class="btn btn-lg btn-primary"></input>
		</div>
	<?php echo form_close() ?>
	<!-- end of Inquiry Form -->

	<hr>

	<?php if ($random_products): ?>
		<p class="lead mt-5">You may also Like</p>
		<?php $this->load->view('public/products/products_tiles_view', array(
			'type' => 'tiles',
			'cols' => 'col-md-3 col-lg-2-5',
			'products' => $random_products
		)) ?>
	<?php endif ?>


	<div class="text-center">
		<button id="nav-to-top" class="btn btn-lg btn-default" style="position: fixed;bottom:10px;right: 10px;z-index: 100;width:auto;">
			<span class="fa fa-chevron-up"></span> up
		</button>
	</div>
</div>

<?php $this->load->view('public/templates/footer') ?>