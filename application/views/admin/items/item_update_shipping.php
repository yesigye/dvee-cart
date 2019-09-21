<?php $this->load->view('admin/templates/header', array(
	'title' => 'Update Item Shipping',
	'link' => 'items',
	'breadcrumbs' => array(
		0 => array('name'=>'Items','link'=>'items'),
		1 => array('name'=>$product->name,'link'=>FALSE),
	)
)); ?>


<?php echo form_open_multipart(current_url()) ?>
	<?php echo form_hidden('id', $product->id) ?>
		
	<?php $this->load->view('admin/items/item_update_header', array(
		'id' => $product->id,
		'active' => 'shipping',
	)); ?>

	<div class="page-header">
		<h4 class="lead">
			Product Shipping
			<?php echo anchor('admin/insert_item_shipping/'.$product->id, 'Add Shipping Rules', 'class="btn btn-primary float-right"') ?>
			<div class="clearfix"></div>
		</h4>
	</div>

	<?php if (validation_errors()): ?>
			<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<?php if (! empty($message)): ?>
			<div id="message"> <?=$message ?> </div>
		<?php endif ?>
	<?php endif ?>


	<?php if (empty($item_shipping_data)): ?>
		<div class="my-4 text-muted">
			There are no shipping rules setup for this item.
		</div>
	<?php else: ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>
						<div data-toggle="tooltip" title="Set the location that the shipping rule is applied to.">
							Location
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="Set the zone that the shipping rule is applied to. Note: If a location is set, it has priority over a zone.">
							Zone
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" 
						title="The rate the item costs to ship to the selected location/zone. Note:Leave blank (Not '0') if not setting a rate.">
							Shipping Rate (&pound;)
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" 
						title="Set whether an item is 'Whitelisted' (Only permitted) or 'Blacklisted' (Not permitted) to being shipped to a location. If set as 'Location Not Banned', the item can be shipped to all locations.">
							Shipping Ban Status
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" 
						title="If checked, the cart will calculate the items shipping separate from the rest of the cart, and then add the cost to the final shipping charge.">
							Ship Seperate
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" 
						title="If checked, the shipping rule will be set as 'active'.">
							Status
						</div>
					</th>
					<th class="text-center text-danger">
						<div data-toggle="tooltip" 
						title="If checked, the row will be deleted upon the form being updated.">
							Delete
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($item_shipping_data as $row): $item_shipping_id = $row[$this->flexi_cart_admin->db_column('item_shipping', 'id')]; ?>
				<tr>
					<td>
						<input type="hidden" name="update[<?php echo $item_shipping_id; ?>][id]" value="<?php echo $row[$this->flexi_cart_admin->db_column('item_shipping', 'id')]?>"/>
						
						<?php $shipping_location = $row[$this->flexi_cart_admin->db_column('item_shipping', 'location')];?>
						<select name="update[<?php echo $item_shipping_id; ?>][location]" class="form-control ">
							<option value="0">No Shipping Location</option>
						<?php 
							foreach($locations_inline as $location) { 
								$id = $location[$this->flexi_cart_admin->db_column('locations', 'id')];
						?>
							<option value="<?php echo $id; ?>" <?php echo set_select('update['.$item_shipping_id.'][location]', $id, ($shipping_location == $id)); ?>>
								<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')]; ?>
							</option>
						<?php } ?>
						</select>
					</td>
					<td>
						<?php $shipping_zone = $row[$this->flexi_cart_admin->db_column('item_shipping', 'zone')];?>
						<select name="update[<?php echo $item_shipping_id; ?>][zone]" class="form-control ">
							<option value="0">No Shipping Zone</option>
						<?php 
							foreach($shipping_zones as $zone) { 
								$id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')];
						?>
							<option value="<?php echo $id; ?>" <?php echo set_select('update['.$item_shipping_id.'][zone]', $id, ($shipping_zone == $id));?>>
								<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')]; ?>
							</option>
						<?php } ?>
						</select>
					</td>
					<td>
						<input type="text" name="update[<?php echo $item_shipping_id; ?>][value]" value="<?php echo $row[$this->flexi_cart_admin->db_column('item_shipping', 'value')]?>" placeholder="NULL"  class="form-control " style="width:90px"/>
					</td>
					<td class="text-center">
						<?php $ship_banned = $row[$this->flexi_cart_admin->db_column('item_shipping', 'banned')]; ?>
						<select name="update[<?php echo $item_shipping_id; ?>][banned]" class="form-control ">
							<option value="0" <?php echo set_select('update['.$item_shipping_id.'][banned]', 0, ($ship_banned == 0));?>>Location Not Banned</option>
							<option value="1" <?php echo set_select('update['.$item_shipping_id.'][banned]', 1, ($ship_banned == 1));?>>Whitelist Location</option>
							<option value="2" <?php echo set_select('update['.$item_shipping_id.'][banned]', 2, ($ship_banned == 2));?>>Blacklist Location</option>
						</select>
					</td>
					<td class="text-center">
						<?php $ship_separate = (bool)$row[$this->flexi_cart_admin->db_column('item_shipping', 'separate')]; ?>
						<input type="hidden" name="update[<?php echo $item_shipping_id; ?>][separate]" value="0"/>
						<input type="checkbox" name="update[<?php echo $item_shipping_id; ?>][separate]" value="1" <?php echo set_checkbox('update['.$item_shipping_id.'][ship_separate]','1', $ship_separate); ?>/>
					</td>
					<td class="text-center">
						<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('item_shipping', 'status')]; ?>
						<input type="hidden" name="update[<?php echo $item_shipping_id; ?>][status]" value="0"/>
						<input type="checkbox" name="update[<?php echo $item_shipping_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$item_shipping_id.'][status]','1', $status); ?>/>
					</td>
					<td class="text-center">
						<input type="hidden" name="update[<?php echo $item_shipping_id; ?>][delete]" value="0"/>
						<input type="checkbox" name="update[<?php echo $item_shipping_id; ?>][delete]" value="1"/>
					</td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>					
	<?php endif ?>
	
	<?php echo form_submit('update_shipping', 'Update Item Shipping', 'class="btn btn-lg btn-success"') ?>

<?php echo form_close() ?>

<?php $this->load->view('admin/templates/footer') ?>