<?php $this->load->view('admin/templates/header', array(
	'title' => 'Insert Item Shipping',
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

	<h4 class="lead">
		Insert Product Shipping
	</h4>

	<?php if (validation_errors()): ?>
			<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<?php if (! empty($message)): ?>
			<div id="message"> <?=$message ?> </div>
		<?php endif ?>
	<?php endif ?>



	<table class="table table-striped">
		<thead>
			<tr>
				<th>
					<div data-toggle="tooltip" 
					title="Set the location that the shipping rule is applied to.">
						Location
					</div>
				</th>
				<th>
					<div data-toggle="tooltip" 
					title="Set the zone that the shipping rule is applied to. <br/>Note: If a location is set, it has priority over a zone.">
						Zone
					</div>
				</th>
				<th class="text-center">
					<div data-toggle="tooltip" title="The rate the item costs to ship to the selected location/zone. Note: Leave blank (Not '0') if not setting a rate.">
						Shipping Rate (&pound;)
					</div>
				</th>
				<th class="text-center">
					<div data-toggle="tooltip" title="Set whether an item is 'Whitelisted' (Only permitted) or 'Blacklisted' (Not permitted) to being shipped to a location. If set as 'Location Not Banned', the item can be shipped to all locations.">
						Shipping Ban Status
					</div>
				</th>
				<th class="text-center">
					<div data-toggle="tooltip" title="If checked, the cart will calculate the items shipping separate from the rest of the cart, and then add the cost to the final shipping charge.">
						Ship Seperate
					</div>
				</th>
				<th class="text-center">
					<div data-toogle="tooltip" title="If checked, the shipping rule will be set as 'active'.">
						Status
					</div>
				</th>
				<th class="text-center">
					<div data-toogle="tooltip" title="Copy or remove a specific row and its data.">
						Copy / Remove
					</div>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<select name="insert[0][location]" class="form-control input-sm">
						<option value="0">No Shipping Location</option>
					<?php foreach($locations_inline as $location) { ?>
						<option value="<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'id')]; ?>">
							<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')]; ?>
						</option>
					<?php } ?>
					</select>
				</td>
				<td>
					<select name="insert[0][zone]" class="form-control input-sm">
						<option value="0">No Shipping Zone</option>
					<?php foreach($shipping_zones as $zone) { ?>
						<option value="<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')]; ?>">
							<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')]; ?>
						</option>
					<?php } ?>
					</select>
				</td>
				<td>
					<input type="text" name="insert[0][value]" value="" placeholder="NULL" class="form-control input-sm"/>
				</td>
				<td class="text-center">
					<select name="insert[0][banned]" class="form-control input-sm">
						<option value="0">Location Not Banned</option>
						<option value="1">Whitelist Location</option>
						<option value="2">Blacklist Location</option>
					</select>
				</td>
				<td class="text-center">
					<input type="hidden" name="insert[0][separate]" value="0"/>
					<input type="checkbox" name="insert[0][separate]" value="1"/>
				</td>
				<td class="text-center">
					<input type="hidden" name="insert[0][status]" value="0"/>
					<input type="checkbox" name="insert[0][status]" value="1" checked="checked"/>
				</td>
				<td class="text-center">
					<input type="button" value="+" class="copy_row btn btn-sm btn-success"/>
					<input type="button" value="x" disabled="disabled" class="remove_row btn btn-sm btn-danger"/>
				</td>
			</tr>
		</tbody>
	</table>

	<?php echo form_submit('insert_shipping', 'Insert Item Shipping', 'class="btn btn-lg btn-primary"') ?>

<?php echo form_close() ?>

<?php $this->load->view('admin/templates/footer') ?>