<?php $this->load->view('admin/templates/header', array(
	'title' => 'Cart Configuration',
	'link' => 'settings',
	'sub_link' => 'config',
	'affix' => array(
		'target' => '#scroll-spy',
		'offset' => 20,
	),
	'breadcrumbs' => array(
		0 => array('name'=>'Settings','link'=>'config'),
		1 => array('name'=>'Cart Configuration','link'=>FALSE),
	)
)); ?>

<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>

<div class="row">
	<div class="col-md-3">
		<div id="scroll-spy" class="mb-3" data-spy="affix" data-offset-top="100">
			<nav class="list-group horizontal-scroll-alt flex-column">
				<a class="list-group-item list-group-item-action scroll-item active" href="#tab-orders">
					Orders
				</a>
				<a class="list-group-item list-group-item-action scroll-item" href="#tab-quantities">
					Quantities
				</a>
				<a class="list-group-item list-group-item-action scroll-item" href="#tab-weights">
					Weights
				</a>
				<a class="list-group-item list-group-item-action scroll-item" href="#tab-tax">
					Tax
				</a>
				<a class="list-group-item list-group-item-action scroll-item" href="#tab-points">
					Points & Vouchers
				</a>
				<a class="list-group-item list-group-item-action scroll-item" href="#tab-statuses">
					Statuses
				</a>
				<a class="list-group-item list-group-item-action scroll-item" href="#tab-website">
					Website
				</a>
			</nav>
		</div>
	</div>
	<div class="col-md-9">
		<?php echo form_open(current_url()); ?>
			<div id="tab-orders">
				<div class="lead mb-4 font-weight-bold">Orders</div>
				<div class="form-group mb-4">
					<label for="order_number_prefix" class="control-label">Order Number Prefix</label>
					<div class="text-muted">
						Set a prefix value to the cart order number.
						<span class="fa fa-info-sign text-info"
						data-toggle="tooltip" data-placement="bottom" title="If Order # is '12345' and Preffix is 'Cart', Formatted Order wil be 'Cart12345'">
							more info
						</span>
					</div>
					<input type="text" id="order_number_prefix" name="update[order_number_prefix]" value="<?php echo set_value('update[order_number_prefix]', $config[$this->flexi_cart_admin->db_column('configuration', 'order_number_prefix')]); ?>" placeholder="NULL" class="form-control"/>
				</div>
				<div class="form-group mb-4">
					<label for="order_number_suffix" class="control-label">Order Number Suffix</label>
					<div class="text-muted">
						Set a suffix value to the cart order number.
						<span class="fa fa-info-sign text-info"
						data-toggle="tooltip" data-placement="bottom" title="If Order # is '12345' and Suffix is 'Cart', Formatted Order wil be '12345Cart'">
							more info
						</span>
					</div>
					<input type="text" id="order_number_suffix" name="update[order_number_suffix]" value="<?php echo set_value('update[order_number_suffix]', $config[$this->flexi_cart_admin->db_column('configuration', 'order_number_suffix')]); ?>" placeholder="NULL" class="form-control"/>
				</div>
				<div class="form-group mb-4">
					<label class="custom-control custom-checkbox" for="increment_order_number">
						<input type="hidden" name="update[increment_order_number]" value="0"/>
						<?php $increment_order_number = (bool)$config[$this->flexi_cart_admin->db_column('configuration', 'increment_order_number')]; ?>
						<input type="checkbox" class="custom-control-input" id="increment_order_number" name="update[increment_order_number]" value="1" <?php echo set_checkbox('update[increment_order_number]','1', $increment_order_number); ?>/>
						<div class="custom-control-label">
							Increment Order Number
							<div class="text-muted">Incremented the cart order number from the last order number, or randomly generate a number?</div>
						</div>
					</label>
				</div>
				<div class="form-group mb-4">
					<label for="minimum_order" class="control-label">Minimum Order Value (&pound;)</label>
					<div class="text-muted">
						What is the minimum value for an order?
						<span class="fa fa-info-sign text-info"
						data-toggle="tooltip" data-placement="bottom" title="This value can then be checked against a particular summary column.">
						</span>
					</div>
					<input type="text" id="minimum_order" name="update[minimum_order]" value="<?php echo set_value('update[minimum_order]', $config[$this->flexi_cart_admin->db_column('configuration', 'minimum_order')]); ?>" placeholder="0" class="form-control validate_decimal"/>
				</div>
			</div>
				
			<div id="tab-quantities">
				<div class="lead mb-4 font-weight-bold">Quantities and Stock</div>
				<div class="form-group mb-4">
					<label for="quantity_decimals" class="control-label">Quantity Decimals</label>
					<div class="text-muted">
						How many decimals are acceptable for items quantities?
						<span class="fa fa-info-sign text-info"
						data-toggle="tooltip" data-placement="bottom" title="Typically, this Should be zero, however, some situations may require half quantities that would be entered into the cart as '0.5', this would require 1 decimal.">
						</span>
					</div>
					<input type="text" id="quantity_decimals" name="update[quantity_decimals]" value="<?php echo set_value('update[quantity_decimals]', $config[$this->flexi_cart_admin->db_column('configuration', 'quantity_decimals')]); ?>" placeholder="0" class="form-control validate_integer"/>
				</div>
				<div class="form-group mb-4">
					<label class="custom-control custom-checkbox" for="increment_duplicate_item_quantity">
						<?php $increment_duplicate_item_quantity = (bool)$config[$this->flexi_cart_admin->db_column('configuration', 'increment_duplicate_item_quantity')]; ?>
						<input type="hidden" name="update[increment_duplicate_item_quantity]" value="0"/>
						<input type="checkbox" class="custom-control-input" id="increment_duplicate_item_quantity" name="update[increment_duplicate_item_quantity]" value="1" <?php echo set_checkbox('update[increment_duplicate_item_quantity]','1', $increment_duplicate_item_quantity); ?>/>
						<div class="custom-control-label">
							Increment Duplicate Quantities
							<div class="text-muted">
								Should an items quantity be incremented when an identical duplicate is added to the cart?
								If not, the new quantity will be used.
							</div>
						</div>
					</label>
				</div>
				<div class="form-group mb-4">
					<label class="custom-control custom-checkbox" for="quantity_limited_by_stock">
						<?php $quantity_limited_by_stock = (bool)$config[$this->flexi_cart_admin->db_column('configuration', 'quantity_limited_by_stock')]; ?>
						<input type="hidden" name="update[quantity_limited_by_stock]" value="0"/>
						<input type="checkbox" class="custom-control-input" id="quantity_limited_by_stock" name="update[quantity_limited_by_stock]" value="1" <?php echo set_checkbox('update[quantity_limited_by_stock]','1', $quantity_limited_by_stock); ?>/>
						<div class="custom-control-label">
							Quantity Limited by Stock
							<div class="text-muted">
								Should the maximum quantity of cart items be limited to the databases item stock quantity?
							</div>
						</div>
					</label>
				</div>
				<div class="form-group mb-4">
					<label class="custom-control custom-checkbox" for="remove_no_stock_items">
						<?php $remove_no_stock_items = (bool)$config[$this->flexi_cart_admin->db_column('configuration', 'remove_no_stock_items')]; ?>
						<input type="hidden" name="update[remove_no_stock_items]" value="0"/>
						<input type="checkbox" class="custom-control-input" id="remove_no_stock_items" name="update[remove_no_stock_items]" value="1" <?php echo set_checkbox('update[remove_no_stock_items]','1', $remove_no_stock_items); ?>/>
						<div class="custom-control-label">
							Remove Out-of-Stock Items
							<div class="text-muted">
								Should out-of-stock items be automatically removed from the cart?
							</div>
						</div>
					</label>
				</div>
				<div class="form-group mb-4">
					<label class="custom-control custom-checkbox" for="auto_allocate_stock">
						<?php $auto_allocate_stock = (bool)$config[$this->flexi_cart_admin->db_column('configuration', 'auto_allocate_stock')]; ?>
						<input type="hidden" name="update[auto_allocate_stock]" value="0"/>
						<input type="checkbox" class="custom-control-input" id="auto_allocate_stock" name="update[auto_allocate_stock]" value="1" <?php echo set_checkbox('update[auto_allocate_stock]','1', $auto_allocate_stock); ?>/>								
						<div class="custom-control-label">
							Auto Allocate Item Stock
							<div class="text-muted">
								Should stock quantities be automatically updated and managed?
							</div>
						</div>
					</label>
				</div>
				<div class="form-group mb-4">
					<label class="custom-control custom-checkbox" for="save_banned_shipping_items">
						<?php $save_banned_shipping_items = (bool)$config[$this->flexi_cart_admin->db_column('configuration', 'save_banned_shipping_items')]; ?>
						<input type="hidden" name="update[save_banned_shipping_items]" value="0"/>
						<input type="checkbox" class="custom-control-input" id="save_banned_shipping_items" name="update[save_banned_shipping_items]" value="1" <?php echo set_checkbox('update[save_banned_shipping_items]','1', $save_banned_shipping_items); ?>/>
						<div class="custom-control-label">
							Save Banned Shipping Items
							<div class="text-muted">
								If an item is not permitted to be shipped to the current shipping location, yet the user still completes the order, Should the item details be saved to the database?
							</div>
						</div>
					</label>
				</div>
				<div class="form-group mb-4">
					<label class="custom-control custom-checkbox" for="multi_row_duplicate_items">
						<?php $multi_row_duplicate_items = (bool)$config[$this->flexi_cart_admin->db_column('configuration', 'multi_row_duplicate_items')]; ?>
						<input type="hidden" name="update[multi_row_duplicate_items]" value="0"/>
						<input type="checkbox" class="custom-control-input" id="multi_row_duplicate_items" name="update[multi_row_duplicate_items]" value="1" <?php echo set_checkbox('update[multi_row_duplicate_items]','1', $multi_row_duplicate_items); ?>/>
						<div class="custom-control-label">
							Multi Row Duplicate Items
							<div class="text-muted">
								Should all duplicate cart items be added as a new separate row in the cart?
								If not the existing item will be updated.
							</div>
						</div>
					</label>
				</div>
			</div>
				
			<div id="tab-weights">
				<div class="lead mb-4 font-weight-bold">Weights</div>
				<div class="form-group mb-4">
					<label for="weight_type" class="control-label">Weight Type</label>
					<div class="text-muted">
						Set the default weight to display item weights as.
					</div>
					<?php $weight_type = $config[$this->flexi_cart_admin->db_column('configuration', 'weight_type')];?>
					<select id="weight_type" name="update[weight_type]" class="form-control">
						<option value="gram" <?php echo set_select('update[weight_type]', 'gram', ($weight_type == 'gram'));?>>Grams</option>
						<option value="kilogram" <?php echo set_select('update[weight_type]', 'kilogram', ($weight_type == 'kilogram'));?>>Kilograms</option>
						<option value="avoir ounce" <?php echo set_select('update[weight_type]', 'avoir ounce', ($weight_type == 'avoir ounce'));?>>Ounce (Avoir)</option>
						<option value="avoir pound" <?php echo set_select('update[weight_type]', 'avoir pound', ($weight_type == 'avoir pound'));?>>Pounds (Avoir)</option>
						<option value="troy ounce" <?php echo set_select('update[weight_type]', 'troy ounce', ($weight_type == 'troy ounce'));?>>Ounce (Troy)</option>
						<option value="troy pound" <?php echo set_select('update[weight_type]', 'troy pound', ($weight_type == 'troy pound'));?>>Pounds (Troy)</option>
						<option value="carat" <?php echo set_select('update[weight_type]', 'carat', ($weight_type == 'carat'));?>>Carats</option>
					</select>
				</div>
				<div class="form-group mb-4">
					<label for="weight_decimals" class="control-label">Weight Decimals</label>
					<div class="text-muted">
						Set the default number of decimals points to display item weights by.
					</div>
					<input type="text" id="weight_decimals" name="update[weight_decimals]" value="<?php echo set_value('update[weight_decimals]', $config[$this->flexi_cart_admin->db_column('configuration', 'weight_decimals')]); ?>" placeholder="0" class="form-control validate_decimal"/>
				</div>
			</div>
				
			<div id="tab-tax">
				<div class="lead mb-4 font-weight-bold">Taxes</div>
				<div class="form-group mb-4">
					<label class="custom-control custom-checkbox" for="display_tax_prices">
						<?php $display_tax_prices = (bool)$config[$this->flexi_cart_admin->db_column('configuration', 'display_tax_prices')]; ?>
						<input type="hidden" name="update[display_tax_prices]" value="0"/>
						<input type="checkbox" class="custom-control-input" id="display_tax_prices" name="update[display_tax_prices]" value="1" <?php echo set_checkbox('update[display_tax_prices]','1', $display_tax_prices); ?>/>
						<div class="custom-control-label">
							Display Tax Prices
							<div class="text-muted">
								Should item prices be displayed including tax by default?
							</div>
						</div>
					</label>
				</div>
				<div class="form-group mb-4">
					<label class="custom-control custom-checkbox" for="price_inc_tax">
						<?php $price_inc_tax = (bool)$config[$this->flexi_cart_admin->db_column('configuration', 'price_inc_tax')]; ?>
						<input type="hidden" name="update[price_inc_tax]" value="0"/>
						<input type="checkbox" class="custom-control-input" id="price_inc_tax" name="update[price_inc_tax]" value="1" <?php echo set_checkbox('update[price_inc_tax]','1', $price_inc_tax); ?>/>
						<div class="custom-control-label">
							Prices Include Tax
							<div class="text-muted">
								Do item prices typically include tax when added to the cart?
							</div>
						</div>
					</label>
				</div>
			</div>
										
			<div id="tab-points">
				<div class="lead mb-4 font-weight-bold">Reward Points and Vouchers</div>
				<div class="form-group mb-4">
					<label class="custom-control custom-checkbox" for="dynamic_reward_points">
						<?php $dynamic_reward_points = (bool)$config[$this->flexi_cart_admin->db_column('configuration', 'dynamic_reward_points')]; ?>
						<input type="hidden" name="update[dynamic_reward_points]" value="0"/>
						<input type="checkbox" class="custom-control-input" id="dynamic_reward_points" name="update[dynamic_reward_points]" value="1" <?php echo set_checkbox('update[dynamic_reward_points]','1', $dynamic_reward_points); ?>/>
						<div class="custom-control-label">
							Dynamic Reward Points
							<div class="text-muted">
								Should reward points be based on the internal value of an item, or Should it be based on the items current tax rate based price?
								<span class="fa fa-info-sign text-info" data-toggle="collapse" data-trigger="focus" data-target="#collapse-points-info">more info</span>
							</div>
						</div>
					</label>
					<div id="collapse-points-info" class="alert alert-info collapse">
						Assume an item is added to the cart costing &pound;20 including 20% tax.<br>
						But a user ships this item to a 10% tax zone. The item now costs &pound;18.33.<br/>
						<b>(i.e. remove 20% tax: &pound;20 / 20% = &pound;16.67, then add 10% tax: &pound;16.67 * 10% = &pound;18.33)</b><br/>
						Should the reward points be based on the dynamic &pound;18.33 price, or the initial internal &pound;20 price?<br>
						Checked for dynamic, Uncheck for Internal.
					</div>
				</div>
				<div class="form-group mb-4">
					<label for="reward_point_multiplier" class="control-label">Reward Point Multiplier</label>
					<div class="text-muted">
						How many reward points are awarded per 1.00 currency unit of an items price?
						<span class="fa fa-info-sign text-info" data-toggle="collapse" data-trigger="focus" data-target="#collapse-multiplier-info">more info</span>
						<div id="collapse-multiplier-info" class="alert alert-info collapse">
							Assume a multiplier of 10. An item priced at &pound;100 would be worth 1000 reward points. <br>
							i.e. (10 x &pound;1.00) = 10 reward points.
						</div>
					</div>
					<input type="text" id="reward_point_multiplier" name="update[reward_point_multiplier]" value="<?php echo set_value('update[reward_point_multiplier]', round($config[$this->flexi_cart_admin->db_column('configuration', 'reward_point_multiplier')],4)); ?>" placeholder="0" class="form-control validate_decimal"/>
				</div>
				<div class="form-group mb-4">
					<label for="reward_voucher_multiplier" class="control-label">Reward Voucher Multiplier</label>
					<div class="text-muted">
						How much is each reward point worth as a currency value when converted to a reward voucher?
						<span class="fa fa-info-sign text-info" data-toggle="collapse" data-trigger="focus" data-target="#collapse-vocher-multi-info">more info</span>
						<div id="collapse-vocher-multi-info" class="alert alert-info collapse">
							If 250 reward points were converted using a multiplier of &pound;0.01 per point, the reward voucher would be worth &pound;2.50 (250 x 0.01).
						</div>
					<input type="text" id="reward_voucher_multiplier" name="update[reward_voucher_multiplier]" value="<?php echo set_value('update[reward_voucher_multiplier]', round($config[$this->flexi_cart_admin->db_column('configuration', 'reward_voucher_multiplier')],4)); ?>" placeholder="0" class="form-control validate_decimal"/>
					</div>
				</div>
				<div class="form-group mb-4">
					<label for="reward_point_to_voucher_ratio" class="control-label">Reward Point to Voucher Ratio</label>
					<div class="text-muted">
						How many reward points are required to create 1 reward voucher?
						<span class="fa fa-info-sign text-info" data-toggle="collapse" data-trigger="focus" data-target="#collapse-vocher-ration-info">more info</span>
						<div id="collapse-vocher-ration-info" class="alert alert-info collapse">
							A ratio of 250 means for every 250 reward points, 1 voucher worth 250 points can be created, this voucher is then worth a defined currency value.<br/>
							A customer with 500 reward points could create either 1 voucher of 500 points, or 2 vouchers with 250 points each.<br/>
							A customer creating a voucher with 525 reward points, would only be able to convert and use 500 points, the remaining 25 remain as active reward points.
						</div>
					</div>
					<input type="text" id="reward_point_to_voucher_ratio" name="update[reward_point_to_voucher_ratio]" value="<?php echo set_value('update[reward_point_to_voucher_ratio]', $config[$this->flexi_cart_admin->db_column('configuration', 'reward_point_to_voucher_ratio')]); ?>" placeholder="0" class="form-control validate_integer"/>
				</div>
				<div class="form-group mb-4">
					<label for="reward_point_days_pending" class="control-label">Days Reward Point Pending</label>
					<div class="text-muted">
						Once an item order has been set as 'Completed' (i.e. shipped to customer), after how many days Should reward points earnt from the item become active?
						<span class="fa fa-info-sign text-info" data-toggle="collapse" data-trigger="focus" data-target="#collapse-point-days-info">info</span>
						<div id="collapse-point-days-info" class="alert alert-info collapse">
							The idea of this option is to prevent a customer from placing an order soley to earn reward points, then purchasing a second order using a reward voucher earnt from the first order. The customer could then return the first order for a refund, but the reward points earnt from it have already been used to purchase the second order at a cheaper price.<br/>
							The number of days set Should reflect the stores return policy, for example, if items cannot be returned after 14 days, the reward points Should only become active after 14 days.<br/>
							Note: Reward points only become active x days after the order has been set by an admin as 'Completed', not x days after the order was first received.
						</div>
					</div>
					<input type="text" id="reward_point_days_pending" name="update[reward_point_days_pending]" value="<?php echo set_value('update[reward_point_days_pending]', $config[$this->flexi_cart_admin->db_column('configuration', 'reward_point_days_pending')]); ?>" placeholder="0" class="form-control validate_integer"/>
				</div>
				<div class="form-group mb-4">
					<label for="reward_point_days_valid" class="control-label">Days Reward Point Valid</label>
					<div class="text-muted">
						How many days are reward points valid for?
					</div>
					<input type="text" id="reward_point_days_valid" name="update[reward_point_days_valid]" value="<?php echo set_value('update[reward_point_days_valid]', $config[$this->flexi_cart_admin->db_column('configuration', 'reward_point_days_valid')]); ?>" placeholder="0" class="form-control validate_integer"/>
				</div>
				<div class="form-group mb-4">
					<label for="reward_voucher_days_valid" class="control-label">Days Reward Voucher Valid</label>
					<div class="text-muted">
						How many days are reward vouchers valid for?
					</div>
					<input type="text" id="reward_voucher_days_valid" name="update[reward_voucher_days_valid]" value="<?php echo set_value('update[reward_voucher_days_valid]', $config[$this->flexi_cart_admin->db_column('configuration', 'reward_voucher_days_valid')]); ?>" placeholder="0" class="form-control validate_integer"/>
				</div>
			</div>
				
			<div id="tab-statuses">
				<div class="lead mb-4 font-weight-bold">Custom Statuses</div>
				<p class="text-muted">
					Three individual custom cart statuses can be set to affect whether discounts become active.<br/>
					The custom statuses can contain any string or integer values, if the value then matches the the custom status of a discount, then provided all other discount conditions are also matched, the discount is activated.
				</p>
				<div class="row mb-4">
					<div class="col-md-4">
						<label for="custom_status_1">Custom Status 1</label>
						<input type="text" id="custom_status_1" name="update[custom_status_1]" value="<?php echo set_value('update[custom_status_1]', $config[$this->flexi_cart_admin->db_column('configuration', 'custom_status_1')]); ?>" class="form-control"/>
					</div>
					<div class="col-md-4">
						<label for="custom_status_2">Custom Status 2</label>
						<input type="text" id="custom_status_2" name="update[custom_status_2]" value="<?php echo set_value('update[custom_status_2]', $config[$this->flexi_cart_admin->db_column('configuration', 'custom_status_2')]); ?>" class="form-control"/>
					</div>
					<div class="col-md-4">
						<label for="custom_status_3">Custom Status 3</label>
						<input type="text" id="custom_status_3" name="update[custom_status_3]" value="<?php echo set_value('update[custom_status_3]', $config[$this->flexi_cart_admin->db_column('configuration', 'custom_status_3')]); ?>" class="form-control"/>
					</div>
				</div>
			</div>

			<div id="tab-website">
				<div class="lead mb-4 font-weight-bold">Frontend website</div>
				<div class="form-group mb-4">
					<label for="pagination_limit" class="control-label">Pagination Limit</label>
					<div class="text-muted">
						How many items should be displayed per page?
					</div>
					<input type="text" id="pagination_limit" name="update[pagination_limit]" value="<?php echo set_value('update[pagination_limit]', $config[$this->flexi_cart_admin->db_column('configuration', 'pagination_limit')]); ?>" placeholder="0" class="form-control validate_integer"/>
				</div>
				<div class="form-group mb-4">
					<label for="pagination_limit" class="control-label">File Upload Limit</label>
					<div class="text-muted">
						How many images should be uploaded per item?
					</div>
					<input type="text" id="user_file_limit" name="update[user_file_limit]" value="<?php echo set_value('update[user_file_limit]', $config[$this->flexi_cart_admin->db_column('configuration', 'user_file_limit')]); ?>" placeholder="0" class="form-control validate_integer"/>
				</div>
			</div>

			<input type="submit" name="update_config" value="Update Cart Configuration" class="btn btn-success mt-4"/>
		<?php echo form_close(); ?>
	</div>
</div>

<?php $this->load->view('admin/templates/footer', [
	'scripts' => ['<script type="text/javascript" src="'.base_url('assets/js/affix.js').'"></script>']
]); ?>