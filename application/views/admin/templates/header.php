<!DOCTYPE html>
<html>
<head>
    <?php
        $this->load->library('app');
        $app = $this->app->owner();

        // Defaults links.
        if (! isset($require)) $require = NULL; 
        if ( ! isset($title)) $title = 'Admin Dashboard';
        if ( ! isset($link)) $link = false;
        if ( ! isset($sub_link)) $sub_link = false;
        if ( ! isset($breadcrumbs)) $breadcrumbs = array();
    ?>
    <title><?php echo $title ?></title>
    <link rel="shortcut icon" href="<?php echo $app->logo ?>" type="image/png" />
    <link rel="shortcut icon" href="<?php echo $app->logo ?>" type="image/png" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jasny-bootstrap.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/styles.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/cropper.min.css') ?>" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ"
    crossorigin="anonymous">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
</head>

<body id="admin_dashboard"  <?= (isset($affix)) ? 'data-spy="scroll" data-target="'.$affix['target'].'" data-offset="'.$affix['offset'].'"' : '' ?>>
    <script>
        // Hide content onload, prevents JS flicker
        document.body.className += ' js-enabled';
    </script>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="<?php echo site_url('admin') ?>"> <?php echo $app->name ?> </a>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item <?php if($link=='users') echo 'active' ?>">
                        <a class="nav-link" href="<?php echo site_url('admin/users') ?>">
                            Users
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Catalog
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <div class="dropdown-item text-muted"> <i class="fa fa-shopping-cart mr-2"></i> Products </div>
                            <a class="dropdown-item <?php if($link == 'items' && !$sub_link) echo 'active' ?>" href="<?echo site_url('admin/items') ?>">Manage products</a>
                            <a class="dropdown-item <?php if($link == 'items' && $sub_link == 'add') echo 'active' ?>" href="#">Add a new product</a>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-item text-muted"> <i class="fa fa-th-list mr-2"></i> Categories </div>
                            <a class="dropdown-item <?php if($link == 'items' && $sub_link == 'categories') echo 'active' ?>" href="<?echo site_url('admin/categories') ?>">Manage categories</a>
                            <a class="dropdown-item <?php if($link == 'items' && $sub_link == 'add_category') echo 'active' ?>" href="<?echo site_url('admin/categories/insert_category') ?>">Add a new category</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php if($link == 'orders' || $link == 'zones' || $link == 'locations') echo 'active' ?>">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sales
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <div class="dropdown-item text-muted"> <i class="fa fa-briefcase mr-2"></i> Orders </div>
                            <a class="dropdown-item <?php if($link == 'orders' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/orders') ?>">Manage orders</a>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-item text-muted"> <i class="fa fa-shipping-fast mr-2"></i> Shipping </div>
                            <a class="dropdown-item <?php if($link == 'locations' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/location_types') ?>">Manage locations</a>
                            <a class="dropdown-item <?php if($link == 'zones' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/zone') ?>">Location Zones</a>
                            <a class="dropdown-item <?php if($link == 'shipping' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/shipping') ?>">Manage shipping rules</a>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-item text-muted"> <i class="fa fa-money-bill mr-2"></i> Taxes </div>
                            <a class="dropdown-item <?php if($link == 'tax' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/tax') ?>">Manage taxes</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php if($link == 'discounts' || $link == 'reward_points') echo 'active' ?>">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Promotions
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <div class="dropdown-item text-muted"> <i class="fa fa-tags mr-2"></i> Discounts </div>
                            <a class="dropdown-item <?php if($link == 'discounts' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/item_discounts') ?>">Item discounts</a>
                            <a class="dropdown-item <?php if($link == 'discounts' && $sub_link == 'groups') echo 'active' ?>" href="<?php echo site_url('admin/discount_groups') ?>">Discounts groups</a>
                            <a class="dropdown-item <?php if($link == 'discounts' && $sub_link == 'summary') echo 'active' ?>" href="<?php echo site_url('admin/summary_discounts') ?>">Summary discounts</a>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-item text-muted"> <i class="fa fa-gift mr-2"></i> Vouchers </div>
                            <a class="dropdown-item <?php if($link == 'reward_points' && !$sub_link) echo 'active' ?>" href="<?php echo site_url('admin/user_reward_points') ?>">User Reward Points</a>
                            <a class="dropdown-item <?php if($link == 'reward_points' && $sub_link == 'vouchers') echo 'active' ?>" href="<?php echo site_url('admin/vouchers') ?>">User Reward Vouchers</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown <?php if($link == 'extras') echo 'active' ?>">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Frontend
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item <?php if($link == 'extras' && $sub_link == 'pages') echo 'active' ?>" href="<?php echo site_url('admin/pages') ?>">Manage pages</a>
                            <a class="dropdown-item <?php if($link == 'extras' && $sub_link == 'banners') echo 'active' ?>" href="<?php echo site_url('admin/banners') ?>">Manage banners</a>
                        </div>
                    </li>
                </ul>
                
                <ul class="navbar-nav ml-auto d-flex nav-icons">
                    <li class="nav-item dropdown <?php if($link == 'settings') echo 'active' ?>">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Settings
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item <?php if($link == 'settings' && $sub_link == 'config') echo 'active' ?>" href="<?php echo site_url('admin/config') ?>">Cart settings</a>
                            <a class="dropdown-item <?php if($link == 'settings' && $sub_link == 'defaults') echo 'active' ?>" href="<?php echo site_url('admin/defaults') ?>">Cart defaults</a>
                            <a class="dropdown-item <?php if($link == 'settings' && $sub_link == 'currency') echo 'active' ?>" href="<?php echo site_url('admin/currency') ?>">Manage currencies</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="<?php echo site_url('admin/logout') ?>">
                            <i class="fa fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" id="body_wrap">

        <?php // Breadcrumbs for admin pages ?>
        <ol class="breadcrumb mt-2">
            <li class="breadcrumb-item"><?= anchor('admin', 'Dashboard') ?></li>
            <?php foreach ($breadcrumbs as $nav): ?>
                <li class="breadcrumb-item">
                    <?= ($nav['link']) ? anchor('admin/'.$nav['link'], $nav['name']) : $nav['name'] ?>
                </li>
            <?php endforeach ?>
        </ol>

        <!-- Ajax alerts -->
        <div class="modal fade" id="ajax-alert-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content alert alert-warning" style="padding:0">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div id="message"></div>
                    </div>
                </div>
            </div>
        </div>

        <?php // Toast alert users to errors, changes and notifications ?>
        <div aria-live="polite" aria-atomic="true" style="position: relative;">
            <div id="toast-container" style="position: fixed; top: 1rem; right: 1rem; z-index:1000;">
                <?php if (validation_errors()): ?>
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                        <div class="toast-body bg-danger text-white">
                            Check the form for errors and try again.
                            <button type="button" class="ml-2 close" data-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if (! empty($message)): ?>
                        <div id="message"> <?php echo $message ?> </div>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </div>
        <?php // End of Alerts ?>