<?php $this->load->view('public/templates/header', array(
	'title' => 'Cart',
	'link' => 'cart'
)) ?>

<div class="container">
	<!-- <div class="py-4 bg-success text-white text-center">
		<h2>Checkout</h2>
		<p class="lead">Payment Complete</p>
	</div> -->
	<hr>
	<div class="py-4 text-center">
		<h2 class="text-success text-uppercase h4">Payment Complete</h2>
		<h1 class="text-success my-3"><i class="fa fa-check-circle"></i></h1>
		<p class="lead"></p>
		
		
		<div class="text-success mb-2">
			The payment has been processed successfully!
		</div>
		<b>Reference:</b>
		<?php if ($user): ?>
			<?php echo anchor('user_dashboard/orders/'.$order_number, $order_number) ?>
		<?php else: ?>
			<?php echo $order_number ?>
		<?php endif ?>
		<div>
			<b>Amount paid:</b> <?php echo $order_amount ?>
		</div>

		<div class="text-muted my-3">
			Thank you for your business.
		</div>
	</div>

	<hr>

	<?php if ($products): ?>
		<h4 class="lead mb-4">
			Continue shopping
		</h4>
		<?php $this->load->view('public/products/products_tiles_view', array(
			'type' => 'tiles',
			'cols' => 'col-xs-6 col-sm-4 col-md-3 col-lg-2-5',
			'products' => $products,
		)) ?>
	<?php endif ?>
</div>
<?php $this->load->view('public/templates/footer') ?>