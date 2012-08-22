<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('get_media_type_output')) {
    function get_media_type_output ($media_type = 'text', $mode = 'index', $input)
    {
        $ci =& get_instance();
        $view_path = "admin/media_types/$media_type/$mode.php";
        $index_view_path = "admin/media_types/$media_type/index.php";
        if (file_exists(APPPATH . "views/$view_path"))
        {
            return $ci->load->view($view_path, array('value' => $input), true);
        }
        else if (file_exists(APPPATH . "views/$index_view_path"))
        {
            return $ci->load->view($index_view_path, array('value' => $input), true);
        }
        else
        {
            show_error("Media type view not found (" . APPPATH . "views/$view_path)");
        }
    }
}


if (!function_exists('get_field_module_media_type_output')) {
    function get_field_module_media_type_output ($field_module_name, $mode, $input)
    {
        $ci =& get_instance();
        $ci->load->model('field_modules_model');
        $module = $ci->field_modules_model->get_module($field_module_name);
        if ($input != '')
        {
            return get_media_type_output($module->media_type, $mode, $input);
        }
        else
        {
            return '<span class="pre-fill">Empty</span>';
        }
    }
}


?>