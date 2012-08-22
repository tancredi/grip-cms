<?php

echo form_open_multipart(site_url(array('admin', 'type', 'edit', $type->table_name, $entry['id'], 'submit')));

foreach ($fields as $field)
{
    echo "$field <br />";
}

echo '<hr />' .
form_submit('', 'Update') .
form_close();

?>