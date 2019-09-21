<?php $this->load->view('public/templates/header', array(
	'title' => 'Cart',
	'link' => 'cart'
)) ?>

<ul class="breadcrumb">
	<li>
		<?php echo anchor('cart', 'Shopping Cart') ?>
	</li>
	<li>Checkout</li>
</ul>

<h2 class="lead text-center text-warning">Order Cancelled</h2>

<div class="alert alert-warning">
    The payment has not been processed at this point because you cancelled the payment.
    <?php echo anchor('cart', 'Return') ?>
</div>

<?php if ($products): ?>
	<h4 class="page-header">
	    You may like
	</h4>
	<?php $this->load->view('public/products/products_tiles_view', array(
		'type' => 'tiles',
		'cols' => 'col-xs-6 col-sm-4 col-md-3 col-lg-2-5',
		'products' => $products,
	)) ?>
<?php endif ?>

<?php $this->load->view('public/templates/footer') ?>