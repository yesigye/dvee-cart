<?php $this->load->view('admin/templates/header', array(
	'title' => 'Payment Settings',
	'link' => 'settings',
	'sub_link' => 'payments',
	'breadcrumbs' => array(
		0 => array('name'=>'Settings','link'=>'config'),
		1 => array('name'=>'Payments','link'=>FALSE),
	)
)); ?>

<h4 class="lead">Payments</h4>
<p class="text-muted">
	Manage your payment options
</p>

<?php if (validation_errors()): ?>
<div class="alert alert-danger">Check the form for errors and try again</div>
<?php endif ?>

<div class="card-deck pay-options-container">
    <div class="card text-center">
        <div class="card-header bg-<?php echo ($settings['active'] == 'paypalExpress') ? 'primary' : 'secondary' ?> text-white" title="current option">PayPal Express</div>
        <div class="card-body text-muted">
            <h1>
                <i
                 class="icon fab fa-cc-paypal text-<?php echo ($settings['active'] == 'paypalExpress') ? 'primary' : 'muted' ?>"
                 aria-hidden="true"
                ></i>
            </h1>
            Adds PayPal checkout payments
            <div class="small">
                Payments are done on an off-site PayPal gateway
            </div>
        </div>
        <div class="card-footer border-0 d-flex justify-content-between">
            <a data-toggle="modal" href="#modal-paypal" class="card-link"><small>EDIT</small></a>
            <div class="custom-control custom-switch">
                <input
                 type="radio"
                 name="isactive"
                 value="paypalExpress"
                 id="customSwitch1"
                 class="custom-control-input"
                 <?php echo ($settings['active'] == 'paypalExpress') ? 'checked="checked"' : '' ?>
                >
                <label class="custom-control-label" for="customSwitch1">&nbsp</label>
            </div>
        </div>
    </div>

    <div class="card text-center">
        <div class="card-header bg-<?php echo ($settings['active'] == 'paypalPro') ? 'primary' : 'secondary' ?> text-white">PayPal Pro</div>
        <div class="card-body text-muted">
            <h1>
                <i
                 class="icon fab fa-paypal text-<?php echo ($settings['active'] == 'paypalPro') ? 'primary' : 'muted' ?>"
                 aria-hidden="true"
                ></i>
            </h1>
            Accept credit and debit cards
            <div class="small">
                Payments are done directly on the wesite
            </div>
        </div>
        <div class="card-footer border-0 d-flex justify-content-between">
            <a data-toggle="modal" href="#modal-paypal" class="card-link"><small>EDIT</small></a>
            <div class="custom-control custom-switch">
                <input
                 type="radio"
                 name="isactive"
                 value="paypalPro"
                 id="customSwitch2"
                 class="custom-control-input"
                 <?php echo ($settings['active'] == 'paypalPro') ? 'checked="checked"' : '' ?>
                >
                <label class="custom-control-label" for="customSwitch2">&nbsp</label>
            </div>
        </div>
    </div>
</div>

<?php echo form_open(current_url()); ?>
<div class="modal fade" id="modal-paypal">
	<div class="modal-dialog">
		<div class="modal-content border-0">
			<div class="modal-header text-uppercase font-weight-bold">
				PayPal API Credentials
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="form-group">
                    <label for="paypal[username]" class="control-label">Username</label>
                    <input
                     type="text"
                     name="paypal[username]"
                     class="form-control <?= form_error('paypal[username]') ? 'is-invalid' : '' ?>"
                     value="<?= set_value('paypal[username]') ? set_value('paypal[username]') : $settings['paypal']['username'] ?>"
                     required
                    />
                    <?php if (form_error('paypal[username]')): ?>
                    <div class="invalid-feedback"><?php echo form_error('paypal[username]') ?></div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="paypal[password]" class="control-label">Password</label>
                    <input
                     type="text"
                     name="paypal[password]"
                     class="form-control <?= form_error('paypal[password]') ? 'is-invalid' : '' ?>"
                     value="<?= set_value('password') ? set_value('paypal[password]') : $settings['paypal']['password'] ?>"
                     required
                    />
                    <?php if (form_error('paypal[password]')): ?>
                    <div class="invalid-feedback"><?php echo form_error('paypal[password]') ?></div>
                    <?php endif ?>
                </div>
                <div class="form-group">
                    <label for="paypal[signature]" class="control-label">Signature</label>
                    <input
                     type="text"
                     name="paypal[signature]"
                     class="form-control <?= form_error('paypal[signature]') ? 'is-invalid' : '' ?>"
                     value="<?= set_value('paypal[signature]') ? set_value('paypal[signature]') : $settings['paypal']['signature'] ?>"
                     required
                    />
                    <?php if (form_error('paypal[signature]')): ?>
                    <div class="invalid-feedback"><?php echo form_error('paypal[signature]') ?></div>
                    <?php endif ?>
                </div>
                <label class="custom-control custom-checkbox" for="checkSand1">
                    <input type="hidden" name="paypal[sandbox]" value="0">
                    <input
                     type="checkbox"
                     name="paypal[sandbox]"
                     id="checkSand1"
                     class="custom-control-input"
                     value="1"
                     <?php echo set_checkbox('paypal[sandbox]', '1') ? set_checkbox('paypal[sandbox]', '1') : ($settings['paypal']['sandbox'] ? 'checked="checked"' : '') ?>
                    >
                    <div class="custom-control-label">
                        Sandbox Mode
                        <div class="text-muted">Use PayPal's testing servers?</div>
                    </div>
                </label>
            </div>
            <div class="modal-footer">
                <input type="submit" name="save" value="Save Changes" class="btn btn-primary">
            </div>
		</div>
	</div>
</div>
<?php echo form_close(); ?>




<script>
$(function() {
    // 
    $('input[type=radio][name=isactive]').change(function() {
		var radio = $(this);
        var data = new Object();
		data['save'] = true;
		data['isactive'] = radio.val();
		data['csrf_test_name'] = $('input[name="csrf_test_name"]').val();

		$.ajax({
			type: 'POST',
			data: data,
			url: '<?php echo current_url(); ?>',
			cache: true,
			beforeSend: function() {
                radio.attr("disabled", true)
			},
			error: function(){
                radio.attr("checked", false)
			},
			success: function(data){
                if(data == 1) {
                    radio.attr("checked", true)
                    $('.pay-options-container .card > .card-header').removeClass('bg-primary').addClass('bg-secondary')
                    $('.pay-options-container .card .icon').removeClass('text-primary').addClass('text-muted')
                    radio.closest('.card').find('.card-header').addClass('bg-primary').removeClass('bg-secondary')
                    radio.closest('.card').find('.icon').addClass('text-primary').removeClass('text-muted')
                } else {
                    radio.attr("checked", false)
                }
			},
		});
	});
});
</script>
	
<?php $this->load->view('admin/templates/footer'); ?>