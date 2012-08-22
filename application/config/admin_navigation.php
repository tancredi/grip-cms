<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$config['admin_navigation'] = array(
    'types' => array(
        'label'     => 'Manage Types',
        'segments'  => array('admin', 'types')
    ),
    'users' => array(
        'label'     => 'Manage Users',
        'segments'  => array('admin', 'users')
    ),
    'user_settings' => array(
        'label'     => 'User Settings',
        'segments'  => array('admin', 'user_settings')
    )
);


?>