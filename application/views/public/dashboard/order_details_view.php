<?php $this->load->view('public/templates/header', array(
	'title' => 'Dashboard',
	'link' => 'account',
)) ?>

<?php $this->load->view('public/dashboard/dashboard_header', array('active' => 'orders')) ?>

<div class="bg-secondary container text-white py-4">
	<div class="row">
		<div class="col-md-6">
			<div class="h4"><?php echo $summary_data['ord_order_number']; ?></div>
			<div class="text-white-50 mb-2">
				<?php echo $summary_data['ord_date']; ?>
			</div>
			<?php
				$ord_badge_class = 'info'; // default order status badge contextual class
				if ($summary_data['ord_status'] == 1) $ord_badge_class = 'danger';
			?>
			<span class="badge badge-<?php echo $ord_badge_class ?>">
				<?php echo $summary_data['ord_status_description'] ?>
			</span>
		</div>
		<div class="col-md-3">
			<?php echo $summary_data['ord_demo_ship_name'];?> <br>
			<?php echo $summary_data['ord_demo_email'];?> <br>
			<?php echo $summary_data['ord_demo_phone'];?>
		</div>
		<div class="col-md-3 text-right">
			<?php echo $summary_data['ord_demo_ship_address_01'];?> <br>
			<?php echo $summary_data['ord_demo_ship_city'];?> <br>
			<?php echo $summary_data['ord_demo_ship_state'];?> <br>
			<?php echo $summary_data['ord_demo_ship_country'];?> <br>
			<?php echo $summary_data['ord_demo_ship_post_code'];?>
		</div>
	</div>
</div>
<div class="bg-success text-white px-3 py-2">
	<b>
		<?php echo number_format($summary_data['ord_total_reward_points']);?>
	</b>
	reward points earned
</div>
<div class="row py-3">
	<div class="col-md-6">
		<?php echo $summary_data['ord_demo_bill_address_01'];?> <br>
		<?php echo $summary_data['ord_demo_bill_city'];?> <br>
		<?php echo $summary_data['ord_demo_bill_state'];?> <br>
		<?php echo $summary_data['ord_demo_bill_country'];?> <br>
		<?php echo $summary_data['ord_demo_bill_post_code'];?>
	</div>
	<div class="col-md-3">
		<div class="text-muted">Currency </div>
		<?php echo $summary_data['ord_currency'];?>
		<div class="text-muted mt-3">Exchange Rate </div>
		<?php echo $summary_data['ord_exchange_rate']; ?>
	</div>
	<div class="col-md-3 text-right">
		<div class="text-muted">Order total</div>
		<h2 class="text-muted"><?php echo $summary_data['ord_total']; ?></h2>
	</div>
</div>

<hr class="mb-0 border-secondary">
							
