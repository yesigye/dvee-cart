<?php $this->load->view('admin/templates/header', array(
	'title' => 'Update Discount Group',
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

<div class="page-header lead b-0">
	Update Discount Group
	"<?php echo set_value('update_group[name]', $group_data[$this->flexi_cart_admin->db_column('discount_groups', 'name')]); ?>"
</div>
			
<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>
										
<?php echo form_open(current_url());?>
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="fa fa-file" style="margin-right:10px"></span>
					Discount Group Details
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label">Group Name</label>
						<input type="text" name="update_group[name]" value="<?php echo set_value('update_group[name]', $group_data[$this->flexi_cart_admin->db_column('discount_groups', 'name')]); ?>" class="form-control"/>
					</div>
					<div class="form-group">
						<label class="control-label">Status</label>
						<div class="checkbox">
							<label class="control-label">
								<?php $status = (bool) $group_data[$this->flexi_cart_admin->db_column('discount_groups', 'status')]; ?>
								<input type="hidden" name="update_group[status]" value="0"/>
								<input type="checkbox" name="update_group[status]" value="1" <?php echo set_checkbox('update_group[status]','1', $status); ?>/>
								Active
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-9">
			<div class="page-header b-0" style="margin-top:0">
				<div class="lead float-left mb-3">Discount Group Items</div>
				<a href="<?php echo site_url('admin/insert_discount_group_items/'.$group_data[$this->flexi_cart_admin->db_column('discount_groups', 'id')]) ?>" class="btn btn-primary float-right">
					<span class="fa fa-plus"></span>
					Group Items
				</a>
				<div class="clearfix"></div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					Discount Group Items
				</div>
				<?php if (empty($group_item_data)): ?>
					<div class="alert alert-warning" style="margin:0">
						There are no items in this discount item group.
						<?php echo anchor('admin/insert_discount_group_items/'.$group_data[$this->flexi_cart_admin->db_column('discount_groups', 'id')], 'Insert Items to Discount Item Group', 'class="alert-link"') ?>
					</div>
				<?php else: ?>
				<div class="panel-body">
					<table class="table table-striped" style="margin:0">
						<thead>
							<tr>
								<th class="text-center">Thumb</th>
								<th>Name</th>
								<th class="text-center">Quantity</th>
								<th class="text-center">Price</th>
								<th class="text-center text-danger">
									Remove
								</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($group_item_data as $item): ?>
							<tr>
								<td class="text-center">
									<img src="<?php echo base_url($item['thumb']) ?>" alt="" style="height:30px">
								</td>
								<td><?php echo $item['name'] ?></td>
								<td class="text-center"><?php echo $item['quantity'] ?></td>
								<td class="text-center"><?php echo $item['price'] ?></td>
								<td class="text-center">
									<input type="hidden" name="delete_item[<?php echo $item['id'] ?>][delete]" value="0"/>
									<input type="checkbox" name="delete_item[<?php echo $item['id'] ?>][delete]" value="1"/>
								</td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
				</div>
				<?php endif ?>
			</div>
		</div>
	</div>
	<input type="submit" name="update_discount_group_items" value="Update Discount Item Group and Items" class="btn btn-success"/>
<?php echo form_close() ?>

<?php $this->load->view('admin/templates/footer'); ?>