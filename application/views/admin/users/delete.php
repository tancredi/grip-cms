<p>Are you sure you want to delete '<?=$user->username;?>'?</p>

<br />

<a href="<?=site_url(array('admin', 'users', 'delete', $user->id, 'confirmed'));?>" class="button">Sure</a>
<a href="<?=site_url(array('admin', 'users'));?>" class="button">No</a>

<hr />

<a href="<?=site_url(array('admin', 'users'));?>" class="cta">Back to Users</a>