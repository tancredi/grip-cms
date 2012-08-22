<?php

$this->load->helper(array('form', 'html'));

echo form_open('admin/login/index/confirmed', array('class' => 'login-form'))
. heading('Please Log in', 2)
. '<hr />';

if (strlen($error) > 0)
{
    echo "<div class='error'>$error</div>";
}

echo form_label('Username or email address:', 'username-email')
. form_input('username-email')
. form_label('Password:', 'password')
. form_password('password')
. '<hr />'
. form_submit('', 'Log in')
. form_close();

?>