<?php $this->load->view('public/templates/header', array(
	'title' => 'Dashboard',
	'link' => 'account',
	'breadcrumbs' => array(
		0 => array('name'=>'Dashboard','link'=>FALSE),
	)
)) ?>

<?php $this->load->view('public/dashboard/dashboard_header', array('active' => FALSE)) ?>

<div class="row">
	<div class="col-md-3">
		<a class="card-link" href="<?php echo site_url('user_dashboard/orders') ?>">
			<div class="card card-body mb-2 text-center border-0 bg-danger text-white">
				<h3 class="text-white-50" style="margin-top:0"><span class="fa fa-briefcase"></span></h3>
				Orders
				<div class="small">manage orders</div>
			</div>
		</a>
	</div>
	<div class="col-md-3">
		<a class="card-link" href="<?php echo site_url('user_dashboard/carts') ?>">
			<div class="card card-body mb-2 text-center border-0 bg-secondary text-white">
				<h3 class="text-white-50" style="margin-top:0"><span class="fa fa-shopping-cart"></span></h3>
				Saved Carts
				<div class="small">manage saved carts</div>
			</div>
		</a>
	</div>
	<div class="col-md-3">
		<a class="card-link" href="<?php echo site_url('user_dashboard/points_vouchers') ?>">
			<div class="card card-body mb-2 text-center border-0 bg-success text-white">
				<h3 class="text-muted" style="margin-top:0"><span class="fa fa-tags"></span></h3>
				Vouchers
				<div class="small">points & vouchers</div>
			</div>
		</a>
	</div>
	<div class="col-md-3">
		<a class="card-link" href="<?php echo site_url('user_dashboard/points_vouchers') ?>">
			<div class="card card-body mb-2 text-center border-0 bg-success text-white">
				<h3 class="text-white-50" style="margin-top:0"><span class="fa fa-gift"></span></h3>
				Reward Points
				<small><strong><?php echo $reward_points ?></strong> total active points</small>
			</div>
		</a>
	</div>
</div>

</div>
</div>
</div>

<?php $this->load->view('public/templates/footer') ?>