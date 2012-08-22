<?php

$this->load->helper('form');

echo form_label($field->display_name, $field->field_name);
$options = array('null'	=> '-');


foreach($entries as $entry)
{
    $options[$entry['id']] = $entry['value'];
}

echo form_dropdown($field->field_name, $options, $current_value);

?>