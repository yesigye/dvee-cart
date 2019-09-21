<?php $this->load->library('store'); $owner = $this->store->owner(); ?>
</div>


<footer class="footer bg-dark text-white-50 mt-5 mb-0 py-3">
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 text-center">
                    <div class="lead">Contacts</div>
                    <div class="my-3">
                        <span class="fa fa-phone"></span> <?php echo $owner->phone; ?>
                    </div>
                    <div class="my-3">
                        <span class="fa fa-pin"></span> <?php echo $owner->address; ?>
                    </div>
                    <?php if ( isset($owner->email) ): ?>
                        <a href="mailto: <?php echo $owner->email; ?>">
                            <span class="fa fa-envelope"></span> <?php echo $owner->email ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 text-center">
                    <div class="lead">Information</div>
                    <?php foreach ($this->store->pages() as $item): ?>
                    <div class="my-3">
                        <?php echo anchor('page/'.$item->slug, $item->name) ?>
                    </div>
                    <?php endforeach ?>
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 text-center">
                    <div class="lead">Categories</div>
                    <?php foreach ($this->store->menu() as $item): ?>
                    <div class="my-3">
                        <?php echo anchor('category/'.$item->slug.'/'.url_title($item->name), $item->name) ?>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <hr class="m-0">
        <div class="row">
            <div class="col-6">
                <img src="<?php echo base_url() ?>assets/system/cc-badges.png" alt="" style="margin:20px 0;width:250px">
            </div>
            <div class="col-6 mt-4 text-right">
                <small><?= $owner->name.' &copy '.date('Y') ?>.&nbsp All Rights Reserved</small>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jasny-bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/global.js"></script>

<?php
// For example if a user submitted a form from a modal.
// You wand to trigger that modal in event of errors for instance
$redirect_inner = $this->session->flashdata('location');
?>

<script>
    $(document).ready(function() {
        $('.toast').toast('show');
        $('[data-toggle="tooltip"]').tooltip();

        $('#nav-to-top').click(function(){
            $("html, body").animate({ scrollTop: 0 }, "slow");
        });

        $('.dropdown-toggle').dropdown();


        <?php if (isset($redirect_inner['toggle'])): ?>
            <?php if ($redirect_inner['toggle'] === 'modal'): ?>
                $("<?php echo $redirect_inner['target'] ?>").modal('show');
            <?php endif ?>
        <?php endif ?>

        $('input[data-toggle="loading"]').click(function() {$(this).val('Working ...')} );
        $('button[data-toggle="loading"]').click(function() {$(this).html('Working ...')} );

        $(".add-to-cart").submit(function(e) {
            var form = $(this);
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('add_to_cart') ?>',
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    $('#mini-cart').html(data);
                    var cartTotal = parseInt($('#cart-item-no').html());
                    $('#cart-item-no').html(cartTotal+1);
                    
                    $('body').append(data);
                    console.log('yesss')
                    $('#toast-container').append(`<div class="alert bg-success text-white alert-dismissible fade show" role="alert">
                        Item added to the cart successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                    $('#toast-container .cart-toast').toast('show')
                }
            });

            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
    })
</script>

<?php if (isset($script)): ?>
	<?php echo $script ?>
<?php endif ?>

</body>
</html>