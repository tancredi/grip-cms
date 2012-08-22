<?php

$order_desc_url = site_url(array('admin', 'type', 'index', $type->table_name, $field->field_name, 'desc'));
$order_asc_url = site_url(array('admin', 'type', 'index', $type->table_name, $field->field_name, 'asc'));
$no_order_url = site_url(array('admin', 'type', 'index', $type->table_name));

if ($order_by[0] == $field->field_name) : ?>

    <?php if ($order_by[1] == 'asc') : ?>
        <a class="selected" href="<?=$order_desc_url;?>">&uarr;
    <?php else: ?>
        <a class="selected" href="<?=$no_order_url;?>">&darr;
    <?php endif; ?>

<?php else: ?>

    <a href="<?=$order_asc_url;?>">

<?php endif; ?>

    <?=$field->display_name;?></a>