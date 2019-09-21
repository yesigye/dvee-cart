<?php $this->load->view('admin/templates/header', array(
	'title' => 'Discounts',
	'link' => 'discounts',
	'sub_link' => 'add',
	'breadcrumbs' => array(
		0 => array('name'=>'Discounts','link'=>'item_discounts'),
		1 => array('name'=>'Insert New Discount','link'=>FALSE)
	)
)); ?>

<?php $this->load->view('admin/discounts/discounts_sub_header', array(
	'active' => 'insert'
)); ?>

<?php if (validation_errors()): ?>
<div class="alert alert-danger">Check the form for errors and try again.</div>
<?php endif ?>
										
<?php echo form_open(current_url()); ?>
<div class="tab-content m-0" id="myTabContent">
	<div class="tab-pane active" role="tabpanel" id="tab-desc">
		<div class="form-group">
			<label for="discount_code" class="control-label m-0 m-0">Discount Code</label>
			<div class="text-muted">
				Set the code required to apply the discount. Leave blank if the discount is activated via item quantities or values	
			</div>
			<input type="text" id="discount_code" name="insert[code]" value="<?php echo set_value('insert[code]') ?>" class="form-control <?php echo form_error('insert[code]') ? 'is-invalid' : '' ?>"/>
			<div class="invalid-feedback"><?php echo form_error('insert[code]') ?></div>
		</div>

		<div class="form-group">
			<label for="discount_desc" class="control-label m-0 m-0">Description:</label>
			<div class="text-muted">
				A short description of the discount that is displayed to the customer
			</div>
			<textarea
			 id="discount_desc"
			 name="insert[description]"
			 class="form-control <?php echo form_error('insert[description]') ? 'is-invalid' : '' ?>"
			><?php echo set_value('insert[description]') ?></textarea>
			<div class="invalid-feedback"><?php echo form_error('insert[description]') ?></div>
		</div>

		<div class="form-group">
			<label class="m-0" for="discount_usage_limit">
				Usage Limit <span class="text-danger">*</span>
			</label>
			<div class="text-muted">
				Set the number of times remaining that the discount can be used
			</div>
			<input type="text" id="discount_usage_limit" name="insert[usage_limit]" value="<?php echo set_value('insert[usage_limit]') ?>" class="form-control <?php echo form_error('insert[usage_limit]') ? 'is-invalid' : '' ?>">
			<div class="invalid-feedback"><?php echo form_error('insert[usage_limit]') ?></div>
		</div>

		<div class="form-group">
			<label for="discount_valid_date" class="m-0">
				Valid Date (yyyy-mm-dd) <span class="text-danger">*</span>
			</label>
			<div class="text-muted">
				Set the start date that the discount is valid from
			</div>
			<input type="text" id="discount_valid_date" name="insert[valid_date]" value="<?php echo set_value('insert[valid_date]', date('Y-m-d')) ?>" maxlength="10" class="form-control <?php echo form_error('insert[valid_date]') ? 'is-invalid' : '' ?>"/>
			<div class="invalid-feedbck"><?php echo form_error('insert[valid_date]') ?></div>
		</div>

		<div class="form-group">
			<label for="discount_expire_date" class="m-0">
				Expire Date (yyyy-mm-dd) <span class="text-danger">*</span>
			</label>
			<div class="text-muted">
				Set the expiry date that the discount is valid until
			</div>
			<input type="text" id="discount_expire_date" name="insert[expire_date]" value="<?php echo set_value('insert[expire_date]', date('Y-m-d', strtotime('3 Month'))) ?>" maxlength="10" class="form-control <?php echo form_error('insert[expire_date]') ? 'is-invalid' : '' ?>">
			<div class="invalid-feedback"><?php echo form_error('insert[expire_date]') ?></div>
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
			 name="insert[order_by]"
			 class="form-control <?php echo form_error('insert[order_by]') ? 'is-invalid' : '' ?>"
			 value="<?php echo set_value('insert[order_by]') ?>"
			>
			<div class="invalid-feedback"><?php echo form_error('insert[order_by]') ?></div>
		</div>
		
		<div class="form-group">
			<label class="custom-control custom-checkbox" for="discount_status">
				<input type="hidden" name="update[status]" value="0"/>
				<input type="checkbox" class="custom-control-input <?php echo form_error('insert[status]') ? 'is-invalid' : '' ?>" id="discount_status" name="insert[status]" value="1" <?php echo set_checkbox('insert[status]', '1'); ?>/>
				<div class="custom-control-label">
					Active Status
					<div class="text-muted">
						If checked, the discount will be set as 'active'
					</div>
				</div>
			</label>
			<div class="invalid-feedback"><?php echo form_error('insert[status]') ?></div>
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
			<select id="discount_type" name="insert[type]" class="form-control <?php echo form_error('insert[type]') ? 'is-invalid' : '' ?>">
				<?php foreach($discount_types as $type): $id = $type[$this->flexi_cart_admin->db_column('discount_types', 'id')]; ?>
				<option value="<?php echo $id; ?>" <?php echo set_select('insert[type]', $id); ?>>
					<?php echo $type[$this->flexi_cart_admin->db_column('discount_types', 'type')];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('insert[type]') ?></div>
		</div>
		<div class="form-group">
			<label for="discount_method" class="control-label m-0">
				Discount Method: <span class="text-danger">*</span>
			</label>
			<div class="text-muted">
				Set which cart value to apply the discount to
			</div>
			<select id="discount_method" name="insert[method]" class="form-control <?php echo form_error('insert[method]') ? 'is-invalid' : '' ?>">
				<?php foreach($discount_methods as $method): $id = $method[$this->flexi_cart_admin->db_column('discount_methods', 'id')]; ?>
				<option value="<?php echo $id; ?>" class="parent_id_<?php echo $method[$this->flexi_cart_admin->db_column('discount_methods', 'type')];?>" <?php echo set_select('insert[method]', $id); ?>>
					<?php echo $method[$this->flexi_cart_admin->db_column('discount_methods', 'method')];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('insert[method]') ?></div>
		</div>
		<div class="form-group">
			<label for="discount_tax_method" class="control-label m-0">
				Tax Appliance Method
			</label>
			<div class="text-muted">
				Set how tax should be applied to the discount
			</div>
			<select id="discount_tax_method" name="insert[tax_method]" class="form-control <?php echo form_error('insert[tax_method]') ? 'is-invalid' : '' ?>">
				<option value="0">Carts Default Tax Method</option>
				<?php foreach($discount_tax_methods as $tax_method): $id = $tax_method[$this->flexi_cart_admin->db_column('discount_tax_methods', 'id')]; ?>
				<option value="<?php echo $id; ?>" <?php echo set_select('insert[tax_method]', $id); ?>>
					<?php echo $tax_method[$this->flexi_cart_admin->db_column('discount_tax_methods', 'method')];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('insert[tax_method]') ?></div>
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
			<select id="discount_location" name="insert[location]" class="form-control <?php echo form_error('insert[location]') ? 'is-invalid' : '' ?>">
				<option value="0"> - All Locations - </option>
				<?php foreach($locations_inline as $location): $id = $location[$this->flexi_cart_admin->db_column('locations', 'id')]; ?>
				<option value="<?php echo $id; ?>" <?php echo set_select('insert[location]', $id); ?>>
					<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('insert[location]') ?></div>
		</div>
		<div class="form-group">
			<label for="discount_zone" class="control-label m-0">
				Zone
				<div class="text-muted">
					Set the zone that the discount is applied to. If a location is set, it has priority over a zone rule
				</div>
			</label>
			<select id="discount_zone" name="insert[zone]" class="form-control <?php echo form_error('insert[zone]') ? 'is-invalid' : '' ?>">
				<option value="0"> - All Zones - </option>
				<?php foreach($zones as $zone): $id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')]; ?>
				<option value="<?php echo $id; ?>" <?php echo set_select('insert[zone]', $id); ?>>
					<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')];?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('insert[zone]') ?></div>
		</div>
	</div>

	<div class="tab-pane" role="tabpanel" id="tab-target">
		<div class="form-group <?php echo (form_error('insert[group]')) ? 'has-error' : '' ?>">
			<label for="discount_group" class="control-label m-0">
				Apply Discount to Group
				<div class="text-muted">
					Set the discount to apply if an item in a particular discount group is added to the cart.
				</div>
			</label>
			<select id="discount_group" name="insert[group]" class="form-control <?php echo form_error('insert[group]') ? 'is-invalid' : '' ?>">
				<option value="0"> - Not applied to a Group - </option>
			<?php 
				foreach($discount_groups as $group) { 
					$id = $group[$this->flexi_cart_admin->db_column('discount_groups', 'id')];
					?>
				<option value="<?php echo $id; ?>" <?php echo set_select('insert[group]', $id); ?>>
					<?php echo $group[$this->flexi_cart_admin->db_column('discount_groups', 'name')];?>
				</option>
			<?php } ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('insert[group]') ?></div>
		</div>
		<div class="form-group <?php echo (form_error('insert[item]')) ? 'has-error' : '' ?>">
			<label for="discount_item" class="control-label m-0">
				Apply Discount to Item
				<div class="text-muted">
					Set the discount to apply if a particular item is added to the cart
				</div>
			</label>
			<select id="discount_item" name="insert[item]" class="form-control <?php echo form_error('insert[item]') ? 'is-invalid' : '' ?>">
				<option value="0"> - Not applied to an Item - </option>	
				<?php foreach($items as $item): ?>
				<option value="<?php echo $item['id'] ?>" <?php echo set_select('insert[item]', $item['id']) ?>>
					<?php echo $item['name'] ?>
				</option>
				<?php endforeach ?>
			</select>
			<div class="invalid-feedback"><?php echo form_error('insert[item]') ?></div>
		</div>
	</div>
		
	<div class="tab-pane" role="tabpanel" id="tab-rules">
		<div class="form-group <?php echo (form_error('insert[quantity_required]')) ? 'has-error' : '' ?>">
			<label class="control-label m-0" for="discount_qty_req">
				Quantity Required to Activate
				<div class="text-muted">
					Set the quantity of items required to activate the discount.
					For example, for a 'buy 5 get 2 free' discount, the quantity would be 7 (5+2)
					meaning that the discount will apply when after adding 5 items, an extra 2 items are added
				</div>
			</label>
			<input type="number" id="discount_qty_req" name="insert[quantity_required]" value="<?php echo set_value('insert[quantity_required]', 0);?>" class="form-control <?php echo form_error('insert[quantity_required]') ? 'is-invalid' : '' ?>"/>
			<div class="invalid-feedback"><?php echo form_error('insert[quantity_required]') ?></div>
		</div>
		<div class="form-group <?php echo (form_error('insert[quantity_discounted]')) ? 'has-error' : '' ?>">
			<label class="control-label m-0" for="discount_qty_disc">
				Discount Quantity
				<div class="text-muted">
					Set the quantity of items that the discount is applied to.
					For example, for a 'buy 5 get 2 free' discount, the quantity would be 2
					meaning that the discount applies to the 2 free items
				</div>
			</label>
			<input type="number" id="discount_qty_disc" name="insert[quantity_discounted]" value="<?php echo set_value('insert[quantity_discounted]', 0);?>" class="form-control <?php echo form_error('insert[quantity_discounted]') ? 'is-invalid' : '' ?>"/>
			<div class="invalid-feedback"><?php echo form_error('insert[quantity_discounted]') ?></div>
		</div>
		<div class="form-group <?php echo (form_error('insert[value_required]')) ? 'has-error' : '' ?>">
			<label class="control-label m-0" for="discount_value_req">
				Value Required to Activate
				<div class="text-muted">
					Set the value required to active the discount. For item discounts,
					the value is the total value of the discountable items.
					For summary discounts, the value is the cart total
				</div>
			</label>
			<input type="number" id="discount_value_req" name="insert[value_required]" value="<?php echo set_value('insert[value_required]', 0);?>" class="form-control <?php echo form_error('insert[value_required]') ? 'is-invalid' : '' ?>"/>
			<div class="invalid-feedback"><?php echo form_error('insert[value_required]') ?></div>
		</div>
		<div class="form-group <?php echo (form_error('insert[value_discounted]')) ? 'has-error' : '' ?>">
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
				<input type="number" id="discount_value_disc" name="insert[value_discounted]" value="<?php echo set_value('insert[value_discounted]', 10);?>" class="form-control <?php echo form_error('insert[value_discounted]') ? 'is-invalid' : '' ?>"/>
			</div>
			<div class="invalid-feedback"><?php echo form_error('insert[value_discounted]') ?></div>
		</div>
	</div>
		
	<div class="tab-pane" role="tabpanel" id="tab-function">
		<div class="form-group">
			<label class="custom-control custom-checkbox" for="discount_recursive">
				<input type="hidden" name="insert[recursive]" value="0"/>
				<input type="checkbox" class="custom-control-input <?php echo form_error('insert[recursive]') ? 'is-invalid' : '' ?>" id="discount_recursive" name="insert[recursive]" value="1" <?php echo set_checkbox('insert[recursive]', '1'); ?>/>
				<div class="custom-control-label">
					Discount Recursive
					<div class="text-muted">
						If checked, the discount can be repeated multiples times to the same cart. <br>
						For example, if checked, a 'Buy 1, get 1 free' discount can be reapplied if 2, 4, 6 (etc) items are added to the cart.
						<br/> If not checked, the discount is only applied for the first 2 items
					</div>
				</div>
			</label>
			<div class="invalid-feedback"><?php echo form_error('insert[recursive]') ?></div>
		</div>
		<div class="form-group">
			<label class="custom-control custom-checkbox" for="discount_non_combinable">
				<input type="hidden" name="insert[non_combinable]" value="0"/>
				<input type="checkbox" class="custom-control-input <?php echo form_error('insert[non_combinable]') ? 'is-invalid' : '' ?>" id="discount_non_combinable" name="insert[non_combinable]" value="1" <?php echo set_checkbox('insert[non_combinable]', '1'); ?>./>
				<div class="custom-control-label">
					Non Combinable Discount
					<div class="text-muted">
						If checked, the discount cannot be combined and used with any other discounts or reward vouchers
					</div>
				</div>
			</label>
			<div class="invalid-feedback"><?php echo form_error('insert[non_combinable]') ?></div>
		</div>
		<div class="form-group">
			<label class="custom-control custom-checkbox" for="discount_void_reward">
				<input type="hidden" name="insert[void_reward]" value="0"/>
				<input type="checkbox" class="custom-control-input <?php echo form_error('insert[void_reward]') ? 'is-invalid' : '' ?>" id="discount_void_reward" name="insert[void_reward]" value="1" <?php echo set_checkbox('insert[void_reward]', '1'); ?>/>
				<div class="custom-control-label">
					Void Reward Points
					<div class="text-muted">
						If checked, any reward points earnt from items within the cart will
						be reset to zero whilst the discount is used
					</div>
				</div>
			</label>
			<div class="invalid-feedback"><?php echo form_error('insert[void_reward]') ?></div>
		</div>
		<div class="form-group <?php echo (form_error('insert[force_shipping]')) ? 'has-error' : '' ?>">
			<label class="custom-control custom-checkbox" for="discount_force_shipping">
				<input type="hidden" name="insert[force_shipping]" value="0"/>
				<input type="checkbox" class="custom-control-input <?php echo form_error('insert[force_shipping]') ? 'is-invalid' : '' ?>" id="discount_force_shipping" name="insert[force_shipping]" value="1" <?php echo set_checkbox('insert[force_shipping]','1'); ?>/>
				<div class="custom-control-label">
					Force Shipping Discount
					<div class="text-muted">
						If checked, the discount value will be 'forced' on the carts shipping option calculations,
						even if the selected shipping option has not been set as being discountable
					</div>
				</div>
			</label>
			<div class="invalid-feedback"><?php echo form_error('insert[force_shipping]') ?></div>
		</div>
	</div>
</div>

</div>
</div>
		
<div class="text-right mt-3">
	<button type="submit" name="insert_discount" value="Insert Discount" class="btn btn-primary">
		<i class="fa fa-save mr-1"></i> <small>SAVE DISCOUNT</small>
	</button>
</div>
<?php echo form_close();?>						

<?php $this->load->view('admin/templates/footer'); ?>