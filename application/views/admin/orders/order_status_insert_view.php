<?php $this->load->view('admin/templates/header', array(
	'title' => 'Orders',
	'link' => 'orders',
	'sub_link' => 'add_status',
	'breadcrumbs' => array(
		0 => array('name'=>'Orders','link'=>'orders'),
		1 => array('name'=>'Order Statuses','link'=>'order_status'),
		2 => array('name'=>'Add Order Status','link'=>FALSE),
	)
)); ?>

<div class="page-header b-0">
	<h4 class="lead">Insert New Order Status</h4>
</div>

<?php if (! empty($message)) { ?>
	<div id="message"><?= $message; ?></div>
<?php } ?> 

<?php echo form_open(current_url()); ?>
	<table class="table table-flat table-striped">
		<thead>
			<tr>
				<th>
					<div data-toggle="tooltip" title="The name/description of the order status.">
						Status Description <span class="fa fa-info-sign"></span>
					</div>
				</th>
				<th class="text-center">
					<div data-toggle="tooltip" title="If checked, it indicates that the order status 'Cancels' the order.">
						Cancel Order <span class="fa fa-info-sign"></span>
					</div>
				</th>
				<th class="text-center">
					<div data-toggle="tooltip" title="If checked, it indicates that the order status is the default status that is applied to a 'saved' order.">
						Save Default <span class="fa fa-info-sign"></span>
					</div>
				</th>
				<th class="text-center">
					<div data-toggle="tooltip" title="If checked, it indicates that the order status is the default status that is applied to a 'resaved' order.">
						Resave Default <span class="fa fa-info-sign"></span>
					</div>
				</th>
				<th class="text-center">
					<div data-toggle="tooltip" title="Copy or remove a specific row and its data.">
						Copy / Remove
					</div>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php  for($i = 0; ($i == 0 || (isset($validation_row_ids[$i]))); $i++): $row_id = (isset($validation_row_ids[$i])) ? $validation_row_ids[$i] : $i; ?>
			<tr>
				<td>
					<input type="text" name="insert[<?php echo $row_id; ?>][status]" value="<?php echo set_value('insert['.$row_id.'][status]');?>" class="form-control"/>
				</td>
				<td class="text-center">
					<input type="hidden" name="insert[<?php echo $row_id; ?>][cancelled]" value="0"/>
					<input type="checkbox" name="insert[<?php echo $row_id; ?>][cancelled]" value="1" <?php echo set_checkbox('insert['.$row_id.'][cancelled]', '1', FALSE); ?>/>
				</td>
				<td class="text-center">
					<input type="hidden" name="insert[<?php echo $row_id; ?>][save_default]" value="0"/>
					<input type="checkbox" name="insert[<?php echo $row_id; ?>][save_default]" value="1" <?php echo set_checkbox('insert['.$row_id.'][save_default]', '1', FALSE); ?>/>
				</td>
				<td class="text-center">
					<input type="hidden" name="insert[<?php echo $row_id; ?>][resave_default]" value="0"/>
					<input type="checkbox" name="insert[<?php echo $row_id; ?>][resave_default]" value="1" <?php echo set_checkbox('insert['.$row_id.'][resave_default]', '1', FALSE); ?>/>
				</td>
				<td class="text-center">
					<input type="button" value="+" class="copy_row btn btn-primary"/>
					<input type="button" value="x" <?php echo ($i == 0) ? 'disabled="disabled"' : NULL;?> class="remove_row btn btn-primary"/>
				</td>
			</tr>
			<?php endfor ?>
		</tbody>
	</table>
	
	<input type="submit" name="insert_order_status" value="Insert Order Status" class="btn btn-primary"/>
<?php echo form_close(); ?>

<script type="text/javascript">
	$('.remove_row').click(function(){
		var row = $(this).closest('tr');
		row.addClass('animated zoomOut');
		setTimeout(function(){ row.remove(); }, 50);
	})
</script>		

<?php $this->load->view('admin/templates/footer'); ?>