<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {


    public function __construct()
    {
        parent::__construct();

        $this->view_data = array();

        $this->load->model('admin/users_model');

        $this->load->helper(array('url', 'admin/navigation', 'admin/auth'));
        $this->config->load('user_levels');

        $this->layout->set_layout('admin');
        $this->layout->set_navigation(get_admin_navigation(), 'users');

        set_auth_level(1);
    }



    public function index ()
    {
        $this->view_data = array(
            'users'         => $this->users_model->get_users(),
            'user_levels'   => $this->config->item('user_levels')
        );

        $this->layout->set_title('Manage Users');
        $this->layout->render_view('admin/users/index.php', $this->view_data);
    }



    public function add ($action = null)
    {

        $this->view_data['user_levels'] = $this->config->item('user_levels');

        if ($action == 'submit')
        {
            $this->users_model->add_user();
            redirect(site_url(array('admin', 'users')));
        } else {
            $this->layout->set_title('Register a new User');
            $this->layout->render_view('admin/users/add.php', $this->view_data);
        }
    }



    public function delete ($user_id, $action = null)
    {
        $where_conditions = array('id' => $user_id);

        if ($action == 'confirmed')
        {
            $this->users_model->delete_users($where_conditions);
            redirect(site_url(array('admin', 'users')));
        } else {
            $this->view_data['user'] = $this->users_model->get_user($where_conditions);
            $this->layout->set_title('Please confirm your action');
            $this->layout->render_view('admin/users/delete.php', $this->view_data);
        }
    }



    public function edit ($user_id, $action = null)
    {
        $this->view_data = array(
            'user'          => $this->users_model->get_user(array('id' => $user_id)),
            'user_levels'   => $this->config->item('user_levels'),
            'form_actions'  => array(
                                    'main'      => site_url(array('admin', 'users', 'edit', $user_id, 'update')),
                                    'password'  => site_url(array('admin', 'users', 'edit', $user_id, 'update_password'))
                                )
        );

        if ($action == 'update')
        {
            $response = $this->users_model->update_user($user_id);

            if ($response['success'] == false)
            {
                $this->view_data['error'] = $response['error'];
            }
            else
            {
                redirect(site_url(array('admin', 'users')));
            }
        }
        else if ($action == 'update_password')
        {
            $response = $this->users_model->update_password($user_id);

            if ($response['success'] == false)
            {
                $this->view_data['password_error'] = $response['error'];
            }
            else
            {
                redirect(site_url(array('admin', 'users')));
            }
        }

        $this->layout->set_title("Edit user settings: " . $this->view_data['user']->username);
        $this->layout->render_view('admin/users/edit.php', $this->view_data);
    }



    public function move ($user_id, $offset)
    {
        $this->load->model('admin/order_model');

        $this->order_model->move_record(USERS_TABLE_NAME, array('id' => $user_id), $offset);

        redirect(array('admin', 'users'));
    }



}

/* End of file admin/users.php */
/* Location: ./application/controllers/admin/users.php */