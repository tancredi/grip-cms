<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_settings extends CI_Controller {


    public function __construct()
    {
        parent::__construct();

        $this->view_data = array();

        $this->load->model('admin/users_model');
        $this->load->library('session');
        $this->config->load('user_levels');

        $this->load->helper(array('url', 'admin/navigation'));

        $this->layout->set_layout('admin');
        $this->layout->set_navigation(get_admin_navigation(), 'user_settings');

        if ($this->session->userdata('logged_in') == true)
        {
            $this->user = $this->session->userdata('user');
        }
        else
        {
            $this->layout->render_view('admin/login/access_denied.php', $this->view_data);
            return;
        }
    }



    public function index ($action = '')
    {
        $this->view_data = array(
            'user'          => $this->users_model->get_user(array('id' => $this->user->id)),
            'user_levels'   => $this->config->item('user_levels'),
            'form_actions'  => array(
                                    'main'      => site_url(array('admin', 'user_settings', 'index', 'update')),
                                    'password'  => site_url(array('admin', 'user_settings', 'index', 'update_password'))
                                )
        );

        if ($action == 'update')
        {
            $response = $this->users_model->update_user($this->user->id);

            if ($response['success'] == false)
            {
                $this->view_data['error'] = $response['error'];
            }
            else
            {
                redirect(site_url(array('admin', 'user_settings')));
            }
        }
        else if ($action == 'update_password')
        {
            $response = $this->users_model->update_password($this->user->id);

            if ($response['success'] == false)
            {
                $this->view_data['password_error'] = $response['error'];
            }
            else
            {
                redirect(site_url(array('admin', 'user_settings')));
            }
        }

        $this->layout->set_title("Edit user details: " . $this->view_data['user']->username);
        $this->layout->render_view('admin/users/edit.php', $this->view_data);
    }



}

/* End of file admin/users.php */
/* Location: ./application/controllers/admin/users.php */