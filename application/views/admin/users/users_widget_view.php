
<?php echo form_open(current_url()) ?>
	<p class="clearfix">
		<div class="float-left">
			<button type="submit" name="delete_selected" value="Delete Selected" class="btn btn-sm btn-danger">
				<span class="fa fa-times"></span> Selected
			</button>
			<a href="<?= site_url('admin/insert_user') ?>" class="btn btn-sm btn-success">
				<span class="fa fa-plus"></span> User
			</a>
		</div>

		<div class="navbar-form float-right" style="padding:0;margin:0;">
			<div class="form-group input-group">
				<input type="text" name="q" class="form-control" placeholder="Type Keywords" value="<?php echo $this->input->get('q') ?>">
				<span class="input-group-btn">
					<div class="btn-group" role="group" aria-label="Basic example">
						<button type="submit" name="search" value="SEARCH" class="btn btn-sm btn-primary">
							<span class="fa fa-search"></span>
						</button>
					</div>
				</span>
			</div>
		</div>
	</p>

	<div class="table-responsive">
		<table class="table table-striped">
			<thead class="bg-light">
				<tr>
					<th class="text-center"><?php echo form_checkbox('select_all') ?></th>
					<th class="text-center"><span class="fa fa-picture"></span></th>
					<th>Username</th>
					<th>Email</th>
					<th class="text-center">Status</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			</tbody>
				<?php foreach ($users as $user):?>
					<tr id="<?= $user->id ?>" class="<?= ($this->ion_auth->is_admin($user->id)) ? 'danger' : '' ?>">
						<td class="text-center"><?php echo form_checkbox('selected[]', $user->id) ?></td>
						<td class="text-center"><img src="<?php echo base_url($user->avatar) ?>" alt="" style="width:28px" class="img-circle"></td>
						<td><?= $user->username ?></td>
						<td><?= $user->email ?></td>
						<td class="text-center">
							<?php if($user->active): ?>
								<span class="badge badge-success">active</span>
							<?php else: ?>
								<span class="badge badge-warning">inactive</span>
							<?php endif ?>
						</td>
						<td class="text-center">
							<div class="btn-group" style="width:100px">
								<?php if (in_array('edit', $action)): ?>
								<?= anchor('admin/update_user/'.$user->id, '<i class="fa fa-edit"></i>', 'class="btn btn-sm btn-info" title="Edit user information"') ?>
								<?php endif ?>
								
								<?php if ($user->active): ?>
								<button type="button" class="btn btn-sm btn-warning deactivate-user" title="Deactivate user">
									<i class="fa fa-ban"></i>
								</button>
								<?php else: ?>
								<button type="button" class="btn btn-sm btn-success activate-user" title="Activate user">
									<i class="fa fa-ok"></i>
								</button>
								<?php endif ?>

								<?php if (in_array('insert', $action)): ?>
								<button type="button" class="btn btn-sm btn-default insert-user" title="add user to facility">
									<i class="fa fa-plus"></i>
								</button>
								<?php else: ?>
								<?php if (in_array('remove', $action)): ?>
								<button type="button" class="btn btn-sm btn-default remove-user" title="remove user from facility">
									<i class="fa fa-minus"></i>
								</button>
								<?php endif ?>
								<?php endif ?>
								
								<?php if (in_array('delete', $action)): ?>
								<button type="button" class="btn btn-sm btn-danger" id="delete-user-btn-<?php echo $user->id ?>" title="delete user">
									<i class="fa fa-times"></i>
								</button>
								<?php endif ?>
			                </div>
							<script type="text/javascript">
								$('#delete-user-btn-<?php echo $user->id ?>').click(function(){
									$('#delete-user-<?php echo $user->id ?>').modal('toggle')
								})
							</script>
			                <div class="modal fade" id="delete-user-<?= $user->id ?>">
			                    <div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">
												<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
											</button>
											<h4 class="modal-title" id="myModalLabel">
												Delete User
											</h4>
										</div>
										<div class="modal-body">
											<img src="<?= $user->avatar ?>" class="thumbnail img-responsive" style="width:65px;margin-bottom:20px;">
											<p>Are you sure you want to delete the user '<?php echo $user->username ?>'</p>
										</div>
										<div class="modal-footer">
											<button type="button" name="" value="1" class="btn btn-danger btn-block delete-user" data-dismiss="modal" data-id="<?= $user->id ?>">
												Delete
											</button>
										</div>
									</div>
								</div>
			                </div>
						</td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>

	<?php if ($pagination): ?>
	    <hr>
	    <?php echo $pagination ?>
	<?php endif ?>
<?php echo form_close() ?>

