<?php

$this->load->helper('form');

echo form_label($field->display_name, $field->field_name);

$chosen = explode(',', $current_value);

if (!function_exists('fetch_entry'))
{
	function fetch_entry ($arr, $key, $value)
	{
		foreach ($arr as $entry) {
			if ($entry[$key] == $value)
			{
				return $entry;
			}
		}
		return null;
	}
}

?>

<div class="multi-select">
	<ul class="selected">
		<?php
		if ($current_value != '')
		{
			foreach ($chosen as $id)
			{
				$entry = fetch_entry($entries, 'id', $id);
				echo '<li data-id="' . $entry['id'] . '">' . $entry['value'] . '</li>';
			}
		}
		?>
	</ul>
	<ul class="available">
		<?php foreach ($entries as $entry)
		{
			if (in_array($entry['id'], $chosen) == false)
			{
				echo '<li data-id="' . $entry['id'] . '">' . $entry['value'] . '</li>';
			}
		}
		?>
	</ul>
	<?=form_hidden($field->field_name, $current_value);?>
</div>