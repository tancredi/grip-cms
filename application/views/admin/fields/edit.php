<?php
$this->load->helper('form');

$hidden = array('field_id' => $field->id, 'type_id' => $field->type_id);

echo form_open(
    site_url(array('admin', 'fields', 'edit', $field->id, 'update')),
    null,
    $hidden
)
. form_label('Display name:', 'display_name')
. form_input('display_name', $field->display_name)
. form_label('Module:', 'module');

$modules_select_options = array();

foreach($field_modules as $module_name => $module)
{
    $modules_select_options[$module_name] = $module['display_name'];
}

echo form_dropdown('module', $modules_select_options, $field->module)
. form_label('Relation:', 'relation_type_id');

$relation_type_options = array('' => '-');

foreach($types as $type)
{
    $relation_type_options[$type->id] = $type->display_name;
}
echo form_dropdown('relation_type_id', $relation_type_options, $field->relation_type_id);

$relation_type_options = array('' => '-');

echo '<hr />'
. form_submit('', 'Submit'); ?>

<a href="<?=site_url(array('admin', 'types', 'edit', $type->id));?>" class="button">Back to Edit Type</a>

<?php echo form_close(); ?>