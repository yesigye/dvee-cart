<?php $this->load->view('admin/templates/header', array(
    'title' => 'Manage categories',
    'link' => 'items',
    'sub_link' => 'categories',
    'breadcrumbs' => array(
        0 => array('name'=>'Items','link'=>'items'),
        1 => array('name'=>'Categories','link'=>FALSE)
    )
)); ?>

<div class="page-header b-0">
    <div class="lead float-left mb-3">Product Categories</div>
    <a href="<?php echo site_url('admin/insert_category') ?>" class="btn btn-primary float-right">
        <span class="fa fa-plus"></span> Category
    </a>
    <div class="clearfix"></div>
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

<?php if ( empty($categories) ): ?>
    <div class="alert alert-warning">
        You have no categories setup
    </div>
<?php else: ?>
    <?php echo form_open(current_url()) ?>
        <div class="table-responsive">
            <table class="table table-flat table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Parent Category</th>
                        <th class="text-center">Attributes</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td>
                                <div class="form-inline">
                                    <input type="text" name="update[<?php echo $category->category_id ?>][name]" value="<?php echo $category->name ?>" class="form-control">
                                </div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <select name="update[<?php echo $category->category_id ?>][parent]" class="form-control" id="input-category">
                                        <option value="">No Parent Category</option>
                                        <?php foreach ($categories as $list): ?>
                                            <option value="<?php echo $list->category_id ?>" <?php echo ($list->category_id == $category->parent_id) ? 'selected="selected"' : '' ?>>
                                                <?php echo $list->name ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info" disabled="disabled">
                                        <span class="badge"><?php echo $category->attribute_count ?></span>
                                    </button>
                                    <a href="<?php echo site_url('admin/update_attribute/'.$category->category_id) ?>" class="btn btn-info">
                                        <span class="fa fa-edit"></span>
                                        Edit
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">
                                <button name="delete[<?php echo $category->category_id ?>]" value="delete" type="submit" class="btn btn-danger">
                                    <span class="fa fa-remove"></span>
                                    Delete
                                </button>
                                <?php echo form_close() ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <input type="submit" class="btn btn-success" name="update_categories" value="Update Categories" />
    <?php echo form_close() ?>
<?php endif ?>

<?php $this->load->view('admin/templates/footer'); ?>