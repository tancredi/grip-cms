<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$config['user_levels'] = array(
    0   =>  array(
                'label'         => 'Super Admin',
                'assignable'    => false
            ),
    1   =>  array(
                'label'         => 'Admin',
                'assignable'    => true
            ),
    2   => array(
                'label'         => 'Publisher',
                'assignable'    => true
            ),
);


?>