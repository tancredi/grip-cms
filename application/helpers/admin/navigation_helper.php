<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('get_types_navigation')) {
    function get_types_navigation ()
    {
        $navigation_array = array();
        $ci =& get_instance();
        $ci->load->model('admin/types_model');

        $types = $ci->types_model->get_types();
        foreach ($types as $type)
        {
            $navigation_array[$type->table_name] = array(
                'label'     => $type->display_name,
                'segments'  => array('admin', 'type', 'index', $type->table_name)
            );
        }
        return $navigation_array;
    }
}



if ( ! function_exists('get_admin_navigation')) {
    function get_admin_navigation ()
    {
        $ci =& get_instance();
        $ci->config->load('admin_navigation');
        return array_merge($ci->config->item('admin_navigation'), get_types_navigation());
    }
}




?>