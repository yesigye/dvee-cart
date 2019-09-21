<?php if ($cart_data['items']): ?>
    <div class="p-2 text-muted text-right"><?php echo $this->flexi_cart->item_summary_total() ?></div>
    <div class="px-2 pb-2 text-truncate small m-0" style="width:250px">
        <?php foreach ($cart_data['items'] as $key => $row): ?>
        <?php echo $row['name'] ?>
        <div class="text-muted">
            <?php echo $this->flexi_cart->get_currency_value($row['internal_price']) ?>
        </div>
        <?php endforeach ?>
    </div>
<?php else: ?>
    <div class="px-2 py-3 text-muted">Your cart is empty</div>
<?php endif ?>
<a href="<?php echo site_url('cart') ?>" class="btn btn-sm btn-block btn-primary rounded-0" style="margin-top:5px">
    view cart
</a>