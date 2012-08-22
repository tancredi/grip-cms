<?php

$ci =& get_instance();
$ci->load->model('admin/field_modules_model');

?>

<ul class="entries-list">
    <?php
    foreach ($fields as $field) :
        $module = ($ci->field_modules_model->get_module($field->module));
        $is_key = ($key_field != null && $field->id == $key_field->id);
    ?>
        <li>

            <a href="<?=site_url(array('admin', 'fields', 'edit', $field->id));?>" class="separed">
                <?=$field->display_name;?>
            </a>
            <span class="detail<?php if ($is_key) echo ' separed';?>">
                <?=$module->display_name;?>
            </span>

            <?php if ($is_key): ?>
                <span class="icon-action icon-action-key">Key</span>
            <?php endif; ?>

            <a title="Move up" href="<?=site_url(array('admin', 'fields', 'move', $field->id, 1));?>" class="button">
                <span class="icon-action icon-action-move-up">Move Up</span>
            </a>

            <a title="Move down" href="<?=site_url(array('admin', 'fields', 'move', $field->id, -1));?>" class="button">
                <span class="icon-action icon-action-move-down">Move Down</span>
            </a>

            <a title="Delete Field" href="<?=site_url(array('admin', 'fields', 'delete', $field->id));?>" class="button">
                <span class="icon-action icon-action-delete">Delete</span>
            </a>

            <a title="Edit Field" href="<?=site_url(array('admin', 'fields', 'edit', $field->id));?>" class="button">
                <span class="icon-action icon-action-edit">Edit</span>
            </a>

            <?php if (!$is_key): ?>
                <a title="Set as Key Field" href="<?=site_url(array('admin', 'fields', 'set_key', $field->id));?>" class="button">
                <span class="icon-action icon-action-key">Make Key</span>
            </a>
            <?php endif; ?>

        </li>
    <?php endforeach;
    if (count($fields) == 0): ?>
        <div class="data-display">
            There are no fields for this type.
            <a href="<?=site_url(array('admin', 'fields', 'add', $type->id));?>">
                Add a field &raquo;
            </a>
        </div>
    <?php endif; ?>
</ul>

<br />

<a href="<?=site_url(array('admin', 'fields', 'add', $type->id));?>" class="cta">Add Field</a>