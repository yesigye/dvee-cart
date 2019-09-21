<?php $sub_link = '' ?>
<?php if ( ! empty($category->pagination) ): ?>
    <?php foreach ($category->pagination as $page): ?>
        <?php $sub_link .= anchor('admin/catalog/categories/'.$page->id, $page->name) ?>
    <?php endforeach ?>
<?php else: ?>
    <?php $sub_link = 'Base' ?>
<?php endif ?>

<?php $this->load->view('admin/templates/header', array(
    'title' => 'Insert Category',
    'link' => 'items',
    'sub_link' => 'add_category',
    'breadcrumbs' => array(
        0 => array('name'=>'Items','link'=>'items'),
        1 => array('name'=>'Categories','link'=>'categories'),
        1 => array('name'=>'Insert Category','link'=>FALSE),
    )
)); ?>

<div class="lead page-header b-0">
    Add a new category
</div>

<?php if (validation_errors()): ?>
    <div class="alert alert-danger">
        Correct the errors in the form and try again
    </div>
<?php else: ?>
    <?php if (! empty($message)): ?>
        <div id="message"> <?=$message ?> </div>
    <?php endif ?>
<?php endif ?>

<?= form_open(current_url()) ?>
    <div class="form-group <?php echo form_error('name') ? 'has-error' : '' ?>">
        <div class="row">
            <div class="col-md-3 col-lg-2">
                <label for="name">
                    Category Name:
                    <span class="fa fa-asterisk text-danger"></span>
                </label>
            </div>
            <div class="col-md-9 col-lg-10">
                <input type="text" class="form-control" name="name" value="<?php echo set_value('name') ?>" />
                <p class="help-block"><?php echo form_error('name') ? form_error('name') : '&nbsp' ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <label for="name">Category Parent:</label>
        </div>
        <div class="col-md-9 col-lg-10">
            <div class="form-group">
                <select name="parent" class="form-control" id="input-category">
                    <option value="">No Parent Category</option>
                    <?php foreach ($categories as $list): ?>
                        <option value="<?php echo $list->category_id ?>">
                            <?php echo $list->name ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
    </div>

    <hr/>
    
    <div class="row">
        <div class="col-md-3 col-lg-2">
            <label for="attributes">Attributes:</label>
        </div>
        <div class="col-md-9 col-lg-10">
            <div id="attribute-form-group">
                <div class="row attribute-form-segment">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="attributes">Attribute Name:</label>
                            <input type="text" class="form-control" name="insert_attribute_name[0]" value="" />
                        </div>
                        <div class="checkbox form-group">
                            <label>
                                <input type="checkbox" name="insert_attribute_is_option[0]" value="1">
                                Used for Product Options
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="attribute_descriptions">Values:</label>
                            <textarea class="form-control" name="insert_attribute_value[0]"></textarea>
                        </div>
                        <span class="help-block">Separate each value with a comma.</span>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <button type="button" class="btn btn-success" onClick="addAttrForm()">Add Another Attribute</button>
            </div>
        </div>
    </div>

    <hr/>

    <input type="submit" class="btn btn-lg btn-primary" name="add_category" value="Insert New Category"/>
</form>

<script type="text/javascript">
    function addAttrForm() {
        // $('#attribute-form-group').append($('#attribute-form-segment').html());

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
        var new_id = highest_id + 1;

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
    }
</script>

<?php $this->load->view('admin/templates/footer'); ?>