<?php

$this->load->helper('form');

echo form_label($field->display_name, $field->field_name);
echo form_input($field->field_name, $current_value);

?>