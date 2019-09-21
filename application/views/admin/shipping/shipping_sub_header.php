<ul class="nav nav-tabs" role="tablist" style="margin-bottom:3rem">
    <a
     role="presentation"
     href="<?php echo site_url('admin/shipping') ?>"
     class="nav-item nav-link <?php echo ($this->uri->segment(2) === 'shipping' OR $this->uri->segment(2) === 'shipping_rates' OR $this->uri->segment(2) === 'insert_shipping_rate') ? 'active' : '' ?>">
        Manage Shipping Options
    </a>
    <a
     role="presentation"
     href="<?php echo site_url('admin/insert_shipping') ?>"
     class="nav-item nav-link <?php echo ($this->uri->segment(2) === 'insert_shipping') ? 'active' : '' ?>">
        Add Shipping Options
    </a>
    <a
     role="presentation"
     href="<?php echo site_url('admin/tax') ?>"
     class="nav-item nav-link <?php echo ($this->uri->segment(2) === 'tax') ? 'active' : '' ?>">
        Manage Taxes
    </a>
    <a
     role="presentation"
     href="<?php echo site_url('admin/insert_tax') ?>"
     class="nav-item nav-link <?php echo ($this->uri->segment(2) === 'insert_tax') ? 'active' : '' ?>">
        Add Tax
    </a>
</ul>