<?php echo form_open(current_url()); ?>
	<?php if (empty($item_data)): ?>
	<div class="my-3 text-muted">There are no items associated with this order</div>
	<?php else: ?>
	<div class="table-responsive border-top border-secondary">
		<table id="cart_items" class="table border-0 table-striped">
			<thead>
				<tr>
					<th>Item</th>
					<th class="text-center">Price</th>
					<th class="text-center" title="Indicates the total quantity of items that were ordered.">
						Ordered
					</th>
					<th class="text-center" title="Indicates the quantity of items that have been marked as 'shipped'. Shipped items activate their associated reward points.">
						Shipped
					</th>
					<th class="text-center" title="Indicates the quantity of items that have been marked as 'cancelled'. Cancelled items are returned to stock.">
						Cancelled
					</th>
					<th class="text-right">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($item_data as $row): ?>
				<tr>
					<td>
						<!-- Item Name -->
						<?php echo $row[$this->flexi_cart_admin->db_column('order_details', 'item_name')];?>

						<!-- Display an item status message if it exists -->
						<?php 
							echo (! empty($row[$this->flexi_cart_admin->db_column('order_details', 'item_status_message')])) ? 
								'<br/><span class="text-danger">'.$row[$this->flexi_cart_admin->db_column('order_details', 'item_status_message')].'</span>' : NULL; 
						?>
						
						<!-- Display an items options if they exist -->
						<div class="small text-muted">
							<?php 
								echo (! empty($row[$this->flexi_cart_admin->db_column('order_details', 'item_options')])) ? $row[$this->flexi_cart_admin->db_column('order_details', 'item_options')] : NULL; 
							?>
						</div>
						
						<!-- 
							Display an items user note if it exists
							Note: This is a optional custom field added to this cart demo and is not defined via the cart config file.
						-->										
						<?php echo (! empty($row['ord_det_demo_user_note'])) ? '<br/>Note: '.$row['ord_det_demo_user_note'] : NULL; ?>
					</td>
					<td class="text-center">
						<span title="includes tax of <?php echo $row['tax'] ?>">
							<?php if ($row['discount'] !== $row['price']): ?>
							<s class="d-block text-danger"><?php echo $row['price'] ?></s> <?php echo $row['discount'] ?>
							<?php else: ?>
							<?php echo $row['price'] ?>
							<?php endif ?>
						</span>
					</td>
					<td class="text-center"><?php echo $row['quantity'] ?></td>
					<td class="text-center"><?php echo $row['quantity_shipped'] ?></td>
					<td class="text-center"><?php echo $row['quantity_cancelled'] ?></td>
					<td class="text-right"><?php echo $row['price_total'] ?></td>
				</tr>
				<?php 
				// If an item discount exists.
				if (! empty($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_description')])): ?>
				<tr class="discount">
					<td colspan="6">
						Discount: <?php echo $row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_description')];?>
					</td>
				</tr>
				<?php endif ?>
				<?php endforeach ?>
			</tbody>
			<tfoot>
			<?php if ($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')] > 0): ?>
				<tr class="discount">
					<th colspan="5">Item Summary Discount Total</th> 
					<td class="text-center"><?php echo $summary_data['ord_item_summary_savings_total']; ?></td>
				</tr>
			<?php endif ?>
			</tfoot>
		</table>
	</div>
	<?php endif ?>
	
	<table class="table table-borderless mt-3" id="cart_summary">
		<tbody>
			<tr class="text-muted bg-light">
				<th colspan="7">
					<?php echo 'Tax @ '.$summary_data['ord_tax_rate'].'%' ?>
					<div class="small font-weight-normal">Tax is calculated on the item price</div>
				</th>
				<td class="text-right"><?php echo $summary_data['ord_tax_total'] ?></td>
			</tr>

			<tr>
				<th colspan="7">Sub Total</th>
				<td class="text-right"><?php echo $summary_data['ord_item_summary_total'] ?></td>
			</tr>

			<tr>
				<th colspan="7">
					Shipping
					<div class="small text-muted">
						<?php echo $summary_data['ord_total_weight']; ?> grams
						<br>
						<?php echo $summary_data['ord_shipping']; ?>
					</div>
				</th>
				<td class="text-right"><?php echo $summary_data['ord_shipping_total']; ?></td>
			</tr>

			<?php if ($summary_data['has_savings']): ?>
			<!-- Item discounts -->
			<tr class="discount">
				<th>
					Item discounts
					<div class="small text-muted"><?php echo $summary_data['ord_summary_discount_desc']; ?></div>
				</th>
				<td><?php echo $summary_data['ord_item_summary_savings_total']; ?></td>
			</tr>
		
			<!-- Total of all discounts -->
			<tr class="discount">
				<th colspan="7">Savings</th>
				<td class="text-right"><?php echo $summary_data['ord_savings_total'] ?></td>
			</tr>
			<?php endif ?>

			<?php if ($summary_data['has_surcharge']): ?>
			<!-- Display summary of all surcharges -->
			<tr class="surcharge">
				<th>
					Surcharge
					<div class="small text-muted"><?php echo $summary_data['ord_surcharge_desc']; ?></div>
				</th>
				<td class="text-right"><?php echo $summary_data['ord_surcharge_total'] ?></td>
			</tr>
			<?php endif ?>
			
			<?php if ($summary_data['has_voucher']): ?>
			<!-- Display summary of all reward vouchers -->
			<tr class="voucher">
				<th>
					Voucher
					<div class="small text-muted"><?php echo $summary_data['ord_reward_voucher_desc']; ?></div>
				</th>
				<td class="text-right"><?php echo $summary_data['ord_reward_voucher_total'] ?></td>
			</tr>
			<?php endif ?>

			<tr class="grand_total">
				<th colspan="7">Grand Total</th>
				<td class="text-right"><?php echo $summary_data['ord_total'] ?></td>
			</tr>
		</tbody>
	</table>
<?php echo form_close(); ?>

</div>
</div>
</div>

<?php $this->load->view('public/templates/footer') ?>