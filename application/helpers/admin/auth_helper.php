<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('set_auth_level')) {
    function set_auth_level ($level = 0)
    {
        $ci =& get_instance();
        $ci->load->library('session');
        $ci->load->helper('url');

        if ($ci->session->userdata('logged_in') == false)
        {
            redirect(site_url(array('admin', 'login', 'index', '?redir=' . uri_string())));
        }
        else if ($level != 0 && $ci->session->userdata('user')->level > $level)
        {
            $ci->layout->set_title('Access Denied');
            $ci->layout->render_view('admin/login/access-denied.php');
            $ci->layout->hard_render();
            die();
        }

    }
}


?>