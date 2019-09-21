<?php $this->load->view('public/templates/header') ?>

<div class="container">
	<?php if (!$categories): ?>
		<div class="alert alert-info">
			<h1 class="lead" style="text-transform:uppercase">
				<small>There are no products to display</small>
			</h1>
		</div>
	<?php else: ?>
		<div class="card-group row">
			<div class="card p-0 col-md-8">
			<?php if ($banners): ?>
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<?php foreach ($banners as $key => $banner): ?>
						<li data-target="#carousel-example-generic" data-slide-to="<?php echo $key ?>" class="<?php echo $key ? 'active' : '' ?>"></li>
						<?php endforeach ?>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<?php foreach ($banners as $key => $banner): ?>
							<div class="carousel-item <?php echo $key ? 'active' : '' ?>">
								<img src="<?php echo base_url($banner->image) ?>" alt="..." style="width:100%">
								<?php if ($banner->caption): ?>
									<div class="lead carousel-caption">
										<?php echo $banner->caption ?>
									</div>
								<?php endif ?>
							</div>
						<?php endforeach ?>
					</div>

					<!-- Controls -->
					<a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
						<span class="fa fa-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
						<span class="fa fa-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			<?php else: ?>
				<div class="well">
					<h1 class="lead text-center" style="margin:6rem 0">Welcome to <?php echo $owner->name ?></h1>
				</div>
			<?php endif ?>
			</div>
			<div class="card p-0 col-md-4 text-center">
				<div class="lead card-header">
					Latest in <?php echo $latest[0]->category ?>
				</div>
				<div id="carousel-latest" class="card-body carousel slide" data-ride="carousel">
					<div class="carousel-inner" role="listbox">
						<?php foreach ($latest as $key => $product): ?>
							<div class="carousel-item <?php echo ($key==0) ? 'active' : '' ?>">
								<img src="<?php echo $product->thumb ?>" alt="..." class="img-responsive">
								<p><?php echo $product->name ?></p>
								<div class="text-muted">
									<?php echo $this->flexi_cart->get_currency_value($product->price) ?>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				</div>
				<script>
				$('.carousel-latest').carousel({
					interval: 300
				})
				</script>
				<?php echo anchor('category/'.$latest[0]->category_id.'/'.$latest[0]->category, 'Shop Now', 'class="card-footer bg-success text-white card-link"') ?>
			</div>
		</div>

		<?php foreach ($categories as $key => $category): ?>
		<p class="my-4">
			Newest in <?php echo $category->name ?>
			<a href="<?php echo site_url('category/'.$category->slug.'/'.url_title($category->name)) ?>" class="btn btn-sm btn-secondary float-right">See more</a>
		</p>
		<div class="row card-group horizontal-scroll">
		<?php foreach ($category->products as $key => $product): ?>
			<div class="col-md-6 col-lg-3 card small p-0 scroll-item">
				<div class="card-body">
					<div class="text-center">
						<?php if ($product->thumb): ?>
							<img src="<?php echo base_url($product->thumb) ?>" class="img-fluid">
						<?php else: ?>
							<img src="<?php echo base_url() ?>assets/system/no_image.jpg" class="img-fluid">
						<?php endif ?>
					</div>
					<div class="text-trunate mb-2" style="height:40px;overflow:hidden;" title="<?php echo $product->name ?>">
						<?php echo $product->name ?>
					</div>
				</div>
				<div class="card-footer bg-white border-0">
					<div class="d-flex justify-content-between align-items-center">
						<?php echo form_open('add_to_cart', 'class="d-inline"') ?>
							<div class="btn-group">
								<button type="button" class="btn btn-sm btn-outline-secondary">View</button>
								<?php echo form_hidden('id', $product->id) ?>
								<?php echo form_hidden('name', $product->name) ?>
								<?php echo form_hidden('thumb', $product->thumb) ?>
								<?php echo form_hidden('price', $product->price) ?>
								<button type="submit" class="btn btn-sm btn-outline-secondary">
									Buy
								</button>
							</div>
						<?php echo form_close() ?>
						<strong><?php echo $this->flexi_cart->get_currency_value($product->price) ?></strong>
					</div>
				</div>
			</div>
		<?php endforeach ?>
		</div>
		<?php endforeach ?>

	<?php endif ?>
</div>

<?php $this->load->view('public/templates/footer') ?>