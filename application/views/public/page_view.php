<?php $this->load->view('public/templates/header', array(
	'title' => $page_data->name,
	'link' => $page_data->slug,
)); ?>

<div class="container">
	<ul class="breadcrumb">
		<li><?php echo $page_data->name ?></li>
	</ul>

	<?php echo $page_data->body ?>
</div>

<?php $this->load->view('public/templates/footer') ?>