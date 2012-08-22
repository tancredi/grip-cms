<?php
$ci =& get_instance();
$ci->load->model('admin/fields_model');
?>

<ul class="entries-list">
    <?php
    foreach ($types as $type) :
        $fields = $ci->fields_model->get_fields(array('type_id' => $type->id));
    ?>
        <li>

            <a href="<?=site_url(array('admin', 'types', 'edit', $type->id));?>" class="separed"><?=$type->display_name;?> &raquo;</a><span class="detail"><?=count($fields);?> fields</span>
           
            <a title="Move up" href="<?=site_url(array('admin', 'types', 'move', $type->id, 1));?>" class="button">
                <span class="icon-action icon-action-move-up">Move Up</span>
            </a>

            <a title="Move down" href="<?=site_url(array('admin', 'types', 'move', $type->id, -1));?>" class="button">
                <span class="icon-action icon-action-move-down">Move Down</span>
            </a>

            <a title="Delete Type" href="<?=site_url(array('admin', 'types', 'delete', $type->id));?>" class="button">
                <span class="icon-action icon-action-delete">Delete</span>
            </a>

            <a title="Edit Type" href="<?=site_url(array('admin', 'types', 'edit', $type->id));?>" class="button">
                <span class="icon-action icon-action-edit">Edit</span>
            </a>

        </li>
    <?php endforeach;
    if (count($types) == 0): ?>

        <div class="data-display">
            No Types added yet.
            <a href="<?=site_url(array('admin', 'types', 'add'));?>">
                Add a Type &raquo;
            </a>
        </div>

    <?php endif; ?>
</ul>

<hr />

<a href="<?=site_url(array('admin', 'types', 'add'));?>" class="cta">Add type</a>