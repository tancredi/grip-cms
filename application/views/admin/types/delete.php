<p>Are you sure you want to delete '<?=$type->display_name;?>'?</p>

<br />

<a href="<?=site_url(array('admin', 'types', 'delete', $type->id, 'confirmed'));?>" class="button">Sure</a>
<a href="<?=site_url(array('admin', 'types'));?>" class="button">No</a>

<hr />

<a href="<?=site_url(array('admin', 'types'));?>" class="cta">Back to Types</a>