<?php if ($template === 'tiles'): ?>
    <?php foreach ($attributes as $attribute): ?>
        <div class="col-md-4 app-attribute">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <?= $attribute->name ?>
                    <i class="fa fa-close float-right app-attribute-delete" data-key="<?= $attribute->id ?>"></i>
                </div>
                <div class="panel-body" style="padding:0">
                    <ol class="list-group app-descriptions" style="margin:0">
                        <?php $this->load->view('admin/categories/description_tiles',
                            array('descriptions' => $attribute->descriptions)
                        ) ?>
                    </ol>
                </div>
                <div class="panel-body">
                    <?= form_open(current_url(), 'class="form-inline app-new-description"') ?>
                        <?= form_hidden('add_description', true) ?>
                        <?= form_hidden('id', $attribute->id) ?>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Description name" name="name">
                            <span class="input-group-btn">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="submit" class="btn btn-primary">
                                        &nbsp<i class="fa fa-plus icon"></i>&nbsp
                                    </button>
                                </div>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <script>
        $( ".app-new-description" ).dveeAjaxPost({
            url: '<?= current_url() ?>',
            container: 'parent',
            autoData: true
        });
    </script>

    <script>
    $('.app-attribute-delete').click(function(){
        var icon = $(this);
        var iconClass = icon.attr('class');
        var container = $(this).closest('.app-attribute');
        var key = $(this).attr('data-key');

        $.ajax({
            url: '<?= base_url()."admin/categories/delete_attribute/" ?>'+key,
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
<?php else: ?>
    <?php if ($attributes): ?>
        <div class="lead page-header">Product Attributes</div>
        <div class="row">
            <?php foreach ($attributes as $attribute): ?>
                <div class="col-md-4">
                    <div class="list-group">
                        <div class="list-group-item active"><?= $attribute->name ?></div>
                        <?php foreach ($attribute->descriptions as $description): ?>
                        <div class="list-group-item">
                            <div class="checkbox" style="margin:0">
                                <label>
                                    <input type="checkbox" name="attributes[]" value="<?= $attribute->id.'_'.$description->id ?>" value=""/>
                                    <?= $description->name ?>
                                </label>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
<?php endif ?>