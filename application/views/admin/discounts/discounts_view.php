<?php $this->load->view('admin/templates/header', array(
	'title' => 'Discounts',
	'link' => 'discounts',
	'sub_link' => 'summary',
	'breadcrumbs' => array(
		0 => array('name'=>'Discounts','link'=>FALSE),
		1 => array('name'=> 'Item Discounts','link'=>FALSE)
	)
)); ?>

<?php $this->load->view('admin/discounts/discounts_sub_header', array(
	'active' => 'items'
)); ?>

<?php if (empty($discount_data)): ?>
	<div class="alert alert-warning">
		There are no discounts setup to view.
		<?php echo anchor('admin/insert_discount', 'Insert New Discount', 'class="alert-link"') ?>
	</div>
<?php else: ?>
	<?php echo form_open(current_url());?>
		<table class="table table-flat">
			<thead>
				<tr>
					<th>
						<div data-toggle="tooltip" title="Edit the discount settings.">
							Manage
							
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="A short description of the discount.">
							Description
							
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="The number of times remaining that the discount can be used.">
							Usage Limit
							
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="The start date of the discount.">
							Valid Date
							
						</div>
					</th>
					<th>
						<div data-toggle="tooltip" title="The expiry date of the discount.">
							Expire Date
							
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="If checked, the discount will be set as 'active'.">
							Status
							
						</div>
					</th>
					<th class="text-center">
						<div data-toggle="tooltip" title="If checked, the row will be deleted upon the form being updated.">
							Delete
							
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($discount_data as $row):
				$discount_id = $row[$this->flexi_cart_admin->db_column('discounts', 'id')];
				?>
				<tr>
					<td>
						<input type="hidden" name="update[<?php echo $discount_id; ?>][id]" value="<?php echo $discount_id; ?>"/>
						<a href="<?php echo $base_url; ?>admin/update_discount/<?php echo $discount_id; ?>" class="btn btn-sm btn-primary">
							<i class="fa fa-edit"></i>
						</a>
					</td>
					<td>
						<?php echo $row[$this->flexi_cart_admin->db_column('discounts', 'description')]; ?>
					</td>
					<td class="text-center">
						<?php echo $row[$this->flexi_cart_admin->db_column('discounts', 'usage_limit')]; ?>
					</td>
					<td>
						<?php echo date('d-m-Y', strtotime($row[$this->flexi_cart_admin->db_column('discounts', 'valid_date')])); ?>
					</td>
					<td>
						<?php echo date('d-m-Y', strtotime($row[$this->flexi_cart_admin->db_column('discounts', 'expire_date')])); ?>
					</td>
					<td class="text-center">
						<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('discounts', 'status')]; ?>
						<input type="hidden" name="update[<?php echo $discount_id; ?>][status]" value="0"/>
						<input type="checkbox" name="update[<?php echo $discount_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$discount_id.'][status]','1', $status); ?>/>
					</td>
					<td class="text-center">
						<input type="hidden" name="update[<?php echo $discount_id; ?>][delete]" value="0"/>
						<input type="checkbox" name="update[<?php echo $discount_id; ?>][delete]" value="1"/>
					</td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>				
		
		<div class="text-right mt-3">
			<input type="submit" name="update_discounts" value="Update Discounts" class="btn btn-success"/>
		</div>
	<?php echo form_close();?>
<?php endif ?>
	
<?php $this->load->view('admin/templates/footer'); ?>