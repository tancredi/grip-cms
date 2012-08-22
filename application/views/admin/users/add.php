<?php

$this->load->helper('form');

$level_options = array();

foreach($user_levels as $key => $level)
{
    if ($level['assignable'] == true)
    {
        $level_options[$key] = $level['label'];
    }
}

echo form_open(site_url(array('admin', 'users', 'add', 'submit')))
. form_label('Email address:', 'email')
. form_email('email')
. '<hr />'
. form_label('Username:', 'username')
. form_input('username')
. '<hr />'
. form_label('Password:', 'password')
. form_password('password')
. form_label('Repeat password:', 'confirm-password')
. form_password('confirm-password')
. '<hr />'
. form_label('Level:', 'level')
. form_dropdown('level', $level_options)
. '<hr />'
. form_submit('', 'Submit');

?>

<a href="<?=site_url(array('admin', 'users'));?>" class="button">Back to Users</a>

<?=form_close();?>