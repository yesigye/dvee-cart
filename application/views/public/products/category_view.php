<?php $this->load->view('public/templates/header', array(
	'title' => $category->name,
	'link' => (!empty($category->pagination)) ? $category->pagination[0]->slug : $category->slug,
	'sub_link' => 'profile'
)); ?>

<div class="container-fluid">
	<?php
	// No Items returned - and the user was not filtering
	if ( ! $products AND ! $_SERVER['QUERY_STRING']):
	?>
		<div class="my-4 text-muted">There are no products on sale yet.</div>
	<?php else: ?>
		<ul class="breadcrumb">
			<?php foreach ($category->pagination as $row): ?>
				<li class="breadcrumb-item">
					<?php
					// If the category we are viewing matches a category in pagination,
					// Do not create an anchor link for it because we are viewing it already
					if ($category->id == $row->id): ?>
						<?php echo $row->name ?>
					<?php else: ?>
						<?php echo anchor('category/'.$row->slug.'/'.$row->name, $row->name) ?>
					<?php endif ?>
				</li>
			<?php endforeach ?>
		</ul>

		<div class="row">
			<div class="col-md-2">
				<div class="mt-3 text-uppercase font-weight-bold d-flex justify-content-between">
					<?php echo $category->name ?>
					<?php if ($_SERVER['QUERY_STRING']): ?>
					<a href="<?= current_url() ?>" class="badge badge-danger">
						<i class="fa fa-redo" aria-hidden="true" title="reset all filters"></i>
					</a>
					<?php endif ?>
				</div>
				<hr class="my-2">
				<?php if ($category->sub_categories): ?>
					<div class="filter-container">
						<ul class="nav nav-pills flex-column">
							<?php foreach ($category->sub_categories as $row): ?>
								<li class="nav-item">
									<?php echo anchor('category/'.$row->slug.'/'.$row->name, $row->name, 'class="nav-link pl-0 py-1"') ?>
								</li>
							<?php endforeach ?>
						</ul>
					</div>
				<?php endif ?>
		
				<?php // Show Attributes as Filter Options ?>
				<?php foreach ($category->attributes as $index => $attribute): ?>
				<div class="text-muted mt-2"><?php echo $attribute->name ?></div>
				<hr class="my-2">
				<?php
				foreach ($attribute->descriptions as $key => $description):
				$attr_link = (current_url().'?'.($this->input->get('ATB') ? preg_replace('/(^|&)ATB=[^&]*/', '&ATB='.$description->id, $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&ATB='.$description->id));
				?>
				<a href="<?php echo $attr_link ?>" class="d-block text-muted">
					<div class="mb-1 custom-control custom-checkbox" style="position:relative;z-index:-1;">
						<input type="checkbox" class="custom-control-input" id="<?php echo 'desc_'.$description->id ?>" name="same_address" value="1" <?php echo ($this->input->get('ATB') == $description->id) ? 'checked' : '' ?>>
						<label class="custom-control-label" for="<?php echo 'desc_'.$description->id ?>"><?php echo $description->name ?></label>
					</div>
				</a>
				<?php endforeach ?>
				<?php endforeach ?>

				<div class="text-muted mt-4	d-flex justify-content-between">
					<span>Price</span>
					<span><?php echo $this->flexi_cart->currency_symbol() ?> <output id="rangeDsply"><?php echo $price_range ?></output></span>
				</div>
				<hr class="my-2">
				<?php echo form_open(current_url().'?'.$_SERVER['QUERY_STRING']) ?>
					<div class="form-group block-range">
						<div class="input-group">
							<input
							 id="customRange1"
							 class="custom-range"
							 type="range"
							 name="price"
							 min="<?php echo $min_price ?>"
							 max="<?php echo $max_price ?>"
							 value="<?php echo $price_range ?>"
							 onchange="rangeDsply.value=value"
							 oninput="rangeDsply.value=value"
							>
						</div>
					</div>

					<div class="form-group">
						<input type="submit" name="price_range" class="btn btn-sm btn-primary btn-block" id="rangeSubmit" value="Sort Price"/>
					</div>
				<?php echo form_close() ?>
			</div>
			<div class="col-md-10">
				<ul class="nav nav-pills d-flex justify-content-end">
					<li class="nav-item">
						<a class="nav-link text-muted pr-0">Sort By:</a>
					</li>
					
					<li class="nav-item dropdown <?php echo $this->input->get('order') ? 'active' : '' ?>">
						<a href="#" class=" nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							Trending <span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li class="dropdown-item" role="presentation" class="<?= ($this->input->get('order') === 'latest') ? 'active' : '' ?>">
								<?= anchor(current_url().'?'.($this->input->get('order') ? preg_replace('/(^|&)order=[^&]*/', '&order=latest', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'].'&order=latest'), 'Latest Products' ) ?>
							</li>
							<li class="dropdown-item" role="presentation" class="<?= ($this->input->get('order') === 'lowpx') ? 'active' : '' ?>">
								<?php
								// Remove price range query option not to collide with price ordering
								$nopx_link = ($this->input->get('price') ? preg_replace('/(^|&)price=[^&]*/', '', $_SERVER['QUERY_STRING']) : $_SERVER['QUERY_STRING'])
								?>
								<?= anchor(current_url().'?'.($this->input->get('order') ? preg_replace('/(^|&)order=[^&]*/', '&order=lowpx', $nopx_link) : $nopx_link.'&order=lowpx'), 'Lowest Prices' ) ?>
							</li>
							<li class="dropdown-item" role="presentation" class="<?= ($this->input->get('order') === 'hghpx') ? 'active' : '' ?>">
								<?php $lowpx_link = '' ?>
								<?= anchor(current_url().'?'.($this->input->get('order') ? preg_replace('/(^|&)order=[^&]*/', '&order=hghpx', $nopx_link) : $nopx_link.'&order=hghpx'), 'Highest Prices' ) ?>
							</li>
						</ul>
					</li>
				</ul>

				<?php if ( ! $products): // NO items found. Because user's sorting options returned Nothing. ?>
					<div class="my-4 text-muted">
						We could not find anything based on your sorting options. Please try again or <?= anchor(current_url().'?'.($this->input->get('cate') ? '&cate='.$this->input->get('cate') : '').'&reset=true', 'Reset Filters', 'class="alert-link"') ?>.
					</div>
				<?php else: ?>
					<?php $this->load->view('public/products/products_tiles_view', array(
						'type' => 'tiles',
						'cols' => 'col-xs-6 col-sm-3 col-md-3',
						'products' => $products,
					)) ?>
					<?php echo $this->pagination->create_links() ?>
				<?php endif ?>
			</div>
		</div>
	<?php endif ?>
</div>

<?php $this->load->view('admin/templates/footer') ?>