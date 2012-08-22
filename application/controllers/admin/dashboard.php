<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {


    public function __construct()
    {
        parent::__construct();

        $this->view_data = array();

        $this->load->helper(array('url', 'admin/navigation', 'admin/auth'));

        $this->layout->set_layout('admin');
        $this->layout->set_navigation(get_admin_navigation(), '');

        set_auth_level(2);
    }
    


    public function index ()
    {
        $this->layout->set_title("Dashboard");
        $this->layout->render_view('admin/dashboard/index.php', $this->view_data);
    }




}

/* End of file admin/fields.php */
/* Location: ./application/controllers/admin/fields.php */