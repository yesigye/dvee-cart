<?php foreach ($descriptions as $description): ?>
    <li class="list-group-item app-description">
        <?= $description->name ?>
        <i class="fa fa-close float-right app-description-delete" data-key="<?= $description->id ?>"></i>
    </li>
<?php endforeach ?>

<script>
$('.app-description-delete').click(function(){
    var icon = $(this);
    var iconClass = icon.attr('class');
    var container = $(this).parent();
    var key = $(this).attr('data-key');
    $.ajax({
        url: '<?= base_url()."admin/categories/delete_description/" ?>'+key,
        beforeSend: function(){
            icon.removeClass(iconClass);
            icon.addClass('fa fa-spinner float-right');
        },
        success: function(response){
            response = JSON.parse(response);
            if(response.alert){
                dveeAlert({
                    type: response.alert.type,
                    message: response.alert.message,
                    duration: false
                });
            }
            if( ! response.error){
                container.addClass('animated zoomOut')
                setTimeout(function(){
                    container.remove()
                }, 500)
            }
        },
        error: function(xhr, status, error){
            dveeAlert({
                type: 'danger',
                message: 'Server Error Occured',
                duration: false
            });
        },
        complete: function(){
            icon.removeClass('fa fa-spinner float-right');
            icon.addClass(iconClass);
        }
    });
});
</script>