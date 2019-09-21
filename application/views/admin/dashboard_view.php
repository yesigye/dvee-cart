<?php $this->load->view('admin/templates/header'); ?>
	
<?php if (! empty($message)) { ?>
	<div id="message">
		<?php echo $message; ?>
	</div>
<?php } ?>

<div class="row">
	<div class="col-md-6">
		<div class="card mb-3">
			<div class="card-header">
				<div class="float-left">Latest Users</div>
				<a href="<?php echo site_url('admin/users') ?>" class="float-right">All Users</a>
				<div class="clearfix"></div>
			</div>
			<?php if ($latest_users): ?>
				<div class="card-body text-center">
					<div class="row">
						<?php foreach ($latest_users as $key => $user): ?>
							<div class="col-md-4">
								<a href="<?php echo site_url('admin/update_user/'.$user->id) ?>">
									<div>
										<img src="<?php echo $user->avatar ?>" class="img-circle" style="width:50px">
									</div>
									<?php echo character_limiter($user->username, 20) ?>
								</a>
								<div class="text-muted small">
									Joined: <?php echo $user->created ?>
								</div>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			<?php else: ?>
				<div class="card-body text-muted">
					No users have registered yet.
				</div>
			<?php endif ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-4">
				<a href="<?php echo site_url('admin/users') ?>" class="card card-link ml-0 mb-3 card-body border-0 bg-warning text-dark">
					<div class="card-title small">Users</div>
					<i class="fa fa-users back-drop"></i>
					<h4><?php echo $users_total ?></h4>
				</a>
			</div>
			<div class="col-md-4">
				<a href="<?php echo site_url('admin/items') ?>" class="card card-link ml-0 mb-3 card-body border-0 bg-success text-white">
					<div class="card-title small">Products</div>
					<i class="fa fa-users back-drop"></i>
					<h4><?php echo $products_total ?></h4>
				</a>
			</div>
			<div class="col-md-4">
				<a href="<?php echo site_url('admin/items') ?>" class="card card-link ml-0 mb-3 card-body border-0 bg-danger text-white">
					<div class="card-title small">Orders</div>
					<i class="fa fa-briefcase back-drop"></i>
					<h4>&pound <?php echo $order_total ?></h4>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-8">
		<div class="card mb-3">
			<div class="card-header">
				Order Revenue
			</div>
			<div class="card-body">
				<div id="line-chart" style="height: 240px;"></div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card mb-3">
			<div class="card-header">
				<div class="float-left">Latest products</div>
				<a href="<?php echo site_url('admin/items') ?>" class="float-right">All Products</a>
				<div class="clearfix"></div>
			</div>
			<?php if ($latest_products): ?>
				<div class="card-body">
					<?php foreach ($latest_products as $key => $item): ?>
						<a class="card-link m-0" href="<?php echo site_url('admin/update_item/'.$item->id) ?>">
						<div class="media mr-2 <?php echo ($key > 0) ? 'mt-3' : '' ?>">
							<img src="<?php echo $item->thumb ?>" class="media-object" style="width:50px">
							<div class="media-left text-truncate">
								<?php echo $item->name ?>
								<h5>&pound <?php echo $item->price ?></h5>
							</div>
						</div>
						</a>
					<?php endforeach ?>
				</div>
			<?php else: ?>
				<div class="alert alert-warning" style="margin:0">
					You have no items yet.
					<?php echo anchor('admin/insert_item', 'Insert Items', 'class="alert-link"') ?>
				</div>
			<?php endif ?>
		</div>
	</div>
</div>

<script>
    $(document).ready(function() {
		var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

		Morris.Line({
		  element: 'line-chart',
		  data: JSON.parse('<?php echo $order_data ?>'),
		  xkey: 'month',
		  ykeys: ['sales'],
		  labels: ['Sales'],
		  xLabelFormat: function(x) { // <--- x.getMonth() returns valid index
		    var month = months[x.getMonth()];
		    return month;
		  },
		  dateFormat: function(x) {
		    var month = months[new Date(x).getMonth()];
		    return month;
		  },
		});
	});
</script>
	
<?php $this->load->view('admin/templates/footer'); ?>