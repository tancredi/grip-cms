<?php

$this->load->helper('form');

echo form_open('admin/types/add/submit')
. form_label('Display name:', 'display_name')
. form_input('display_name')
. '<hr />'
. form_submit('', 'Submit');

?>

<a href="<?=site_url(array('admin', 'types'));?>" class="button">Back to Types</a>

<?=form_close();?>