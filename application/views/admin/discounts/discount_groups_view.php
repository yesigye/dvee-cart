<?php $this->load->view('admin/templates/header', array(
	'title' => 'Discounts',
	'link' => 'discounts',
	'sub_link' => 'groups',
	'breadcrumbs' => array(
		0 => array('name'=>'Discounts','link'=>'item_discounts'),
		1 => array('name'=>'Discount Item Groups','link'=>FALSE)
	)
)); ?>

<?php $this->load->view('admin/discounts/discounts_sub_header', array(
	'active' => 'group'
)); ?>
	
<?php if (! empty($message)) { ?>
	<div id="message">
		<?php echo $message; ?>
	</div>
<?php } ?>
									
<?php if (empty($discount_group_data)): ?>
	<div class="alert alert-warning">
		There are no discount item groups setup to view.
		<?php echo anchor('admin/insert_discount_group', 'Insert New Discount Item Group', 'class="alert-link"') ?>
	</div>	
<?php else: ?>
	<?php echo form_open(current_url());?>
		<table class="table table-flat table-striped">
			<thead>
				<tr>
					<th class="info_req tooltip_trigger"
						title="Set the name of the discount item group.">
						Group Name
						<small>
							<span class="fa fa-asterisk text-danger"></span>
						</small>
					</th>
					<th class="text-center"
						title="Manage items within the discount item group.">
						Manage
					</th>
					<th class="text-center" 
						title="If checked, the discount item group will be set as 'active'.">
						Status
					</th>
					<th class="text-center" 
						title="If checked, the row will be deleted upon the form being updated.">
						Delete
					</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach ($discount_group_data as $row) {
					$disc_group_id = $row[$this->flexi_cart_admin->db_column('discount_groups', 'id')];
				?>
				<tr>
					<td>
						<input type="hidden" name="update[<?php echo $disc_group_id; ?>][id]" value="<?php echo $disc_group_id; ?>" />
						<input type="text" name="update[<?php echo $disc_group_id; ?>][name]" value="<?php echo set_value('update['.$disc_group_id.'][name]', $row[$this->flexi_cart_admin->db_column('discount_groups', 'name')]); ?>" class="form-control"/>
					</td>
					<td class="text-center">
						<a href="<?php echo $base_url; ?>admin/update_discount_group/<?php echo $disc_group_id; ?>" class="btn btn-info">
							<span class="fa fa-edit"></span> Items
						</a>
						<a href="<?php echo $base_url; ?>admin/insert_discount_group_items/<?php echo $disc_group_id; ?>" class="btn btn-success">
							<span class="fa fa-plus"></span> Items
						</a>
					</td>
					<td class="text-center">
						<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('discount_groups', 'status')]; ?>
						<input type="hidden" name="update[<?php echo $disc_group_id; ?>][status]" value="0"/>
						<input type="checkbox" name="update[<?php echo $disc_group_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$disc_group_id.'][status]','1', $status); ?>/>
					</td>
					<td class="text-center">
						<input type="hidden" name="update[<?php echo $disc_group_id; ?>][delete]" value="0"/>
						<input type="checkbox" name="update[<?php echo $disc_group_id; ?>][delete]" value="1"/>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		
		<input type="submit" name="update_discount_groups" value="Update Discount Item Groups" class="btn btn-primary"/>
	<?php echo form_close();?>
<?php endif ?>

<?php $this->load->view('admin/templates/footer'); ?>