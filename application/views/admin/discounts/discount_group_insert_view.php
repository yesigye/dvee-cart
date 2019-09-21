<?php $this->load->view('admin/templates/header', array(
	'title' => 'Discounts',
	'link' => 'discounts',
	'sub_link' => 'add',
	'breadcrumbs' => array(
		0 => array('name'=>'Discounts','link'=>'item_discounts'),
		1 => array('name'=>'Manage Discount Groups','link'=>'discount_groups'),
		2 => array('name'=>'Insert New Discount','link'=>FALSE)
	)
)); ?>

<?php $this->load->view('admin/discounts/discounts_sub_header', array(
	'active' => 'group'
)); ?>

<div class="page-header">
	<h4 class="lead">
		Insert New Discount
		<span class="fa fa-info-sign text-info" style="margin-left:1rem" data-toggle="collapse" data-target="#discount-info"></span>
	</h4>
	<div id="discount-info" class="collapse">
		<p>Discounts can be setup with a wide range of rule conditions that can then be applied to specific items, groups of items or across the entire cart.</p>
		<p>Discount activation rules can be set to check the value and quantity of items in the cart, a customers location and up to three custom statuses within the cart. For example whether a customer has logged in, or is regarded as a new customer.</p>
		<p>Other options include activation and expiry dates, usage limits, voiding of reward points and whether discounts can be combined with other discounts.</p>
		<p>To comply with tax laws in different countries and states, the method of calculating tax on discounted items can be set using one of three methods.</p>
	</div>
</div>
			
<?php if (! empty($message)): ?>
	<?php if (validation_errors()): ?>
		<div class="alert alert-danger">Check the form for errors and try again.</div>
	<?php else: ?>
		<div id="message"><?= $message; ?></div>
	<?php endif ?>
<?php endif ?>
										
<?php echo form_open(current_url()); ?>						
	<table class="table table-striped">
		<thead>
			<tr>
				<th class="info_req tooltip_trigger"
					title="Set the name of the discount item group.">
					Group Name <span class="fa fa-asterisk text-danger" title="required"></span>
				</th>
				<th class="spacer_100 text-center tooltip_trigger" 
					title="If checked, the discount item group will be set as 'active'.">
					Status
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="form-inline form-group <?php echo form_error('insert_group[name]') ? 'has-error' : '' ?>">
					<input type="text" name="insert_group[name]" value="<?php echo set_value('insert_group[name]');?>" class="form-control input-sm"/>
					<?php echo form_error('insert_group[name]') ?>
				</td>
				<td class="text-center">
					<input type="hidden" name="insert_group[status]" value="0"/>
					<input type="checkbox" name="insert_group[status]" value="1" <?php echo set_checkbox('insert_group[status]', '1', TRUE); ?>/>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="5">
					<input type="submit" name="insert_discount_group" value="Insert New Discount Item Group" class="btn btn-primary"/>
				</td>
			</tr>
		</tbody>
	</table>
<?php echo form_close(); ?>						

<?php $this->load->view('admin/templates/footer'); ?>