<?php

$this->load->helper('html');

foreach ($fields as $field):
    $label = $field->display_name;
    $value = $entry_data[$field->field_name]; ?>

    <h4><?=$label;?></h4>

    <div class="data-display">
        <?=$value;?>
    </div>

    <hr />

<?php endforeach; ?>

<a href="<?=site_url(array('admin', 'type', 'edit', $type->table_name, $entry['id']));?>" class="cta">
    Edit Entry
</a>

<a href="<?=site_url(array('admin', 'type', 'index', $type->table_name));?>" class="button">
    Back to <?=$type->display_name;?>
</a>