<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'item_discounts') ? 'active' : '' ?>" href="<?php echo site_url('admin/item_discounts') ?>">
            Manage Item Discounts
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'summary_discounts') ? 'active' : '' ?>" href="<?php echo site_url('admin/summary_discounts') ?>">
            Manage Summary Discounts
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?php echo ($active == 'group') ? 'active' : '' ?>" href="<?php echo site_url('admin/discount_groups') ?>">
            Manage Discount Groups
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <span class="nav-link <?php echo ($active == 'insert') ? 'active' : '' ?>">
            <a href="<?php echo site_url('admin/insert_discount') ?>">Insert New Discount</a>
            <span class="fa fa-info-circle text-info ml-2" data-toggle="collapse" data-target="#discount-info"></span>
        </span>
    </li>
</ul>

<?php if($active == 'insert'): ?>
<div id="discount-info" class="collapse bg-light p-2 text-muted">
	<p>Discounts can be setup with a wide range of rule conditions that can then be applied to specific items, groups of items or across the entire cart.</p>
	<p>Discount activation rules can be set to check the value and quantity of items in the cart, a customers location and up to three custom statuses within the cart. For example whether a customer has logged in, or is regarded as a new customer.</p>
	<p>Other options include activation and expiry dates, usage limits, voiding of reward points and whether discounts can be combined with other discounts.</p>
	<p>To comply with tax laws in different countries and states, the method of calculating tax on discounted items can be set using one of three methods.</p>
</div>
<?php endif ?>

<div class="row">
	<div class="col-md-3">
		<div id="scroll-spy" class="mb-3">
			<nav class="list-group horizontal-scroll-alt flex-column">
				<a role="tab" data-toggle="tab" class="list-group-item list-group-item-action scroll-item active" href="#tab-desc">
					Description
				</a>
				<a role="tab" data-toggle="tab" class="list-group-item list-group-item-action scroll-item" href="#tab-type">
					Type
				</a>
				<a role="tab" data-toggle="tab" class="list-group-item list-group-item-action scroll-item" href="#tab-location">
					Location
				</a>
				<a role="tab" data-toggle="tab" class="list-group-item list-group-item-action scroll-item" href="#tab-target">
					Target
				</a>
				<a role="tab" data-toggle="tab" class="list-group-item list-group-item-action scroll-item" href="#tab-rules">
					Requirements
				</a>
				<a role="tab" data-toggle="tab" class="list-group-item list-group-item-action scroll-item" href="#tab-function">
					Functionality
				</a>
			</nav>
		</div>
	</div>
	<div class="col-md-9">