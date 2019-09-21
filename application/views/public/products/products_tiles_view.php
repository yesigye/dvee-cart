<?php $this->load->helper('text') ?>

<div class="row">
	<?php foreach ($products as $key => $product): ?>
		<div class="<?php echo $cols ?>">
			<div class="card small mb-4">
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
								<a href="<?php echo site_url('product/'.$product->slug) ?>" type="button" class="btn btn-sm btn-outline-secondary">View</a>
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
		</div>
	<?php endforeach ?>
</div>

<?php if (isset($this->pagination)): ?>
	<!-- Pagination Link -->
	<?php echo $this->pagination->create_links() ?>
<?php endif ?>
