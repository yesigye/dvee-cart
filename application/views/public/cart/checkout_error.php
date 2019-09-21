<?php $this->load->view('public/templates/header', array(
    'title' => 'Cart',
    'link' => 'cart'
)) ?>

<ul class="breadcrumb">
    <li>
        <?php echo anchor('cart', 'Shopping Cart') ?>
    </li>
    <li class="active">Checkout</li>
</ul>

<div class="lead text-center text-danger">Checkout Failed</div>

<div class="panel panel-danger">
    <div class="panel-heading">Errors were encountered during checkout.</div>
    <div class="panel-body text-danger">
        <?php foreach ($errors as $error): ?>
            <p>
                <strong>CODE <?php echo $error[0]['L_ERRORCODE'] ?>:</strong>
                <?php echo $error[0]['L_LONGMESSAGE'] ?>
            </p>
        <?php endforeach ?>
    </div>
</div>

<?php if ($products): ?>
    <h4 class="page-header">
        Continue Shopping
    </h4>
    <?php $this->load->view('public/products/products_tiles_view', array(
        'type' => 'tiles',
        'cols' => 'col-xs-6 col-sm-4 col-md-3 col-lg-2-5',
        'products' => $products,
    )) ?>
<?php endif ?>

<?php $this->load->view('public/templates/footer') ?>