</div>
<hr/>

<?php $this->load->library('app'); $app = $this->app->owner(); ?>

<div class="container">
	<div class="text-right">
		<small>COPYRIGHT &copy <?php echo date('Y').' '.$app->name ?></small>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url('assets/js/popper.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jasny-bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/global.js?v=1.0'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin_global.js?v=1.0'); ?>"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>



<?php
// For example if a user submitted a form from a modal.
// You wand to trigger that modal in event of errors for instance
$redirect_inner = $this->session->flashdata('location');
?>

<script>
    $(document).ready(function() {
        $('.toast').toast('show');
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
        $('.dropdown-toggle').dropdown();

        <?php if (isset($redirect_inner['toggle'])): ?>
            <?php if ($redirect_inner['toggle'] === 'modal'): ?>
                $("<?php echo $redirect_inner['target'] ?>").modal('show');
            <?php endif ?>
        <?php endif ?>

        $('input[type="submit"]').click(function() {$(this).val('Working ...')} );
        $('button[type="submit"]').click(function() {$(this).html('Working ...')} );

        function reposition() {
            var modal = $(this),
            dialog = modal.find('.modal-dialog');
            modal.css('display', 'block');

            // Dividing by two centers the modal exactly, but dividing by three 
            // or four works better for larger screens.
            dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
        }

        // Reposition when a modal is shown
        $('#ajax-alert-modal').on('show.bs.modal', reposition);
        
        // Reposition when the window is resized
        $(window).on('resize', function() {
            $('#ajax-alert-modal:visible').each(reposition);
        });
    })

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
    });
</script>

<?php if(isset($scripts)) {
    foreach($scripts as $script_link) echo $script_link;
} ?>

<script type="text/javascript">
<?php if (isset($script)): ?>
    <?php echo $script ?>
<?php endif ?>
</script>

</body>
</html>