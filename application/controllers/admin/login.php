<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


    public function __construct()
    {
        parent::__construct();

        $this->view_data = array();

        $this->load->helper('url');
        $this->load->model('admin/users_model');

        $this->layout->set_layout('admin_essential');
    }
    


    public function index ($action = '')
    {
        $redirect_url = (isset($_GET['redir'])) ? $_GET['redir'] : 'admin/dashboard';
        $this->view_data['error'] = '';

        if ($action == 'confirmed')
        {
            $login = $this->users_model->login();

            if ($login['success'] == true)
            {
                redirect($redirect_url, 'refresh');
            }
            else
            {
                $this->view_data['error'] = $login['error'];
            }

        }

        $this->layout->set_title("Login");
        $this->layout->render_view('admin/login/index.php', $this->view_data);
    }



    public function logout ($action = '')
    {
        $this->users_model->logout();
        redirect(array('admin', 'login', 'index'));
    }



}

/* End of file admin/login.php */
/* Location: ./application/controllers/admin/login.php */