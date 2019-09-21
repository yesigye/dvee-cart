<?php $this->load->view('admin/templates/header', array(
    'title' => 'Update Attributes',
    'link' => 'items',
    'sub_link' => 'categories',
    'breadcrumbs' => array(
        0 => array('name'=>'Items','link'=>'items'),
        1 => array('name'=>'Categories','link'=>'categories'),
        2 => array('name'=>$category->name,'link'=>FALSE)
    )
)); ?>

<div class="page-header b-0">
    <div class="lead float-left mb-3">Attributes for <code><?php echo $category->name ?></code></div>
    <button class="btn btn-primary float-right" data-toggle="modal" data-target="#attributes-add-modal">
        <span class="fa fa-plus"></span> Attribute
    </button>
    <div class="clearfix"></div>
</div>

<?php if (validation_errors()): ?>
        <div class="alert alert-danger"><?php echo validation_errors() ?></div>
<?php else: ?>
    <?php if (! empty($message)): ?>
        <div id="message"> <?=$message ?> </div>
    <?php endif ?>
<?php endif ?>

<?php echo form_open(current_url()) ?>
    <?php echo form_hidden('id', $category->id) ?>
        <?php if ($category->attributes): ?>
        <div class="table-responsive">
            <table class="table table-flat table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Values</th>
                        <th class="text-center">
                            <div data-toggle="tooltip" data-placement="bottom" title="Use attribute as a Product Option. Product options are used to create product variations">
                                Product Option <span class="fa fa-info-sign"></span>
                            </div>
                        </th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($category->attributes as $key => $attribute): ?>
                    <?php echo form_hidden('attribute_ids['.$key.']', $attribute->id) ?>
                        <tr>
                            <td>
                                <input type="text" name="attribute_name[<?php echo $key ?>]" value="<?php echo $attribute->name ?>" class="form-control">
                                <?php if ($attribute->category_id !== $category->id): ?>
                                    <p class="text-muted">
                                        Attribute inherited from category "<?php echo $attribute->category_name ?>"
                                    </p>
                                <?php endif ?>
                            </td>
                            <td>
                                <?php
                                    $string = '';
                                    foreach ($attribute->descriptions as $index => $description) {
                                            $string .= $description->name;
                                        if ($index !== count($attribute->descriptions)-1) {
                                            $string .= ', ';
                                        }
                                    }
                                ?>
                                <textarea class="form-control" name="attribute_values[<?php echo $key ?>]" rows="2"><?php echo $string ?></textarea>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="is_option[<?php echo $key ?>]" value="1" <?php echo ($attribute->is_option) ? 'checked="checked"' : '' ?>>
                            </td>
                            <td class="text-center">
                                <button type="submit" name="delete_attribute[<?php echo $attribute->id ?>]" class="btn btn-danger">
                                    <span class="fa fa-remove"></span> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <input type="submit" class="btn btn-success" name="update_category" value="Update Attributes" />
        </div>
        <?php else: ?>
            <div class="alert alert-warning" style="margin:0">
                no attributes found
            </div>
        <?php endif ?>
    </div>
</div>

<?php echo form_close() ?>

<div class="modal fade" id="attributes-add-modal" tabindex="-1" role="dialog" aria-labelledby="add-size-help" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <?php echo form_open(current_url(), 'class="modal-content"') ?>
            <div class="panel panel-primary" style="margin:0">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    Add New Attributes
                </div>
                <div class="panel-body">
                    <table class="table table-flat table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Values</th>
                                <th class="text-center">
                                    <div data-toggle="tooltip" data-placement="bottom" title="Use attribute as a Product Option. Product options are used to create product variations">
                                        Product Option <span class="fa fa-info-sign"></span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="attribute-form-group">
                            <tr class="attribute-form-segment">
                                <td>
                                    <input type="text" class="form-control" name="insert_attribute_name[0]" value="" />
                                </td>
                                <td>
                                    <textarea class="form-control" name="insert_attribute_value[0]"></textarea>
                                    <span class="help-block">Separate each value with a comma.</span>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="insert_attribute_is_option[0]" value="1">
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <td colspan="4" class="text-right">
                                <button type="button" class="btn btn-sm btn-default" onClick="addAttrForm()">Add Another Row</button>
                            </td>
                        </tfoot>
                    </table>
                    
                    <input type="submit" class="btn btn-primary" name="add_attributes" value="Insert Attributes" />
                </div>
            </div>
        <?php echo form_close() ?>
    </div>
</div>

<script type="text/javascript">

    function addAttrForm() {
        $(document).ready(function() {
                // Get last element to be cloned and increment the index id.
                var last_el = $('#attribute-form-group .attribute-form-segment').last();

                // To set a new unique field name for the 'to-be-cloned' row, we need to obtain the current highest index id from the existing field names.
                var input_name = last_el.find('input, select, textarea').not('input:radio').first().attr('name');
                input_name = input_name.substring(input_name.indexOf(']')+1);
                
                var highest_id = last_el.index();
                
                // Loop through all field names and check if the index id is higher than the currently set highest.
                $('input[name$="'+input_name+'"], select[name$="'+input_name+'"], textarea[name$="'+input_name+'"]').each(function()
                {
                    var row_name = $(this).attr('name');
                    if (parseInt(row_name.substring(row_name.indexOf('[')+1, row_name.indexOf(']'))) > highest_id)
                    {
                        highest_id = parseInt(row_name.substring(row_name.indexOf('[')+1, row_name.indexOf(']')));
                    }           
                });

                // Get last element to be cloned and increment the index id.
                var last_el = $('#attribute-form-group .attribute-form-segment').last();
                var new_id = highest_id+1;

                // Clone target row.
                var new_row = last_el.clone().insertAfter(last_el);

                // Set names for new elements by incrementing the current elements index (Example: name="insert[0][xxx]" updates to name="insert[1][xxx]").
                // Note: This example requires the first square bracket value must be the index value. Change the code below if your naming convention differs.
                new_row.find('input, select, textarea').not('input:radio').each(function()
                {
                    $(this).val('');
                    $(this).attr('checked', false);
                    if (typeof($(this).attr('name')) != 'undefined')
                    {
                        var cloned_name = $(this).attr('name');
                        var new_name = cloned_name.substring(0, cloned_name.indexOf('[')+1) + new_id + cloned_name.substring(cloned_name.indexOf(']'));         
                        $(this).attr('name', new_name);
                    }
                });
        });
    }
</script>

<?php $this->load->view('admin/templates/footer'); ?>