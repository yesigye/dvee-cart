
<ul class="nav nav-tabs horizontal-scroll" role="tablist" style="margin-bottom: 2rem">
    <a
     class="nav-item nav-link <?php echo ($active == 'details') ? 'active' : '' ?>"
     href="<?php echo site_url('admin/update_item/'.$id) ?>"
    >
        Details
    </a>
    <a
     class="nav-item nav-link <?php echo ($active == 'attributes') ? 'active' : '' ?>"
     href="<?php echo site_url('admin/update_item_attributes/'.$id) ?>"
    >
        Attributes
    </a>
    <a
     class="nav-item nav-link <?php echo ($active == 'options') ? 'active' : '' ?>"
     href="<?php echo site_url('admin/update_item_options/'.$id) ?>"
    >
        Options
    </a>
    <a
     class="nav-item nav-link <?php echo ($active == 'images') ? 'active' : '' ?>"
     href="<?php echo site_url('admin/update_item_images/'.$id) ?>"
    >
        Images
    </a>
    <a
     class="nav-item nav-link <?php echo ($active == 'tax') ? 'active' : '' ?>"
     href="<?php echo site_url('admin/update_item_tax/'.$id) ?>"
    >
        Tax
    </a>
    <a
     class="nav-item nav-link <?php echo ($active == 'shipping') ? 'active' : '' ?>"
     href="<?php echo site_url('admin/update_item_shipping/'.$id) ?>">
        Shipping
    </a>
</ul>