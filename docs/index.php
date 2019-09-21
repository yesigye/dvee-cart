<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dvee Docs</title>

    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/jasny-bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css" />
    <script type="text/javascript" src="../assets/js/jquery.js"></script>
    <script type="text/javascript" src="../assets/js/popper.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
	<style>
		html, body {
			font-family: 'Roboto', sans-serif;
			font-size: 16px;
			font-weight: 400;
			height: 100%;
		}
		h1, h2, h3, h4, h5 {
			font-weight: 300;
		}
		#introduction {
			padding-top: 10rem;
			min-height: 100%;
			line-height: 2;
		}
		.lead, .page-header {
			color: #a94442;
			margin-top: 20px;
		}
		.lead {
			margin-top: 40px;
		}
		.page-header {
			margin-bottom: 20px;
			font-weight: 400;
			font-size: 20px;
			border:0;
		}

		@media (min-width: 768px) {
			.page-header {
				font-size: 30px;
			}
		}
	</style>
</head>

<?php
$currentUrl = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$baseUrl = substr($currentUrl, 0, strpos( $currentUrl, '/docs'));
?>

<body class="navoffset" data-spy="scroll" data-target="#navbar">
    <div id="navbar" class="navmenu bg-dark text-white navmenu-fixed-left offcanvas-sm">
		<h3 class="text-center mt-4">DVEE DOCS</h3>
		<p class="text-center small">USER GUIDE</p>

		<div class="nav flex-column">
			<a class="nav-item nav-link" href="#installation">Installation</a>
            <div class="dropdown">
                <a href="#" class="nav-item nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Catalog
                </a>
                <div class="dropdown-menu">
					<a class="dropdown-item" href="#item-category">Categories</a>
					<a class="dropdown-item" href="#item-attributes">Attributes</a>
					<a class="dropdown-item" href="#add-items">Adding Products</a>
					<a class="dropdown-item" href="#edit-items">Editing Products</a>
				</div>
            </div>
			<div class="dropdown">
                <a href="#" class="nav-item nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					Sales
                </a>
                <div class="dropdown-menu">
					<a class="nav-item nav-link" href="#orders">Managing Orders</a>
					<a class="nav-item nav-link" href="#order-statuses">Order Statuses</a>
					<a class="nav-item nav-link" href="#locations">Managing Locations</a>
					<a class="nav-item nav-link" href="#location-types">Location Types</a>
					<a class="nav-item nav-link" href="#location-zones">Location Zones</a>
					<a class="nav-item nav-link" href="#shipping-options">Managing Shipping Options</a>
					<a class="nav-item nav-link" href="#taxes">Managing Taexs</a>
				</div>
			</div>
			<div class="dropdown">
                <a href="#" class="nav-item nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Promotions
                </a>
                <div class="dropdown-menu">
					<a class="nav-item nav-link" href="#discounts">Discounts</a>
					<a class="nav-item nav-link" href="#reward-points">Reward Points & vouchers</a>
				</div>
			</div>
			<div class="dropdown">
                <a href="#" class="nav-item nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Store Front
                </a>
                <div class="dropdown-menu">
					<a class="nav-item nav-link" href="#pages">Managing Pages</a>
					<a class="nav-item nav-link" href="#banners">Managing Banners</a>
				</div>
			</div>
			<a class="nav-item nav-link" href="#settings">Settings</a>
			<a class="nav-item nav-link" href="#paypal">PayPal</a>
		</div>
    </div>

	<nav id="navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button class="navbar-toggle" type="button" data-toggle="offset" data-target="#navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Dvee Docs</a>
			</div>
			<div class="collapse navbar-collapse bs-example-js-navbar-scrollspy">
				<ul class="nav navbar-nav navbar-right">
					<li class="">
						<a href="../">Frontend</a>
					</li>
					<li class="">
						<a href="../admin">Dashboard</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">

		<div class="alert alert-info" style="margin-top:80px;">
			Alot of information has been documented throughout the app. This information may not be included here because it was too specific for a
			form field or any other feature.
			The sign <span class="glyphicon glyphicon-info-sign"></span> has been attached to elements that contain extra information.
			Hover over them to toggle the info snippets.
		</div>

		<!-- INSTALLATION -->
		<div class="container" style="padding-top:80px;" id="installation">

			<div class="page-header">Installing the app on your server</div>

			<div>
				<ol>
					<li>
						Unzip the file into your server web directory usually the www, http or the public folder.
						<br><br>
					</li>
					<li>
						Edit the config file at application/config/config.php and change the base url from <br>
						<code class="text-danger">$config['base_url'] = "http://localhost/dvee/"</code> <br>
						to your domain <br>
						<code class="text-success">$config['base_url'] = "http://yoursite.com/"</code>
						<br><br>
					</li>
					<li>
						Edit the .htaccess file at root of your app installation and change mod_rewrite rule from <br>
						<code class="text-danger">RewriteBase /dvee/</code> <br>
						to the name of your directory (assuming your directory name is "myapp") <br>
						<code class="text-success">RewriteBase /myapp/</code> <br>
						or if your app will reside in a sub-directory (assuming your root directory name is "apps")  <br>
						<code class="text-success">RewriteBase /apps/myapp/</code> <br>
						if your app is installed in the root directory <br>
						<code class="text-success">RewriteBase /</code>
						<br><br>
					</li>
					<li>
						Next, Change the database config settings.<br>
						Edit database file at <b>application/config/database.php</b> with a text editor and edit the database variables.
						<br><br>
					</li>
					<li>
						Finally, Install the database. <br>
						To automatically install the database,
						<a href="../migrate"
						onclick="window.open('../migrate', '_blank', 'width=400,height=300,scrollbars=yes,menubar=no,status=yes,resizable=yes,screenx=0,screeny=0'); return false;">
							Follow this click
						</a>
						<br>
						To maunally install the database, use the <b>demo_cart.sql</b>
						sql file provided at the root of this installation.
						<br><br>
					</li>
				</ol>
				Done. You are now ready!
			</div>
		</div>
		<!-- END OF INSTALLATION -->
		
		<!-- CATALOG -->
		<div class="container" style="padding-top:80px;" id="items">

			<div class="page-header">Catalog</div>
			<p>
				The Product manager takes care of your inventory. The cart has features for logging, tracking and categorizing your invetory.
				Here you will add, update and manage infinite product categories, product options, attributes, images, tax, shipping and more.
			</p>
			
			<div style="padding-top:80px;" id="item-category">
				<div class="lead">Product Categories</div>
				<p>
					Categories mainly differentiate your items. They are used by the system's searching,
					filtering and sorting functions while customers browser your website.
					The main categories will appear as links in the header of your product pages, so keep them short and definitive.
					<br>
					A category may have unlimited teirs; this means a category may have a sub-category and that sub-category may have its
					own sub-category and so on.
				</p>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-9 center-block" style="float:initial;margin-top:5%">
						<img src="images/admin_categories.png" alt="" class="thumbnail img-responsive">
					</div>
				</div>
			</div>
			<div style="padding-top:80px;" id="item-attributes">
				<div class="lead">Category Attributes</div>
				<p>
					A category may have one or more attributes. Attributes describe the characteristics of an item.
					They help to differentiate items in the same category. A category's attributes will also be applied to its sub-categories.
					Attributes can be defined at any tier in the category. However lower tiers will inherit attributes that belong to a higher tier.
				</p>
				<p>
					Consinder this category tier;
					<ol class="breadcrumb">
						<li class="breadcrumb-item">women</li>
						<li class="breadcrumb-item">clothing</li>
						<li class="breadcrumb-item">shoes</li>
					</ol>
					The category <code>clothing</code> may have attributes like <mark>size</mark>, <mark>color</mark>.
					These attributes will also be applied to the lower tier category <code>shoes</code>.
					This is because we expect all clothing to have a size and a color.
					However <code>shoes</code> may also have its own attributes like <mark>heel type</mark>
					since not all <code>clothing</code> have heels but all <code>shoes</code> have heels.
					This means that <code>shoes</code> will now have attributes <mark>size</mark>, <mark>color</mark>, <mark>heel type</mark>.
				</p>
				<p>
					Attributes can also be used as product options to create a product variation.
				</p>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-9 center-block" style="float:initial;margin-top:5%">
						<img src="images/admin_attributes.png" alt="" class="thumbnail img-responsive">
					</div>
				</div>
			</div>

			<div style="padding-top:80px;" id="add-items">
				<div class="lead">Adding Products</div>
				<p>
					Before you start adding items, you may want to <a href="#add-category">add item categories</a> that your item will belong to. <br>
					Adding a new item requires you to enter a few basic item details, however we recommend that you add additional information about
					the product by adding images, categorising the product and defining it attributes. You can also add tax rates and shipping rules
					for each individual item. <br> 
				</p>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-8 center-block" style="float:initial;margin-top:5%">
						<img src="images/admin_items_add.png" alt="" class="thumbnail img-responsive">
					</div>
				</div>
			</div>

			<div class="lead">Adding Product Variations</div>
			<p>
				Different product options can be combined to create product variates of the same product. These product variations may have a price or
				weight value that is different that the original item. When a user choose a combination of options that make up a product variant, its price
				and weight will be used by the cart instead of the initial product price and weight.
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 center-block" style="margin-bottom:20px;float:initial;margin-top:5%">
					<img src="images/user_item_option.png" alt="" class="thumbnail img-responsive" style="margin:0">
					<span class="text-muted">This is an example of a product with a red dress variation.</span>
				</div>
			</div>
			Note that the price of our dress is &pound 5.00, if a user choose the red dress variation or chooses red as the color option, then the price will
			change from &pound 5.00 to &pound 6.00 as defined in your product variation settings.
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 center-block" style="margin-bottom:20px;float:initial;margin-top:10px">
					<img src="images/admin_item_option.png" alt="" class="thumbnail img-responsive" style="margin:0">
					<span class="text-muted">This is our red dress variation as seen from the admin interface.</span>
				</div>
			</div>

			<h4>Adding product variant field descriptions</h4>
			<div class="table-responsive">
				<table class="table table-flat table-striped">
					<thead>
						<tr class="bg-primary">
							<th>Field</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Item Options</th>
							<td>
								Product variations are created from attribute combinations after you create item attributes at the <a href="#item-category">categories level</a> <br>
								Whilst creating attributes, choose to use them as options. They will be available as possible combinations to make a single item variation.
							</td>
						</tr>
						<tr>
							<th>Price</th>
							<td>
								Price that is unique to the product variant
							</td>
						</tr>
						<tr>
							<th>Weight</th>
							<td>
								Weight that is unique to the product variant
							</td>
						</tr>
						<tr>
							<th>Images</th>
							<td>
								Upload field form images of the product variant. These images will be used to create a thumbnail
								which a user can click to quickly select the product variation without matching option combinations.
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="lead">Adding Product Images</div>
			<p>
				Product images are a visual representation of your product, therefore we recommend that you uplaod images that are as accurate as possible.
				These will be shown in a carousel at the product display page.
				The default upload limit is 5. You can change this in the <a href="#settings">Cart Settings</a>
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-5 center-block" style="float:initial;">
					<img src="images/admin_item_images.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>

			<div class="lead">Adding Tax Information</div>
			<p>
				Tax rates for individual items can be set with a different tax rate than what is currently being globally used by the cart.
				The tax rate for each item can also be set accordingly to a customers location tax zone (Tax zones are a collections of locations that share the same tax rate).
				Before adding tax rate, you must first define these locations and zones in <a href="#locations">Locations</a>.

			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 center-block" style="float:initial;">
					<img src="images/admin_item_tax.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>

			<div class="lead">Adding Shipping Rules</div>
			<p>
				Shipping rates and rules for individual items can be set that can either omit the item from being included in the cart shipping calculations, or add a shipping surcharge that will be applied on top of the standard shipping charge. 
				This allows specific items to have free shipping, whilst items with a higher insurance value could have a surcharge applied. These shipping rules can also be applied accordingly to a customers location 
				Items can also be set to be shipped separately from the rest of the cart items, this will then calculate the shipping charge for that specific item, and then recalculate the shipping charge for the rest of the cart items. 
				Additionally, items can be banned from being shipped to specific locations, by either 'whitelisting' or 'blacklisting' a location. 
				Whitelisting means the item can ONLY be shipped to that location, whilst blacklisting means it CANNOT be shipped to that location. 
				All sub-locations of a listed location will also be affected.
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 center-block" style="float:initial;">
					<img src="images/admin_item_ship.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>

			<div style="padding-top:80px;" id="edit-items">
				<div class="lead">Editing Items</div>
				<p>
					Editing products is similar to the process of creating them, you will only be changing the
					your items details, attributes and options, add manage image files or setup shipping and tax options.
				</p>

				<div class="lead">Batch Editing</div>
				<p>
					Batch editing is a dynamic feature that enable you to change values of multiple products or remove multiple products at once.
					This can be a huge time saver if you want to quickly edit items without having to load and view all the details.
				</p>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 center-block" style="float:initial;">
						<img src="images/admin_items.png" alt="" class="thumbnail img-responsive">
					</div>
				</div>
			</div>
		</div>
		<!-- END OF CATALOG -->

		<!-- END OF SALES -->
		<div class="container" style="padding-top:80px;" id="orders">
			<div class="page-header">Orders</div>
			<p>
				Orders are saved when a user successfully purchases an item through a payement gateway. Information on the cart details, shipping and billing
				iniformation and the customer contact and payment methods are captured. As the store admin, you will need to change the order status once the
				product has been delivered to the customer. The cart cannot do this automatically because there is no way of knowing if the product has been
				delivered or not. However, the cart allows you to customize order statuses so that they make sense to you.
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 center-block" style="float:initial;">
					<img src="images/order_details.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>

			<div class="lead" id="order-statuses">Order Statuses</div>
			<p>
				When managing the admin side of an e-commerce site, it is important for users to be aware of the current state of orders that have been placed.
				Internally the cart can check whether the status of an order is considered as 'active' or 'cancelled' and can then use this data to reallocate
				item stock levels and user reward points accordingly. Order Statuses can be managed from settings page.
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 center-block" style="float:initial;">
					<img src="images/order_statuses.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>
			<h4>Order Status Field Descriptions</h4>
			<div class="table-responsive">
				<table class="table table-flat table-striped">
					<thead>
						<tr class="bg-primary">
							<th>Field</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Description</th>
							<td>The name/description of the order status.</td>
						</tr>
						<tr>
							<th>Cancel Order</th>
							<td>If checked, it indicates that the order status 'Cancels' the order.</td>
						</tr>
						<tr>
							<th>Save Default</th>
							<td>If checked, it indicates that the order status is the default status that is applied to a 'saved' order.</td>
						</tr>
						<tr>
							<th>Resave Default</th>
							<td>If checked, it indicates that the order status is the default status that is applied to a 'resaved' order.</td>
						</tr>
					</tbody>
				</table>
			</div>


			<div class="page-header" style="padding-top:80px;" id="locations">Sales</div>

			<div class="lead">Managing Locations</div>
			<p>
				Locations are directly related as children to 'Location Types'. For each location type, an unlimited number of locations can be set.
				For example, a location type of 'Country' would list all countries that the cart is setup to do business with.
				Specific shipping, tax and discount rules can then be applied to these countries (If they differ from the carts default values).

				Each location can also be related to a higher tiered location, for example, a state location of 'New York' would be related to a country location of 'United States'. This enables a chaining method where all rules applied to the 'United States' are passed on to 'New York', but rules to 'New York' are not passed up to 'United States'.

				Sometimes a location may need to be grouped with other locations, but trying to relate them using the parent-to-child relationship is not practical. 
				For example, if you created an 'EU' tax rule, you would not be able to apply it to a location of 'Europe' as not all European countries are in the 'EU'. So instead, we can create a Zone called 'Tax EU Zone', we can then assign independent countries to this zone that will now inherit a defined EU tax rate.
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-9 center-block" style="float:initial;">
					<img src="images/admin_locations.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>

			<div class="lead" id="location-types" style="padding-top:80px">Location Types</div>
			<p>
				Location Types are intended to group locations into tiers, i.e. Country > State > Post/Zip Code.
				These tiers can then be targeted by shipping, tax and discount rules so that customers within those locations will be displayed prices and options that are available specifically to that location.
				For example, tax rates are different per country, state and even post/zip code, when a customer indicates to the cart their location, cart prices can then be adjusted to their local tax rate.
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-8 center-block" style="float:initial;">
					<img src="images/admin_location_types.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>

			<div class="lead" id="location-zones" style="padding-top:80px">Managing Zones</div>
			<p>
				The purpose of zones is to allow the grouping of locations that would otherwise be impractical using the parent-to-child relationship offered by the location type tiers. For example, if you wanted to create an 'EU' tax rule, you would not be able to apply it to a location of 'Europe' as not all European countries are in the 'EU'.
				So instead, we can create a zone called 'Tax EU Zone', we can then assign independent countries to this zone that will now inherit a defined 'EU' tax rate.
				Zones can be setup to include any assortment of locations across all location type tiers, for example, a country could be added to the same zone that was related to a specific post/zip code location.
			</p>

			<div class="lead" id="shipping-options" style="padding-top:80px">Managing Shipping Options</div>
			<p>
				Shipping Options can be setup to offer specific shipping options accordingly to a customers location.
				When targeting a specific location, the shipping option can be either applied to a specific location, or a location zone. Shipping Options that are applied to a location, are then inherited by all children of that location.
				Using the default setup of this cart demo as an example, any customer that specifies their location as 'United States' will be shown only options available for shipping to the 'United States'.
				If the customer was then to specify their State as 'California', they will only be shown shipping options to 'California' - because there are options defined for 'California'. However, if they specify 'Florida' they will still be shown the 'United States' shipping as no options are defined for 'Florida'.
				For added flexibility against complex tax rules, a specific tax rate can be applied to the shipping rate that will override the tax rate used by the cart.
				Shipping options can be included/excluded from cart discounts.
				Within each shipping option, a set of rate tiers can be defined to charge a different price depending on the carts total value and weight.
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-10 center-block" style="float:initial;">
					<img src="images/admin_shipping_option.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>

			<div class="lead" id="shipping-rules" style="padding-top:80px">Managing Shipping Rules</div>
			<p>
				Shipping options can be setup with a tier of rates that will calculate the appropriate price to charge depending on the carts total value and weight.

				The tier functionality is designed to work by defining weight and value brackets that the cart must fit into, for example, a rate could be set for all carts weighing between 0-500g and costing between £0-100, whilst another rate for all carts between 500-1000g and £100-500.

				To account for the additional weight of packaging, a 'Tare' weight can also be defined that will be added to the carts total weight.
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-10 center-block" style="float:initial;">
					<img src="images/admin_shipping_option.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>

			<div class="lead" id="taxes" style="padding-top:80px">Managing Taxes</div>
			<p>
				Taxes can be setup to apply a specific tax rate accordingly to a customers location.
				When targeting a specific location, the tax rate can either be applied to a specific location, or a location zone.
				Taxes that are applied to a location, are then inherited by all children of that location and will override taxes that are applied to a location zone.
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-10 center-block" style="float:initial;">
					<img src="images/admin_taxes.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>
		</div>
		<!-- END OF SALES -->

		<!-- PROMOTION -->
		<div class="container" style="padding-top:80px;" id="promotions">

			<div class="page-header">Promotions</div>

			<div class="lead" id="discounts" style="padding-top:80px">Item Discounts</div>
			<p>
				Discounts can be setup with a wide range of rule conditions that can then be applied to specific items, groups of items or across the entire cart.
				<br>
				Discount activation rules can be set to check the value and quantity of items in the cart, a customers location and up to three custom statuses within the cart. For example whether a customer has logged in, or is regarded as a new customer.
				<br>

				Other options include activation and expiry dates, usage limits, voiding of reward points and whether discounts can be combined with other discounts.
				<br>

				To comply with tax laws in different countries and states, the method of calculating tax on discounted items can be set using one of three methods.
			</p>
			<h4>Discounts Field Descriptions</h4>
			<table class="table table-flat table-striped">
				<thead class="bg-primary">
					<tr>
						<th>field</th>
						<th>description</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Discount Type</td>
						<td>Sets whether the discount is an item or summary discount, or a reward voucher.</td>
					</tr>
					<tr>
						<td>Discount Method</td>
						<td>Sets which cart value to apply the discount to.</td>
					</tr>
					<tr>
						<td>Tax Application Method</td>
						<td>Sets how tax should be applied to the discount.</td>
					</tr>
					<tr>
						<td>Location</td>
						<td>Sets the location that the discount is applied to.</td>
					</tr>
					<tr>
						<td>Zone</td>
						<td>Sets the discount to apply if an item in a particular discount group is added to the cart.</td>
					</tr>
					<tr>
						<td>Apply Discount to Item</td>
						<td>Sets the discount to apply if a particular item is added to the cart.</td>
					</tr>
					<tr>
						<td>Discount Code</td>
						<td>Sets the code required to apply the discount. Leave blank if the discount is activated via item quantities or values.</td>
					</tr>
					<tr>
						<td>Discount Description</td>
						<td>A short description of the discount that is displayed to the customer.</td>
					</tr>
					<tr>
						<td>Quantity Required to Activate</td>
						<td>Set the quantity of items required to activate the discount. For example, for a 'buy 5 get 2 free' discount, the quantity would be 7 (5+2).</td>
					</tr>
					<tr>
						<td>Quantity Discounted</td>
						<td>Sets the quantity of items that the discount is applied to. For example, for a 'buy 5 get 2 free' discount, the quantity would be 2.</td>
					</tr>
					<tr>
						<td>Value Required to Activate</td>
						<td>Sets the value required to active the discount. For item discounts, the value is the total value of the discountable items. For summary discounts, the value is the cart total.</td>
					</tr>
					<tr>
						<td>Value Discounted</td>
						<td>Sets the value of the discount that is applied. For percentage discounts, this value is used as the discount percentage. For 'flat fee' and 'new value' discounts, this is the discounted currency value.</td>
					</tr>
					<tr>
						<td>Discount Recursive</td>
						<td>If checked, the discount can be repeated mdivtiples times to the same cart. For example, if checked, a 'Buy 1, get 1 free' discount can be reapplied if 2, 4, 6 (etc) items are added to the cart. If not checked, the discount is only applied for the first 2 items.</td>
					</tr>
					<tr>
						<td>Non Combinable Discount</td>
						<td>If checked, the discount cannot be and combined and used with any other discounts or reward vouchers.</td>
					</tr>
					<tr>
						<td>Void Reward Points</td>
						<td>If checked, any reward points earnt from items within the cart will be reset to zero whilst the discount is used.</td>
					</tr>
					<tr>
						<td>Force Shipping Discount</td>
						<td>If checked, the discount value will be 'forced' on the carts shipping option calcdivations, even if the selected shipping option has not been set as being discountable.</td>
					</tr>
				</tbody>
			</table>
			
			<div class="lead" id="reward-points">Reward Points and Vouchers</div>
			<p>
				Users can earn reward points when they purchase items. When they earn enough points, they can be converted to a voucher worth a monetary value.

				The voucher is stored as a code in the database that when entered on their next purchase, will deduct the vouchers value from their cart total.

				The conversion and monetary value of reward points and vouchers can all be set via the cart configuration
			</p>
		</div>
		<!-- END OF PROMOTION -->

		<!-- STORE FRONT -->
		<div class="container" style="padding-top:80px;" id="store-front">
			<div class="page-header">Store Front</div>
				
			<div class="lead" id="pages">Managing Pages</div>
			<p>
				Pages allow a store to setup custom pages that will appear on the website.
				For example, a store may need an about page, a terms and conditions page or maybe an events page.
				The cart does allows you to create as many pages as you want,
				links to your Pages will be displayed in the header and footer of the store front
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-9 center-block" style="float:initial;margin-top:5%">
					<img src="images/admin_pages.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>

			<div class="lead" id="banners">Managing Banners</div>
			<p>
				Banners are visual adverts or promotions that are displayed at the home page of the store-front.
				Banners can either be images or html text, html text will always overides images.
				Banners can be setup to run at and expire after defined dates.
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-9 center-block" style="float:initial;margin-top:5%">
					<img src="images/admin_banners.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>
		</div>
		<!-- END OF STORE FRONT -->
		
		<!-- SETTINGS -->
		<div class="container" style="padding-top:80px;" id="settings">
			
			<div class="page-header">Cart Settings</div>
			
			<div class="lead">Cart Configuration</div>
			<p>
				Many of the features of this cart can be controlled via a series of configuration settings,
				that can define how specific internal functions perform automatic operations to data within the cart.
				The configuration settings is largely done via the admin dashboard, they can be edited through url
				<code><?php echo $baseUrl; ?>/admin/config</code> without requiring access to the server.
			</p>
			<p>
				Detailed explanation for each configuration is provided throughout the configuration page
			</p>
			<div>
				<ul class="nav nav-tabs" role="tablist" style="margin:20px 0">
					<li role="presentation" class="active">
						<a href="#cart-config-image" aria-controls="cart-config-image" role="tab" data-toggle="tab">
							Preview Image
						</a>
					</li>
					<li role="presentation">
						<a href="#cart-config-fields" aria-controls="cart-config-fields" role="tab" data-toggle="tab">
							Field Description
						</a>
					</li>
				</ul>

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="cart-config-image">
						<img src="images/admin_config.png" alt="" class="thumbnail img-responsive" style="display: inline-block;">
					</div>
					<div role="tabpanel" class="tab-pane" id="cart-config-fields">
						<div class="table-responsive">
							<table class="table table-flat table-striped">
								<thead>
									<tr class="bg-primary">
										<th>Field</th>
										<th>Description</th>
									</tr>
								</thead>
								<tbody>
									<tr class="bg-info">
										<th colspan="2">PAGES</th>
									</tr>
									<tr>
										<th>Pagination Limit</th>
										<td>
											Number of items to be displayed per page.
										</td>
									</tr>
									<tr>
										<th>File Upload Limit</th>
										<td>
											Number of images to be uploaded per item.
										</td>
									</tr>

									<tr class="bg-info">
										<th colspan="2">ORDERS</th>
									</tr>
									<tr>
										<th>Order Number Prefix</th>
										<td>
											Sets a prefix value to the cart order number.
										</td>
									</tr>
									<tr>
										<th>Order Number Suffix</th>
										<td>
											Sets a suffix value to the cart order number.
										</td>
									</tr>
									<tr>
										<th>Increment Order Number</th>
										<td>
											Check to increment the cart order number from the last order number,
											or unchecked to randomly generates a number.
										</td>
									</tr>
									<tr>
										<th>Minimum Order Value</th>
										<td>
											The least amount of total cart items before the cart can be submited.
										</td>
									</tr>
									<tr>
										<th>Minimum Order Value</th>
										<td>
											The least amount of total cart items before the cart can be submited.
										</td>
									</tr>

									<tr class="bg-info">
										<th colspan="2">QUANTITIES & STOCK</th>
									</tr>
									<tr>
										<th>Quantity Decimals</th>
										<td>
											Number of decimals acceptable for items quantities. Typically "0"
										</td>
									</tr>
									<tr>
										<th>Increment Duplicate Quantities</th>
										<td>
											Check to increment an item's quantity when an identical duplicate is already added to the cart,
											or uncheck to use the defined quantity.
										</td>
									</tr>
									<tr>
										<th>Quantity Limited by Stock</th>
										<td>
											Check to limit the maximum quantity of cart items to the databases item stock quantity.
										</td>
									</tr>
									<tr>
										<th>Quantity Limited by Stock</th>
										<td>
											Check to automatically remove out-of-stock items from the cart.
										</td>
									</tr>
									<tr>
										<th>Auto Allocate Item Stock</th>
										<td>
											Check to automatically update stock quantities.
										</td>
									</tr>
									<tr>
										<th>Save Banned Shipping Items</th>
										<td>
											When a user completes an order, save item details to the database
											even if it is not permitted to be shipped to the user's shipping location.
										</td>
									</tr>
									<tr>
										<th>Multi Row Duplicate Items</th>
										<td>
											Check to add duplicate cart items as a new separate row in the cart,
											or uncheck to update the existing item.
										</td>
									</tr>

									<tr class="bg-info">
										<th colspan="2">WEIGHTS</th>
									</tr>
									<tr>
										<th>Weight Type</th>
										<td>
											Sets the default weight measurement to display item weights as.
										</td>
									</tr>
									<tr>
										<th>Weight Decimals</th>
										<td>
											Sets the default number of decimals points to display item weights by.
										</td>
									</tr>

									<tr class="bg-info">
										<th colspan="2">TAX</th>
									</tr>
									<tr>
										<th>Display Tax Prices</th>
										<td>
											Check to display item prices including tax by default.
										</td>
									</tr>
									<tr>
										<th>Prices Include Tax</th>
										<td>
											Check to include tax to item prices added to the cart.
										</td>
									</tr>

									<tr class="bg-info">
										<th colspan="2">REWARD POINTS & VOUCHERS</th>
									</tr>
									<tr>
										<th>Dynamic Reward Points</th>
										<td>
											Check to base reward points on the items current tax rate based price or
											uncheck to base reward points on the original value of an item.
											<p>
												<div><strong>Example</strong></div>
												An item is added to the cart costing £20 including 20% tax, the user then ships to a 10% tax zone, so the item now costs £18.33. <br>
												i.e. remove 20% tax: £20 / 20% = £16.67, then add 10% tax: £16.67 * 10% = £18.33,
												Should the reward points be based on the dynamic tax variable price, or the initial £20 price? <br>
												'Checked' = dynamic, 'Non Checked' = Internal.
											</p>
										</td>
									</tr>
									<tr>
										<th>Reward Point Multiplier</th>
										<td>
											Number of reward points that are awarded per 1.00 currency unit of an items price.
											<p>
												<div><strong>Example</strong></div>
												A multiplier of 10 is (10 x £1.00) = 10 reward points. Therefore, an item priced at £100 would be worth 1000 reward points.
											</p>
										</td>
									</tr>
									<tr>
										<th>Reward Voucher Multiplier</th>
										<td>
											Worth of each reward point as a currency value when converted to a reward voucher.
											<p>
												<div><strong>Example</strong></div>
												If 250 reward points were converted using a multiplier of £0.01 per point, the reward voucher would be worth £2.50 (250 x 0.01).
											</p>
										</td>
									</tr>
									<tr>
										<th>Reward Point to Voucher Ratio</th>
										<td>
											Number of reward points are required to create 1 reward voucher.
											<p>
												<div><strong>Example</strong></div>
												A ratio of 250 means for every 250 reward points, 1 voucher worth 250 points can be created, this voucher is then worth a defined currency value. <br>
												A customer with 500 reward points could create either 1 voucher of 500 points, or 2 vouchers with 250 points each. <br>
												A customer creating a voucher with 525 reward points, would only be able to convert and use 500 points, the remaining 25 remain as active reward points.
											</p>
										</td>
									</tr>
									<tr>
										<th>Days Reward Point Pending</th>
										<td>
											Number of days that reward points earnt from the item become active after the item order has been set as 'Completed' (i.e. shipped to customer).
											<p>
											The idea of this option is to prevent a customer from placing an order soley to earn reward points,
											then purchasing a second order using a reward voucher earnt from the first order.
											The customer codivd then return the first order for a refund, but the reward points earnt from it have already been
											used to purchase the second order at a cheaper price. <br>
											The number of days set Should reflect the stores return policy, for example, if items cannot be returned after 14 days,
											the reward points Should only become active after 14 days. <br>
											Note: Reward points only become active x days after the order has been set by an admin as 'Completed', not x days after the order was first received.
											</p>
										</td>
									</tr>
									<tr>
										<th>Days Reward Point Valid</th>
										<td>
											Number of days that reward points are valid for.
										</td>
									</tr>
									<tr>
										<th>Days Reward Voucher Valid</th>
										<td>
											Number of days that reward vouchers are valid for.
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="lead">Currencies</div>
			<p>
				When setting up the cart, all monetary values are based on a specifically defined currency (GBP (£) by default),
				this currency value is then used for all internal calculations.
				When these values are displayed by the cart, they can be converted into any other currency that has been setup. <br>
				This allows for cart setups that would enable a customer to view prices in their own currency,
				whilst still saving all cart data in the carts default currency.
			</p>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-9 center-block" style="float:initial;margin-top:5%">
					<img src="images/admin_currencies.png" alt="" class="thumbnail img-responsive">
				</div>
			</div>

			<div class="lead">Cart Defaults</div>
			<p>
				The default values selected will be the options and values that are defined when a user first visits the site.
				These values include, the default currency, default shipping location, default shipping option, default tax location and default tax rate.
				Your customers may still choose different values if the defaults do not apply to them.
			</p>
			<img src="images/admin_defaults.png" alt="" class="thumbnail img-responsive" style="display: inline-block;">
		</div>
		<!-- END OF SETTINGS -->
		
		<!-- PAYPAL -->
		<div class="container" style="margin-bottom:50px;padding-top:80px;" id="paypal">
			<div class="page-header">PayPal</div>
			<p>
				Dvee Cart uses PayPal payment gateway to accept payments on orders. <br>
				Before you use PayPal, ensure that you have setup a merchant account with <a href="https://www.paypal.com/au/webapps/mpp/merchant">PayPal</a>. <br>
				To Setup a PayPal merchant account, go to <code>application/config/paypal.php</code>. Here are some PayPal value descriptions. 
			</p>
			<div class="lead">PayPal value descriptions</div>
			<div class="table-responsive">
				<table class="table table-flat table-striped">
					<thead>
						<tr class="bg-primary">
							<th>Field</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>$config['APIUsername']</th>
							<td>PayPal merchant account username</td>
						</tr>
						<tr>
							<th>$config['APIPassword']</th>
							<td>PayPal merchant account password</td>
						</tr>
						<tr>
							<th>$config['APISignature']</th>
							<td>PayPal merchant account signature</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- END OF PAYPAL -->

		<div style="margin-top:50px;padding:20px">
			<hr>
			<div class="container">
				<div class="text-right">
					<small>COPYRIGHT</small> &copy
					<?php
					date_default_timezone_set('UTC');
					echo date('Y');
					?>
					Dvee Docs. All Rights Reserved</div>
				</div>
			</div>
		</div>
	</div>
</div>

</body>

</html>