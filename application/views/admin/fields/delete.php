<p>Are you sure you want to delete '<?=$field->display_name;?>' from '<?=$type->display_name;?>' type?</p>

<br />

<a href="<?=site_url(array('admin', 'fields', 'delete', $field->id, 'confirmed'));?>" class="cta">Sure</a>
<a href="<?=site_url(array('admin', 'types', 'edit', $type->id));?>" class="button">No</a>

<hr />

<a href="<?=site_url(array('admin', 'types', 'edit', $type->id));?>" class="button">Back to Edit Type</a>
