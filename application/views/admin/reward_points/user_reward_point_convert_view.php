<?php $this->load->view('admin/templates/header', array(
	'title' => 'Reward Points',
	'link' => 'reward_points',
	'breadcrumbs' => array(
		0 => array('name'=>'Reward Points','link'=>FALSE),
	)
)); ?>

<?php $this->load->view('admin/reward_points/reward_points_sub_header'); ?>

<div class="page-header">
	<h4 class="lead">Manage User Reward Points</h4>
	<p>Users can earn reward points when they purchase items. When they earn enough points, they can be converted to a voucher worth a monetary value.</p>
	<p>The voucher is stored as a code in the database that when entered on their next purchase, will deduct the vouchers value from their cart total.</p>
	<p>The conversion and monetary value of reward points and vouchers can all be set via the cart configuration.</p>
</div>
	
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
		
		<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
		<?php } ?>
			
			<h1>Convert Reward Points to Voucher</h1>
			<p>
				<a href="<?php echo $base_url; ?>admin/vouchers">Manage Reward Vouchers</a> | 
				<a href="<?php echo $base_url; ?>admin/user_reward_points">Manage Reward Points</a> | 
				<a href="<?php echo $base_url; ?>admin/user_vouchers/<?php echo $user_data['user_id'];?>">Manage Reward Points for <?php echo $user_data['user_name'];?></a>
			</p>
			
			<div class="w100 frame">
				<?php echo form_open(current_url()); ?>
					<ul>
						<li>
							<h3><?php echo $user_data['user_name'];?> has a total of <?php echo $user_data[$this->flexi_cart_admin->db_column('reward_points','total_points_active')]; ?> active reward points.</h3>
						</li>
						<li>
							<small class="frame_note">
								This demo is setup to require a minimum of 250 reward points per voucher.<br/>
								Multiples of 250 reward points can be combined together to create a higher value voucher.<br/>
								Each point is currently setup to be worth &pound;0.01.<br/><br/>

								Examples:<br/>
								A customer with 320 reward points can only create 1 voucher worth &pound;2.50 (250 points).<br/>
								A customer with 540 reward points can either create 1 voucher worth &pound;5.00 (500 points), or 2 vouchers worth &pound;2.50 each (250 points).<br/>
								All remaining leftover points will remain available in their account for future use, until they expire.
							</small>
						</li>
					<?php if ($conversion_tiers) { ?>
						<li>
							<?php $max_conversion_points = $this->flexi_cart_admin->calculate_conversion_reward_points($user_data[$this->flexi_cart_admin->db_column('reward_points','total_points_active')]); ?>
							<label>Points to Convert:</label>
							<select name="reward_points" class="width_100 tooltip_trigger"
								title="Set the number of points that are to be converted to a reward voucher."
							>
							<?php foreach($conversion_tiers as $value) { ?>
								<option value="<?php echo $value; ?>" <?php echo set_select('reward_points', $value); ?>>
									<?php echo $value; ?>
								</option>
							<?php } ?>
							</select>
							<small>Maximum available for this user is <?php echo $max_conversion_points; ?> points, worth &pound;<?php echo $this->flexi_cart_admin->calculate_reward_point_value($max_conversion_points); ?>.</small>
						</li>
						<li>
							<input type="submit" name="convert_reward_points" value="Convert Points to Voucher" class="link_button large"/>
						</li>
					<?php } else { ?>
						<li>
							<strong>This user does not have enough active reward points to convert to a voucher.</strong>
						</li>
					<?php } ?>
					</ul>
				<?php echo form_close(); ?>
			</div>

		</div>
	</div>
	
<?php $this->load->view('admin/templates/footer'); ?>