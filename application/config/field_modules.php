<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$field_modules = array();

$field_modules['short_text'] =  array(
    'display_name'      => 'Short Text',
    'requires_relation' => false,
    'mysql_type' => array('type' => 'VARCHAR', 'constraint' => 150),
    'media_type' => 'text'
);

$field_modules['textarea'] =  array(
    'display_name'      => 'Textarea',
    'requires_relation' => false,
    'mysql_type' => array('type' => 'TEXT'),
    'media_type' => 'text'
);

$field_modules['select'] =  array(
    'display_name'      => 'Select',
    'requires_relation' => true,
    'mysql_type' => array('type' => 'INT', 'null' => true),
    'media_type' => 'text'
);

$field_modules['multi_relation'] =  array(
    'display_name'      => 'Multiple Select',
    'requires_relation' => true,
    'mysql_type' => array('type' => 'VARCHAR', 'constraint' => 150),
    'media_type' => 'text'
);

$field_modules['file'] =  array(
    'display_name'      => 'File',
    'requires_relation' => false,
    'mysql_type' => array('type' => 'VARCHAR', 'constraint' => 300),
    'media_type' => 'file'
);

$field_modules['image'] =  array(
    'display_name'      => 'Image',
    'requires_relation' => false,
    'mysql_type' => array('type' => 'VARCHAR', 'constraint' => 300),
    'media_type' => 'image'
);

$field_modules['video_vimeo'] =  array(
    'display_name'      => 'Video (Vimeo)',
    'requires_relation' => false,
    'mysql_type' => array('type' => 'VARCHAR', 'constraint' => 300),
    'media_type' => 'video_vimeo'
);

$field_modules['audio'] =  array(
    'display_name'      => 'Audio',
    'requires_relation' => false,
    'mysql_type' => array('type' => 'VARCHAR', 'constraint' => 300),
    'media_type' => 'audio'
);

$field_modules['rich_content'] =  array(
    'display_name'      => 'Rich Content',
    'requires_relation' => false,
    'mysql_type' => array('type' => 'TEXT'),
    'media_type' => 'html'
);

$config['field_modules']['default'] = 'short_text';
$config['field_modules']['modules'] = $field_modules;


?>