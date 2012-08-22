<?php

$this->load->helper('form');
$this->load->helper('html');

echo form_open(site_url(array('admin', 'types', 'edit', $type->id, 'update')))
. form_label('Display name:', 'display_name')
. form_input('display_name', $type->display_name)
. br(). br()
. form_submit('', 'Update')
. form_close()

;?>

<hr />

<h2>Fields</h2>

<?php $this->load->view("admin/fields/partials/list-fields.php"); ?>

<a href="<?=site_url(array('admin', 'types'));?>" class="button">Back to types</a>