<script>
	$(document).ready(function() {
		//select all checkboxes
		$('input[name="select_all"]').change(function(){  //"select all" change 
			var status = this.checked; // "select all" checked status
			$('input[name="selected[]"]').each(function(){ //iterate all listed checkbox items
			    this.checked = status; //change ".checkbox" checked status
			});
		});

		$('input[name="selected[]"]').change(function(){ //".checkbox" change 
			//uncheck "select all", if one of the listed checkbox item is unchecked
			if(this.checked == false){ //if this item is unchecked
			    $("#select_all")[0].checked = false; //change "select all" checked status to false
			}

			//check "select all" if all checkbox items are checked
			if ($('input[name="selected[]"]:checked').length == $('input[name="selected[]"]').length ){ 
			    $("#select_all")[0].checked = true; //change "select all" checked status to true
			}
		});

		// Activating data.
		$('.activate-user').click(function () {

			var ID = $(this).closest('tr').attr('id');
			var button = $(this);

			$.ajax({
				type: 'POST',
				data: {
					<?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash() ?>',
                    activate_user: true,
                    id: ID
				},
				url: '<?php echo base_url(); ?>admin/users',
				cache: true,
				beforeSend: function(){
					button.html('<span class="fa fa-refresh spinner"></span>')
				},
				success: function(response) {
					
					response = JSON.parse(response)
					
	                if(response.type) {
						if (response.type === 'success') {
							button.html('<i class="fa fa-ban"></i>')
							button.removeClass('activate-user btn-success')
							button.addClass('deactivate-user btn-warning')
							button.attr('title', 'Deactivate user')
							button.attr('data-original-title', 'Deactivate user')
						}else {
							$('#ajax-alert-modal #message').html(response.message)
							$('#ajax-alert-modal').modal('show')
							button.html('<i class="fa fa-ok"></i>')
						}
					}
				},
				error: function() {
					$('#ajax-alert-modal #message').html('An error Occured')
					$('#ajax-alert-modal').modal('show')
					button.html('<i class="fa fa-ok"></i>')
				}
			});
		});

		// Deactivating data.
		$('.deactivate-user').click(function () {

			var ID = $(this).closest('tr').attr('id');
			var button = $(this);

			$.ajax({
				type: 'POST',
				data: {
					<?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash() ?>',
                    deactivate_user: true,
                    id: ID
				},
				url: '<?php echo base_url(); ?>admin/users',
				cache: true,
				beforeSend: function(){
					button.html('<span class="fa fa-refresh spinner"></span>')
				},
				success: function(response) {
					
					response = JSON.parse(response)
					
	                if(response.type) {
						if (response.type === 'success') {
							button.html('<i class="fa fa-ok"></i>')
							button.removeClass('deactivate-user btn-warning')
							button.addClass('activate-user btn-success')
							button.attr('title', 'Activate user')
							button.attr('data-original-title', 'Activate user')
						}else {
							$('#ajax-alert-modal #message').html(response.message)
							$('#ajax-alert-modal').modal('show')
							button.html('<i class="fa fa-ban"></i>')
						}
					}
				},
				error: function() {
					$('#ajax-alert-modal #message').html('An error Occured')
					$('#ajax-alert-modal').modal('show')
					button.html('<i class="fa fa-ban"></i>')
				}
			});
		});
		
		<?php if (in_array('insert', $action)): ?>
		// Inserting data.
		$('.insert-user').click(function () {

			var ID = table<?php echo $widget_key ?>.row($(this).parents('tr')).id();
			var button = $(this);

			$.ajax({
				type: 'POST',
				data: {
					<?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash() ?>',
                    insert_user: true,
                    company_id: '<?php echo $facility->id ?>',
                    doctor_id: ID
				},
				url: '<?php echo base_url("admin/users"); ?>',
				cache: true,
				beforeSend: function(){
					button.html('<span class="fa fa-refresh spinner"></span>')
				},
				success: function(response) {
					
					response = JSON.parse(response)
					
	                if(response.type) {
						if (response.type === 'success') {
							button.parents('tr').addClass('animated zoomOut');
							setTimeout(function(){
								table<?php echo $widget_key ?>.row( button.parents('tr') ).remove().draw();

								$('#ajax-alert-modal #message').html('Reloading Doctors <i class="fa fa-refresh spinner"></i>')
								$('#ajax-alert-modal').modal('show')

								// Reload page when modal closes
								$('#add-facility-doctor-modal').on('hidden.bs.modal', function (e) {
								    window.location.reload();
								})
		                    }, 400)
						}else {
							$('#ajax-alert-modal #message').html(response.message)
							$('#ajax-alert-modal').modal('show')
							button.html('<i class="fa fa-times"></i>')
						}
					}
				},
				error: function() {
					$('#ajax-alert-modal #message').html('An error Occured')
					$('#ajax-alert-modal').modal('show')
					button.html('<i class="fa fa-times"></i>')
				}
			});
		});
		<?php else: ?>
		<?php if (in_array('remove', $action)): ?>
		// Removing data.
		$('.remove-user').click(function () {

			var ID = table<?php echo $widget_key ?>.row($(this).parents('tr')).id();
			var button = $(this);

			$.ajax({
				type: 'POST',
				data: {
					<?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash() ?>',
                    remove_user: true,
                    company_id: '<?php echo $facility->id ?>',
                    doctor_id: ID
				},
				url: '<?php echo base_url("admin/users"); ?>',
				cache: true,
				beforeSend: function(){
					button.html('<span class="fa fa-refresh spinner"></span>')
				},
				success: function(response) {
					
					response = JSON.parse(response)
					
	                if(response.type) {
						if (response.type === 'success') {
							button.parents('tr').addClass('animated zoomOut');
							setTimeout(function(){
								table<?php echo $widget_key ?>.row( button.parents('tr') ).remove().draw();
		                    }, 400)
						}else {
							$('#ajax-alert-modal #message').html(response.message)
							$('#ajax-alert-modal').modal('show')
							button.html('<i class="fa fa-times"></i>')
						}
					}
				},
				error: function() {
					$('#ajax-alert-modal #message').html('An error Occured')
					$('#ajax-alert-modal').modal('show')
					button.html('<i class="fa fa-times"></i>')
				}
			});
		});
		<?php endif ?>
		<?php endif ?>

		// Deleting data.
		$('.delete-user').click(function () {

			var ID = $(this).attr('data-id');
			var button = $(this);

			$.ajax({
				type: 'POST',
				data: {
					<?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash() ?>',
                    delete_user: true,
                    id: ID
				},
				url: '<?php echo base_url(); ?>admin/users',
				cache: true,
				beforeSend: function(){
				},
				success: function(response) {
					
					response = JSON.parse(response)
					
	                if(response.type) {
						if (response.type === 'success') {
							button.closest('table tr[id="'+ID+'"]').addClass('animated zoomOut');
							setTimeout(function(){
								button.closest('table tr[id="'+ID+'"]').remove();
		                    }, 400)
						}else {
							$('#ajax-alert-modal #message').html(response.message)
							$('#ajax-alert-modal').modal('show')
						}
					}
				},
				error: function() {
					$('#ajax-alert-modal #message').html('An error Occured')
					$('#ajax-alert-modal').modal('show')
				}
			});
		});

		<?php if (in_array('insert', $action)): ?>

		// Inserting multi-selected data.
		$('#key<?php echo $widget_key ?>-data-table-ctrls .insert-selected-user').click(function () {

			var IDs = [];
			$('#key<?php echo $widget_key ?>-data-table-ctrls input[name="selected_ids[]"]').each(function() { IDs.push($(this).val()); });

			var button = $(this);

			if (IDs.length) {

				$.ajax({
					type: 'POST',
					data: {
						<?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash() ?>',
                        add_company_doctors: true,
                        selected: IDs,
                        id: '<?php echo $facility->id ?>'
					},
					url: '<?php echo base_url("admin/healthcare/edit_facility/".$facility->id); ?>',
					cache: true,
					beforeSend: function(){
						button.html('<span class="fa fa-refresh spinner"></span>')
					},
					success: function(response) {
						
						$('body').append(response)
						response = JSON.parse(response)
						
		                if(response.type) {
							
							if (response.type === 'success') {

								$('#key<?php echo $widget_key ?>-data-table-ctrls input[name="selected_ids[]"]').each(function() {

									var row = $( 'tr#'+$(this).val() );
									row.addClass('animated zoomOut');
									setTimeout(function(){
										table<?php echo $widget_key ?>.row( row ).remove().draw();

										$('#ajax-alert-modal #message').html('Reloading Doctors <i class="fa fa-refresh spinner"></i>')
										$('#ajax-alert-modal').modal('show')

										// Reload page when modal closes
										$('#add-facility-doctor-modal').on('hidden.bs.modal', function (e) {
										    window.location.reload();
										})
				                    }, 400)
									$('#key<?php echo $widget_key ?>-data-table-ctrls .multi-select-inputs').html('');
									var template = '<span class="text-muted">0 selected. To select an item, Click the checkboxes in the table below</span>';
									$('#key<?php echo $widget_key ?>-data-table-ctrls .multi-select-count').html(template);
								});

							}else {

								$('#ajax-alert-modal #message').html(response.message)
								$('#ajax-alert-modal').modal('show')
							}
						}
						button.html('Add Selected')
					},
					error: function(response) {
						$('body').append(response)
						button.html('Add Selected')
					}
				});
			}else{

				$('#ajax-alert-modal #message').html('Please select doctors and try again.')
				$('#ajax-alert-modal').modal('show')
			};
		});
		<?php endif; ?>

		<?php if (in_array('remove', $action)): ?>

		// Removing multi-selected data.
		$('#key<?php echo $widget_key ?>-data-table-ctrls .remove-selected-user').click(function () {

			var IDs = [];
			$('#key<?php echo $widget_key ?>-data-table-ctrls input[name="selected_ids[]"]').each(function() { IDs.push($(this).val()); });

			var button = $(this);

			if (IDs.length) {

				$.ajax({
					type: 'POST',
					data: {
						<?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash() ?>',
                        remove_company_doctors: true,
                        selected: IDs,
                        id: '<?php echo $facility->id ?>'
					},
					url: '<?php echo base_url(); ?>admin/healthcare/edit_facility/'+<?php echo $facility->id ?>,
					cache: true,
					beforeSend: function(){
						button.html('<span class="fa fa-refresh spinner"></span>')
					},
					success: function(response) {
						
						response = JSON.parse(response)
						
		                if(response.type) {
							
							if (response.type === 'success') {

								$('#key<?php echo $widget_key ?>-data-table-ctrls input[name="selected_ids[]"]').each(function() {

									var row = $( 'tr#'+$(this).val() );
									row.addClass('animated zoomOut');
									setTimeout(function(){
										table<?php echo $widget_key ?>.row( row ).remove().draw();
				                    }, 400)
								});
								$('#key<?php echo $widget_key ?>-data-table-ctrls .multi-select-inputs').html('');
								var template = '<span class="text-muted">0 selected. To select an item, Click the checkboxes in the table below</span>';
								$('#key<?php echo $widget_key ?>-data-table-ctrls .multi-select-count').html(template);

							}else {

								$('#ajax-alert-modal #message').html(response.message)
								$('#ajax-alert-modal').modal('show')
							}
						}
						button.html('Remove Selected')
					},
					error: function() {
						button.html('Remove Selected')
					}
				});
			}else{

				$('#ajax-alert-modal #message').html('Please select doctors and try again.')
				$('#ajax-alert-modal').modal('show')
			};
		});
		<?php endif; ?>

		<?php if (in_array('delete', $action)): ?>

		// Deleting multi-selected data.
		$('#key<?php echo $widget_key ?>-data-table-ctrls .delete-selected-user').click(function () {

			var IDs = [];
			$('#key<?php echo $widget_key ?>-data-table-ctrls input[name="selected_ids[]"]').each(function() { IDs.push($(this).val()); });

			var button = $(this);

			if (IDs.length) {

				$.ajax({
					type: 'POST',
					data: {
						<?php echo $this->security->get_csrf_token_name() ?> : '<?php echo $this->security->get_csrf_hash() ?>',
                        delete_selected_users: true,
                        selected: IDs
					},
					url: '<?php echo base_url(); ?>admin/users',
					cache: true,
					beforeSend: function(){
						button.html('<span class="fa fa-refresh spinner"></span>')
					},
					success: function(response) {
						
						response = JSON.parse(response)
						
		                if(response.type) {
							
							if (response.type === 'success') {

								$('#key<?php echo $widget_key ?>-data-table-ctrls input[name="selected_ids[]"]').each(function() {

									var row = $( 'tr#'+$(this).val() );
									row.addClass('animated zoomOut');
									setTimeout(function(){
										table<?php echo $widget_key ?>.row( row ).remove().draw();
				                    }, 400)
								});
								$('#key<?php echo $widget_key ?>-data-table-ctrls .multi-select-inputs').html('');
								var template = '<span class="text-muted">0 selected. To select an item, Click the checkboxes in the table below</span>';
								$('#key<?php echo $widget_key ?>-data-table-ctrls .multi-select-count').html(template);

							}else {

								$('#ajax-alert-modal #message').html(response.message)
								$('#ajax-alert-modal').modal('show')
							}
						}
						button.html('Delete Selected')
					},
					error: function() {
						button.html('Delete Selected')
					}
				});
			}else{

				$('#ajax-alert-modal #message').html('Please select doctors and try again.')
				$('#ajax-alert-modal').modal('show')
			};
		});
		<?php endif; ?>
	});
</script>