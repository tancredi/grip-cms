<?php class Users_model extends CI_Model {

    var $id;
    var $index;
    var $username   = '';
    var $email      = '';
    var $password   = '';
    var $level;


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }



    function set_id ($id)
    {
        $this->id = $id;
    }



    function get_users ($conditions = array())
    {
        $users = array();
        
        $this->db->order_by(ORDER_COLUMN_NAME, 'desc');
        $query = $this->db->get_where(USERS_TABLE_NAME, $conditions);

        return $query->result();
    }



    function get_user ($conditions) {
        $result_array = $this->get_users($conditions);
        if (count($result_array) >= 1)
        {
            return $result_array[0];
        }
        return null;
    }



    function add_user ()
    {
        $this->load->model('admin/order_model');

        if ($_POST['password'] !== $_POST['confirm-password'])
        {
            return array(
                'success'   => false,
                'error'     => 'Password confirmation doesn\'t match'
            );
        }
        else if (count($this->get_users(array('username' => $_POST['username']))) !== 0)
        {
            return array(
                'success'   => false,
                'error'     => 'Username is not available'
            );
        }
        else if (count($this->get_users(array('email' => $_POST['email']))) !== 0)
        {
            return array(
                'success'   => false,
                'error'     => 'Email address is not available'
            );
        }

        $this->index       = $this->order_model->get_increment(USERS_TABLE_NAME);
        $this->username    = $_POST['username'];
        $this->email       = $_POST['email'];
        $this->password    = md5($_POST['password']);
        $this->level       = $_POST['level'];

        $this->db->insert(USERS_TABLE_NAME, $this);

        return array('success' => true);

    }



    function update_user ($user_id)
    {
        $this->load->library('session');

        $current_user = $this->get_user(array('id' => $user_id));

        if ($_POST['username'] != $current_user->username && count($this->get_users(array('username' => $_POST['username']))) !== 0)
        {
            return array(
                'success'   => false,
                'error'     => 'Username is not available'
            );
        }

        $this->id          = $current_user->id;
        $this->username    = $_POST['username'];
        $this->email       = $current_user->email;
        $this->password    = $current_user->password;
        $this->level       = $_POST['level'];
        
        $this->db->update(USERS_TABLE_NAME, $this, array('id' => $user_id));

        if ($this->session->userdata('user')->id == $this->id)
        {
            $this->logout();
            redirect(array('admin', 'login'));
        }

        return array('success' => true);

    }



    function update_password ($user_id)
    {
        if ($_POST['password'] != $_POST['confirm-password'])
        {
            return array(
                'success'   => false,
                'error'     => 'Password confirmation doesn\'t match'
            );
        }
        
        $this->db->update(USERS_TABLE_NAME, array('password' => md5($_POST['password'])), array('id' => $user_id));

        return array('success' => true);

    }



    function delete_users ($conditions)
    {
        $this->db->from(USERS_TABLE_NAME)->where($conditions)->delete();
    }



    function login ()
    {
        $this->load->library('session');

        $username_email = $_POST['username-email'];
        $password = $_POST['password'];

        $user = $this->get_user(array('username' => $username_email));
        if ($user == null)
        {
            $user = $this->get_user(array('email' => $username_email));
            if ($user == null)
            {
                return array(
                    'success'   => false,
                    'error'     => 'User not found.'
                );
            }
        }

        if (md5($password) != $user->password)
        {
            return array(
                'success'   => false,
                'error'     => 'Incorrect password.'
            );
        }

        $this->session->set_userdata(array(
            'user'  => $user,
            'logged_in' => true
        ));

        return array(
            'success'   => true,
            'user'      => $user
        );

    }



    function logout ()
    {
        $this->load->library('session');
        $this->session->unset_userdata(array(
            'user_id'  => '',
            'username'  => '',
            'logged_in' => '',
            'level'     => ''
        ));

    }






} ?>