<?php

$this->load->helper('form');

echo form_label($field->display_name, $field->field_name);

?>

<textarea class="content-editor" name="<?=$field->field_name;?>">
	<?=$current_value;?>
</textarea>