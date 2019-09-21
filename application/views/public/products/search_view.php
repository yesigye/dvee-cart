<?php $this->load->view('public/templates/header', array(
	'title' => 'Search Results',
	'link' => 'search',
)); ?>

<div class="container">
	<?php
	// No Items returned - and the user was not filtering
	if ( ! $products AND ! $_SERVER['QUERY_STRING']):
	?>
		<div class="alert alert-warning">There are no products on sale yet.</div>
	<?php else: ?>
		<ul class="breadcrumb">
			<li class="breadcrumb-item">Search</li>
			<li class="breadcrumb-item"><?php echo $this->input->get('q') ?></li>
		</ul>

		<div class="row">
			<div class="col-md-12">
				<div class="lead mb-3">
					Search Results for <code><?php echo $this->input->get('q') ?></code>
				</div>
				<ul class="nav nav-pills d-flex justify-content-end">
					<li class="nav-item">
						<a class="nav-link text-muted pr-0">Sort By:</a>
					</li>
					
					<li class="nav-item dropdown <?php echo $this->input->get('order') ? 'active' : '' ?>">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
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
					<?php if (preg_replace('/(^|&)q=[^&]*/', '', $_SERVER['QUERY_STRING'])): ?>
						<li>
							<?php echo form_open('search', 'method="GET" style="padding:10px"') ?>
								<?php echo form_hidden('q', $this->input->get('q')) ?>
								<button type="submit" class="empty text-danger">Reset Filters</button>
							<?php echo form_close() ?>
						</li>
					<?php endif ?>
				</ul>

				<?php if ( ! $products): // NO items found. Because user's sorting options returned Nothing. ?>
					<div class="alert alert-warning">
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