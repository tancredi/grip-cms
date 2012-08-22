<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('get_navigation')) {
    function get_navigation ()
    {
        $ci =& get_instance();
        $ci->load->model('data_model');

        $sections = $ci->data_model->get_entries('sections');
        $pages = $ci->data_model->get_entries('pages');

        $navigation_data = array();
        
        foreach ($sections as $section)
        {
            $sub_navigation = array();
            
            foreach ($pages as $page)
            {
                if ($page->section == $section->id)
                {
                    $sub_navigation[normalise_page_name($page->title)] = array(
                        'label'             => $page->title,
                        'segments'          => array(normalise_page_name($page->title))
                    );
                }
            }

            $navigation_data[normalise_page_name($section->title)] = array(
                'label'     =>  $section->title,
                'segments'  => array(normalise_page_name($section->title)),
                'sub_navigation'    => $sub_navigation
            );
        }

        return $navigation_data;
    }
}




?>