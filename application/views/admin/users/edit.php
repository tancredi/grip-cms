<?php

$this->load->helper(array('form', 'html'));

$level_options = array();

foreach($user_levels as $key => $level)
{
    if ($level['assignable'] == true)
    {
        $level_options[$key] = $level['label'];
    }
}

if (isset($error))
{
    echo "<div class='error'>$error</div>";
}

echo form_open($form_actions['main'])
. form_label('Username:', 'username')
. form_input('username', $user->username)
. '<hr />'
. form_label('Level:', 'level')
. form_dropdown('level', $level_options, $user->level)
. '<hr />'
. form_submit('', 'Update')
. form_close();

echo '<hr />' . heading('Change Password', 3) . '<hr />';

if (isset($password_error))
{
    echo "<div class='error'>$password_error</div>";
}

echo form_open($form_actions['password'])
. form_label('Password:', 'password')
. form_password('password')
. form_label('Repeat password:', 'confirm-password')
. form_password('confirm-password')
. '<hr />'
. form_submit('', 'Update')
. '<hr />'
. form_close();

?>

<a href="<?=site_url(array('admin', 'users'));?>" class="button">Back to Users</a>