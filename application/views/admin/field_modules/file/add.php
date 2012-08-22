<?php

$this->load->helper('form');

echo form_label($field->display_name, $field->field_name);
echo form_upload(array(
    'name'  => $field->field_name,
    'class' => 'file-uploader-input'
));

?>