<?php $this->load->view('admin/templates/header', array(
	'title' => 'Discounts',
	'link' => 'discounts',
	'sub_link' => 'update',
	'breadcrumbs' => array(
		0 => array('name'=>'Discounts','link'=>'item_discounts'),
		1 => array('name'=>'Update Discount','link'=>FALSE)
	)
)); ?>

<?php $this->load->view('admin/discounts/discounts_sub_header', array(
	'active' => 'items'
)); ?>
	
<?php if (validation_errors()): ?>
<div class="alert alert-danger">Check the form for errors and try again.</div>
<?php endif ?>

<?php echo form_open(current_url());?>
<div class="tab-content m-0" id="myTabContent">
	<div class="tab-pane active" role="tabpanel" id="tab-desc">
		<div class="form-group">
			<label for="discount_code" class="control-label m-0 m-0">Discount Code</label>
			<div class="text-muted">
				Set the code required to apply the discount. Leave blank if the discount is activated via item quantities or values	
			</div>
			<input
			 type="text"
			 id="discount_code"
			 name="update[code]"
			 value="<?php echo set_value('update[code]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'code')]) ?>"
			 class="form-control <?php echo form_error('update[code]') ? 'is-invalid' : '' ?>"
			>
			<div class="invalid-feedback"><?php echo form_error('update[code]') ?></div>
		</div>

		<div class="form-group">
			<label for="discount_desc" class="control-label m-0 m-0">Description:</label>
			<div class="text-muted">
				A short description of the discount that is displayed to the customer
			</div>
			<textarea
			 id="discount_desc"
			 name="update[description]"
			 class="form-control <?php echo form_error('update[description]') ? 'is-invalid' : '' ?>"
			><?php echo set_value('update[description]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'description')]) ?></textarea>
			<div class="invalid-feedback"><?php echo form_error('update[description]') ?></div>
		</div>

		<div class="form-group">
			<label class="m-0" for="discount_usage_limit">
				Usage Limit <span class="text-danger">*</span>
			</label>
			<div class="text-muted">
				Set the number of times remaining that the discount can be used
			</div>
			<input
			 type="text"
			 id="discount_usage_limit"
			 name="update[usage_limit]"
			 value="<?php echo set_value('update[usage_limit]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'usage_limit')])  ?>"
			 class="form-control <?php echo form_error('update[usage_limit]') ? 'is-invalid' : '' ?>"
			>
			<div class="invalid-feedback"><?php echo form_error('update[usage_limit]') ?></div>
		</div>

		<div class="form-group">
			<label for="discount_valid_date" class="m-0">
				Valid Date (yyyy-mm-dd) <span class="text-danger">*</span>
			</label>
			<div class="text-muted">
				Set the start date that the discount is valid from
			</div>
			<?php 
			// Crop MYSQL 'datetime' data to just display the date, not the time.
			$valid_date = substr($discount_data[$this->flexi_cart_admin->db_column('discounts', 'valid_date')], 0, 10); 
			?>
			<input
			 type="text"
			 id="discount_valid_date"
			 name="update[valid_date]"
			 value="<?php echo set_value('update[valid_date]', $valid_date);?>"
			 maxlength="10"
			 class="form-control <?php echo form_error('update[valid_date]') ? 'is-invalid' : '' ?>"
			>
			<div class="invalid-feedbck"><?php echo form_error('update[valid_date]') ?></div>
		</div>

		<div class="form-group">
			<label for="discount_expire_date" class="m-0">
				Expire Date (yyyy-mm-dd) <span class="text-danger">*</span>
			</label>
			<div class="text-muted">
				Set the expiry date that the discount is valid until
			</div>
			<?php
			// Crop MYSQL 'datetime' data to just display the date, not the time.
			$expire_date = substr($discount_data[$this->flexi_cart_admin->db_column('discounts', 'expire_date')], 0, 10); 
			?>
			<input
			 type="text"
			 id="discount_expire_date"
			 name="update[expire_date]"
			 value="<?php echo set_value('update[expire_date]', $expire_date) ?>"
			 maxlength="10"
			 class="form-control <?php echo form_error('update[expire_date]') ? 'is-invalid' : '' ?>"
			>
			<div class="invalid-feedback"><?php echo form_error('update[expire_date]') ?></div>
		</div>

		<div class="form-group">
			<label for="discount_order_by" class="control-label m-0 m-0">Order by</label>
			<div class="text-muted">
				Set the order that the discount is applied to the cart if other discounts are active.
				The lower the number, the higher priority.
			</div>
			<input
			 type="number"
			 id="discount_order_by"
			 name="update[order_by]"
			 class="form-control <?php echo form_error('update[order_by]') ? 'is-invalid' : '' ?>"
			 value="<?php echo set_value('update[order_by]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'order_by')]) ?>"
			>
			<div class="invalid-feedback"><?php echo form_error('update[order_by]') ?></div>
		</div>

		<div class="form-group">
			<?php $status = (bool) $discount_data[$this->flexi_cart_admin->db_column('discounts', 'status')]; ?>
			<label class="custom-control custom-checkbox" for="discount_status">
				<input type="hidden" name="update[status]" value="0"/>
				<input type="checkbox" class="custom-control-input <?php echo form_error('update[status]') ? 'is-invalid' : '' ?>" id="discount_status" name="update[status]" value="1" <?php echo set_checkbox('update[status]', '1', $status); ?>/>
				<div class="custom-control-label">
					Active Status
					<div class="text-muted">
						If checked, the discount will be set as 'active'
					</div>
				</div>
			</label>
			<div class="invalid-feedback"><?php echo form_error('update[status]') ?></div>
		</div>
	</div>

	<div class="tab-pane" role="tabpanel" id="tab-type">
		<div class="form-group">
			<label for="discount_type" class="control-label m-0">
				Discount Type <span class="text-danger">*</span>
			</label>
			<div class="text-muted">
				Sets whether the discount is an item or summary discount, or a reward voucher
			</div>
			<select id="discount_type" name="update[type]" class="form-control <?php echo form_error('update[type]') ? 'is-invalid' : '' ?>">
				<?php foreach($discount_types as $type): ?>
				<?php 
				$id = $type[$this->flexi_cart_admin->db_column('discount_types', 'id')];
				$select_type = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'type')] == $id);
				?>
				<option value="<?php echo $id;?>" <?php echo set_select('update[type]', $id, $select_type);?>>
					<?php echo $type[$this->flexi_cart_admin->db_column('discount_types', 'type')];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('update[type]') ?></div>
		</div>

		<div class="form-group">
			<label for="discount_method" class="control-label m-0">
				Discount Method: <span class="text-danger">*</span>
			</label>
			<div class="text-muted">
				Set which cart value to apply the discount to
			</div>
			<select id="discount_method" name="update[method]" class="form-control <?php echo form_error('update[method]') ? 'is-invalid' : '' ?>">
				<?php foreach($discount_methods as $method): ?>
				<?php 
				$id = $method[$this->flexi_cart_admin->db_column('discount_methods', 'id')];
				$select_method = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'method')] == $id);
				?>
				<option value="<?php echo $id;?>" class="parent_id_<?php echo $method[$this->flexi_cart_admin->db_column('discount_methods', 'type')];?>" <?php echo set_select('update[method]', $id, $select_method);?>>
					<?php echo $method[$this->flexi_cart_admin->db_column('discount_methods', 'method')];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('update[method]') ?></div>
		</div>

		<div class="form-group">
			<label for="discount_tax_method" class="control-label m-0">
				Tax Appliance Method
			</label>
			<div class="text-muted">
				Set how tax should be applied to the discount
			</div>
			<select id="discount_tax_method" name="update[tax_method]" class="form-control <?php echo form_error('update[tax_method]') ? 'is-invalid' : '' ?>">
				<option value="0">Carts Default Tax Method</option>
				<?php foreach($discount_tax_methods as $tax_method): ?>
				<?php 
				$id = $tax_method[$this->flexi_cart_admin->db_column('discount_tax_methods', 'id')];
				$select_tax_method = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'tax_method')] == $id);
				?>
				<option value="<?php echo $id;?>" <?php echo set_select('update[tax_method]', $id, $select_tax_method);?>>
					<?php echo $tax_method[$this->flexi_cart_admin->db_column('discount_tax_methods', 'method')];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('update[tax_method]') ?></div>
		</div>
	</div>
		
	<div class="tab-pane" role="tabpanel" id="tab-location">
		<div class="form-group">
			<label for="discount_location" class="control-label m-0">
				Location
				<div class="text-muted">
					Set the location that the discount is applied to
				</div>
			</label>
			<select id="discount_location" name="update[location]" class="form-control <?php echo form_error('update[location]') ? 'is-invalid' : '' ?>">
				<option value="0"> - All Locations - </option>
				<?php foreach($locations_inline as $location): ?>
				<?php 
				$id = $location[$this->flexi_cart_admin->db_column('locations', 'id')];
				$select_location = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'location')] == $id);
				?>
				<option value="<?php echo $id;?>" <?php echo set_select('update[location]', $id, $select_location);?>>
					<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('update[location]') ?></div>
		</div>
		<div class="form-group">
			<label for="discount_zone" class="control-label m-0">
				Zone
				<div class="text-muted">
					Set the zone that the discount is applied to. If a location is set, it has priority over a zone rule
				</div>
			</label>
			<select id="discount_zone" name="update[zone]" class="form-control <?php echo form_error('update[zone]') ? 'is-invalid' : '' ?>">
				<option value="0"> - All Zones - </option>
				<?php foreach($zones as $zone): ?>
				<?php 
				$id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')];
				$select_zone = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'zone')] == $id);
				?>
				<option value="<?php echo $id;?>" <?php echo set_select('update[zone]', $id, $select_zone);?>>
					<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('update[zone]') ?></div>
		</div>
	</div>

	<div class="tab-pane" role="tabpanel" id="tab-target">
		<div class="form-group <?php echo (form_error('update[group]')) ? 'has-error' : '' ?>">
			<label for="discount_group" class="control-label m-0">
				Apply Discount to Group
				<div class="text-muted">
					Set the discount to apply if an item in a particular discount group is added to the cart.
				</div>
			</label>
			<select id="discount_group" name="update[group]" class="form-control <?php echo form_error('update[group]') ? 'is-invalid' : '' ?>">
				<option value="0"> - Not applied to a Group - </option>
				<?php foreach($discount_groups as $group): ?>
				<?php 
				$id = $group[$this->flexi_cart_admin->db_column('discount_groups', 'id')];
				$select_group = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'group')] == $id);
				?>
				<option value="<?php echo $id;?>" <?php echo set_select('update[group]', $id, $select_group);?>>
					<?php echo $group[$this->flexi_cart_admin->db_column('discount_groups', 'name')];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('update[group]') ?></div>
		</div>
		<div class="form-group <?php echo (form_error('update[item]')) ? 'has-error' : '' ?>">
			<label for="discount_item" class="control-label m-0">
				Apply Discount to Item
				<div class="text-muted">
					Set the discount to apply if a particular item is added to the cart
				</div>
			</label>
			<select id="discount_item" name="update[item]" class="form-control <?php echo form_error('update[item]') ? 'is-invalid' : '' ?>">
				<option value="0"> - Not applied to an Item - </option>	
				<?php foreach($items as $item): ?>
				<?php 
				$select_item = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'item')] == $item['id']);
				?>
				<option value="<?php echo $item['id'] ?>" <?php echo set_select('update[item]', $item['id'], $select_item); ?>>
					<?php echo $item['name'];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('update[item]') ?></div>
		</div>
	</div>
		
	<div class="tab-pane" role="tabpanel" id="tab-rules">
		<div class="form-group">
			<label class="control-label m-0" for="discount_qty_req">
				Quantity Required to Activate
				<div class="text-muted">
					Set the quantity of items required to activate the discount.
					For example, for a 'buy 5 get 2 free' discount, the quantity would be 7 (5+2)
					meaning that the discount will apply when after adding 5 items, an extra 2 items are added
				</div>
			</label>
			<input
			 type="number"
			 id="discount_qty_req"
			 name="update[quantity_required]"
			 value="<?php echo set_value('update[quantity_required]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'quantity_required')]) ?>"
			 class="form-control <?php echo form_error('update[quantity_required]') ? 'is-invalid' : '' ?>"
			>
			<div class="invalid-feedback"><?php echo form_error('update[quantity_required]') ?></div>
		</div>
		<div class="form-group">
			<label class="control-label m-0" for="discount_qty_disc">
				Discount Quantity
				<div class="text-muted">
					Set the quantity of items that the discount is applied to.
					For example, for a 'buy 5 get 2 free' discount, the quantity would be 2
					meaning that the discount applies to the 2 free items
				</div>
			</label>
			<input
			 type="number"
			 id="discount_qty_disc"
			 name="update[quantity_discounted]"
			 value="<?php echo set_value('update[quantity_discounted]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'quantity_discounted')]) ?>"
			 class="form-control <?php echo form_error('update[quantity_discounted]') ? 'is-invalid' : '' ?>"
			>
			<div class="invalid-feedback"><?php echo form_error('update[quantity_discounted]') ?></div>
		</div>
		<div class="form-group">
			<label class="control-label m-0" for="discount_value_req">
				Value Required to Activate
				<div class="text-muted">
					Set the value required to active the discount. For item discounts,
					the value is the total value of the discountable items.
					For summary discounts, the value is the cart total
				</div>
			</label>
			<input
			 type="number"
			 id="discount_value_req"
			 name="update[value_required]"
			 value="<?php echo set_value('update[value_required]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'value_required')]) ?>"
			 class="form-control <?php echo form_error('update[value_required]') ? 'is-invalid' : '' ?>"
			>
			<div class="invalid-feedback"><?php echo form_error('update[value_required]') ?></div>
		</div>
		<div class="form-group">
			<label class="control-label m-0" for="discount_value_disc">
				Discount Value
				<div class="text-muted">
					Set the value of the discount that is applied.
					For percentage discounts, this value is used as the discount percentage. <br>
					For 'flat fee' and 'new value' discounts, this is the discounted currency value
				</div>
			</label>
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text text-muted">&pound</div>
				</div>
				<input
				type="number"
				id="discount_value_disc"
				name="update[value_discounted]"
				value="<?php echo set_value('update[value_discounted]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'value_discounted')]) ?>"
				class="form-control <?php echo form_error('update[value_discounted]') ? 'is-invalid' : '' ?>"
				>
			</div>
			<div class="invalid-feedback"><?php echo form_error('update[value_discounted]') ?></div>
		</div>
	</div>
		
	<div class="tab-pane" role="tabpanel" id="tab-function">
		<div class="form-group">
			<label class="custom-control custom-checkbox" for="discount_recursive">
				<?php $recursive = (bool) $discount_data[$this->flexi_cart_admin->db_column('discounts', 'recursive')]; ?>
				<input type="hidden" name="update[recursive]" value="0"/>
				<input type="checkbox" class="custom-control-input <?php echo form_error('update[recursive]') ? 'is-invalid' : '' ?>" id="discount_recursive" name="update[recursive]" value="1" <?php echo set_checkbox('update[recursive]', '1', $recursive); ?>/>
				<div class="custom-control-label">
					Discount Recursive
					<div class="text-muted">
						If checked, the discount can be repeated multiples times to the same cart. <br>
						For example, if checked, a 'Buy 1, get 1 free' discount can be reapplied if 2, 4, 6 (etc) items are added to the cart.
						<br/> If not checked, the discount is only applied for the first 2 items
					</div>
				</div>
			</label>
			<div class="invalid-feedback"><?php echo form_error('update[recursive]') ?></div>
		</div>
		
		<div class="form-group">
			<label class="custom-control custom-checkbox" for="discount_non_combinable">
				<?php $non_combinable = (bool) $discount_data[$this->flexi_cart_admin->db_column('discounts', 'non_combinable')]; ?>
				<input type="hidden" name="update[non_combinable]" value="0"/>
				<input type="checkbox" class="custom-control-input <?php echo form_error('update[non_combinable]') ? 'is-invalid' : '' ?>" id="discount_non_combinable" name="update[non_combinable]" value="1" <?php echo set_checkbox('update[non_combinable]', '1', $non_combinable); ?>./>
				<div class="custom-control-label">
					Non Combinable Discount
					<div class="text-muted">
						If checked, the discount cannot be combined and used with any other discounts or reward vouchers
					</div>
				</div>
			</label>
			<div class="invalid-feedback"><?php echo form_error('update[non_combinable]') ?></div>
		</div>

		<div class="form-group">
			<label class="custom-control custom-checkbox" for="discount_void_reward">
				<?php $void_reward = (bool) $discount_data[$this->flexi_cart_admin->db_column('discounts', 'void_reward_points')]; ?>
				<input type="hidden" name="update[void_reward]" value="0"/>
				<input type="checkbox" class="custom-control-input <?php echo form_error('update[void_reward]') ? 'is-invalid' : '' ?>" id="discount_void_reward" name="update[void_reward]" value="1" <?php echo set_checkbox('update[void_reward]', '1', $void_reward); ?>/>
				<div class="custom-control-label">
					Void Reward Points
					<div class="text-muted">
						If checked, any reward points earnt from items within the cart will
						be reset to zero whilst the discount is used
					</div>
				</div>
			</label>
			<div class="invalid-feedback"><?php echo form_error('update[void_reward]') ?></div>
		</div>

		<div class="form-group">
			<label class="custom-control custom-checkbox" for="discount_force_shipping">
				<?php $force_shipping = (bool) $discount_data[$this->flexi_cart_admin->db_column('discounts', 'force_shipping_discount')]; ?>
				<input type="hidden" name="update[force_shipping]" value="0"/>
				<input type="checkbox" class="custom-control-input <?php echo form_error('update[force_shipping]') ? 'is-invalid' : '' ?>" id="discount_force_shipping" name="update[force_shipping]" value="1" <?php echo set_checkbox('update[force_shipping]','1', $force_shipping) ?>/>
				<div class="custom-control-label">
					Force Shipping Discount
					<div class="text-muted">
						If checked, the discount value will be 'forced' on the carts shipping option calculations,
						even if the selected shipping option has not been set as being discountable
					</div>
				</div>
			</label>
			<div class="invalid-feedback"><?php echo form_error('update[force_shipping]') ?></div>
		</div>
	</div>
</div>

</div>
</div>
		
<div class="text-right mt-3">
	<button type="submit" name="update_discount" value="Update Discount" class="btn btn-primary">
		<i class="fa fa-save mr-1"></i> <small>SAVE CHANGES</small>
	</button>
</div>

<?php echo form_close();?>

</div>
</div>

<?php $this->load->view('admin/templates/footer', [
	'scripts' => ['<script type="text/javascript" src="'.base_url('assets/js/affix.js').'"></script>']
]); ?>