<p>Are you sure you want to delete this entry?</p>

<br />

<a href="<?=site_url(array('admin', 'type', 'delete', $type->table_name, $entry_id, 'confirmed'));?>" class="button">Sure</a>
<a href="<?=site_url(array('admin', 'type', 'index', $type->table_name));?>" class="button">No</a>

<hr />

<a href="<?=site_url(array('admin', 'type', 'index', $type->table_name));?>" class="cta">Back to <?=$type->display_name;?></a>