<?php

echo form_open_multipart(site_url(array('admin', 'type', 'add', $type->table_name, 'submit')));

foreach ($fields as $field)
{
    echo "$field <br />";
}

echo '<hr />' .
form_submit('', 'Submit') .
form_close();

?>