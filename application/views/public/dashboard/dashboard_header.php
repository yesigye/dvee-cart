<div class="container">
    <div class="row">
        <div class="col-md-3">
            <nav class="list-group horizontal-scroll-alt flex-column mb-3">
                <div class="list-group-item list-group-item-dark text-uppercase font-weight-bold">
                    Dashboard
                </div>
                <a class="list-group-item list-group-item-action scroll-item <?php if($active=="profile") echo 'active' ?>" href="<?php echo site_url('profile') ?>" >
                    Profile
                </a>
                <a class="list-group-item list-group-item-action scroll-item <?php if($active=="orders") echo 'active' ?>" href="<?php echo site_url('user_dashboard/orders') ?>">
                    My Orders
                </a>
                <a class="list-group-item list-group-item-action scroll-item <?php if($active=="carts") echo 'active' ?>" href="<?php echo site_url('user_dashboard/carts') ?>">
                    Saved Carts
                </a>
                <a class="list-group-item list-group-item-action scroll-item <?php if($active=="points") echo 'active' ?>" href="<?php echo site_url('user_dashboard/points_vouchers') ?>">
                    Points & Vouchers   
                </a>
            </nav>
        </div>
        <div class="col-md-9">