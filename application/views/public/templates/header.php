
<?php
$cart_data = $this->flexi_cart->cart_contents();

if ( ! isset($require)) $require = NULL; 
if ( ! isset($title)) $title = false;
if ( ! isset($title_description)) $title_description = false;
if ( ! isset($link)) $link = false;
if ( ! isset($sub_link)) $sub_link = false;

?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $owner->name.($link ? ' - '.$title : '') ?></title>
    <link rel="shortcut icon" href="<?= base_url($this->store->owner()->logo) ?>" type="image/png" />
    <link rel="shortcut icon" href="<?= base_url($this->store->owner()->logo) ?>" type="image/png" />
    <meta charset="utf-8">
    <meta name="description" content="Best products for online shopping."> 
    <meta name="keywords" content="e-commerce, online shopping, dvee cart, shopping cart, codeigniter">
    <meta name="robots" content="index, follow">
    <meta name="designer" content="code47 - Yesigye Ignatius : ignatiusyesigye@gmail.com"> 
    <meta name="copyright" content="Copyright © <?php echo date('Y').', '.$owner->name ?>, All Rights Reserved">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jasny-bootstrap.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/cropper.min.css') ?>" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ"
    crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/styles.css') ?>" />
    <script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-1">
        <div class="container">
            <button class="navbar-toggler mr-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <a class="navbar-brand text-center mr-auto" href="<?php echo site_url() ?>">
                <img alt="Brand" src="<?php echo base_url($owner->logo) ?>">
                <div class="text-muted small"> <?php echo $owner->name ?> </div>
            </a>

            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php echo form_open('search', 'method="GET" class="mx-auto"') ?>
                    <div class="input-group">
                        <input type="text" name="q" class="form-control form-control-lg border-0" placeholder="Search keywords" value="">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-lg bg-white border-0">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                <?php echo form_close() ?>
                
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?php if($link == 'physicians') echo 'active' ?>">
                        <a class="nav-link" href="<?php echo site_url('doctors') ?>"><?php echo lang('menu_doctors') ?></a>
                    </li>
                    <li class="nav-item <?php if($link == 'hospitals') echo 'active' ?>">
                        <a class="nav-link" href="<?php echo site_url('hospitals') ?>"><?php echo lang('menu_hospitals') ?></a>
                    </li>
                </ul>   
            </div>
            
            <ul class="nav">
                <?php if ($user): ?>
                    <li class="nav-item dropdown <?php echo ($link === 'account') ? 'active' : '' ?>">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php if (is_file($user->avatar)): ?>
                                <img src="<?= base_url($user->avatar) ?>" alt=""
                                style="width:18px;border-radius:2px;">
                            <?php else: ?>
                            <span class="fa fa-user"></span>
                            <?php endif ?>
                            <?= $user->username ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu pb-0">
                            <a class="dropdown-item" href="<?php echo site_url('user_dashboard') ?>"> Dashboard </a>
                            <a class="dropdown-item" href="<?php echo site_url('cart') ?>"> My Cart </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo site_url('profile') ?>"> My Profile </a>
                            <a class="dropdown-item bg-danger text-white" href="<?php echo site_url('logout') ?>"> Logout </a>
                        </ul>
                    </li>
                <?php else: ?>
                    <a href="<?= site_url('login') ?>" class="btn btn-sm btn-outline-primary py-2 my-3 my-sm-0 mx-3">
                        <i class="fa fa-user mr-1"></i> Login
                    </a>
                    <li role="presentation" class="nav-item">
                        <a class="nav-link  <?php echo ($link === 'register') ? 'active' : '' ?>" href="<?php echo site_url('register') ?>">Register</a>
                    </li>
                <?php endif ?>

                <?php
                // Admin has setup various currencies
                if ($this->flexi_cart->get_currency_data()):
                ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo $this->flexi_cart->currency_name() ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($this->flexi_cart->get_currency_data() as $currency): ?>
                                <?php $redirect = ($_SERVER['QUERY_STRING'] !== '') ? '?'.$_SERVER['QUERY_STRING'] : '' ?>
                                <a
                                class="dropdown-item <?php echo ($this->flexi_cart->currency_name() == $currency['curr_name']) ? 'active' : '' ?>"
                                href="<?php echo site_url('cart/set_currency'.'?currency='.$currency['curr_name'].'&redirect='.current_url().$redirect) ?>">
                                    <?php echo $currency['curr_name'] ?>
                                </a>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php
                else:
                // No setup currencies, use defaults.
                ?>
                    <li role="presentation" class="disabled"><a href="#"><?php echo $this->flexi_cart->currency_name() ?></a></li>
                <?php endif ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo ($link === 'cart') ? 'active' : '' ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-shopping-cart"></span>
                        <span class="label <?php echo (0>1) ? 'label-success' : 'label-default' ?>" id="cart-item-no"><?php echo $cart_data['summary']['total_rows'] ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" style="padding:1px;" id="mini-cart">
                        <?php $this->load->view('public/cart/cart_data', array(
                            'cart_data' => $cart_data
                        )) ?>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container border-top horizontal-scroll d-flex justify-content-between">
        <ul class="nav py-2 scroll-item">
            <?php foreach ($this->store->menu() as $item): ?>
                <a
                 class="nav-item nav-link <?= ($link == $item->slug) ? 'text-primary' : 'text-muted' ?>"
                 href="<?php echo site_url('category/'.$item->slug.'/'.url_title($item->name)) ?>"
                >
                    <?php echo $item->name ?>
                </a>
            <?php endforeach ?>
        </ul>

        <ul class="nav py-2 scroll-item">
            <?php foreach ($this->store->pages() as $item): ?>
                <a
                 class="nav-item nav-link <?= ($link == $item->slug) ? 'text-primary' : 'text-muted' ?>"
                 href="<?php echo site_url('page/'.$item->slug) ?>"
                >
                    <?php echo $item->name ?>
                </a>
            <?php endforeach ?>
        </ul>
    </div>

    <div class="" id="body">

        <?php // Breadcrumbs for pages ?>
        <?php if (!isset($breadcrumbs)) $breadcrumbs = array(); ?>
        <?php if ($breadcrumbs): ?>
        <div class="container">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumbs as $nav): ?>
                <li class="breadcrumb-item <?php echo ($nav['link']) ? '' : 'active' ?>">
                    <?php echo ($nav['link']) ? anchor($nav['link'], $nav['name']) : $nav['name'] ?>
                </li>
                <?php endforeach ?>
            </ol>
        </div>
        <?php endif ?>
        <?php // End of breadcrumbs ?>


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