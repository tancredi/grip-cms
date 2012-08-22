<?php
$this->load->helper('form');

$hidden = array('type_id' => $type->id);

echo form_open(
    site_url(array('admin', 'fields', 'add', $type->id, 'submit')),
    null,
    $hidden
)
. form_label('Display name:', 'display_name')
. form_input('display_name')
. form_label('Module:', 'module');

$modules_select_options = array();

foreach($field_modules as $module_name => $module)
{
    $modules_select_options[$module_name] = $module['display_name'];
}

echo form_dropdown('module', $modules_select_options, $default_field_module)
. form_label('Relation:', 'relation_type_id');

$relation_type_options = array('' => '-');

foreach($types as $type)
{
    $relation_type_options[$type->id] = $type->display_name;
}
echo form_dropdown('relation_type_id', $relation_type_options);

$relation_type_options = array('' => '-');

echo '<hr />'
. form_submit('', 'Submit'); ?>

<a href="<?=site_url(array('admin', 'types', 'edit', $type->id));?>" class="button">Back to Edit Type</a>

<?php echo form_close(); ?>