<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Types extends CI_Controller {


    public function __construct()
    {
        parent::__construct();

        $this->view_data = array();

        $this->load->model('admin/types_model');

        $this->load->helper(array('url', 'admin/navigation', 'admin/auth'));

        $this->layout->set_layout('admin');
        $this->layout->set_navigation(get_admin_navigation(), 'types');

        set_auth_level(1);
    }



    public function index ()
    {
        $this->view_data['types'] = $this->types_model->get_types();

        $this->layout->set_title('Manage Types');
        $this->layout->render_view('admin/types/index.php', $this->view_data);
    }



    public function add ($action = null)
    {
        $this->view_data['types'] = $this->types_model->get_types();

        if ($action == 'submit')
        {
            $this->types_model->add_type();
            redirect(site_url(array('admin', 'types')));
        } else {
            $this->layout->set_title('Add a new Type');
            $this->layout->render_view('admin/types/add.php', $this->view_data);
        }
    }



    public function delete ($type_id, $action = null)
    {
        $where_conditions = array('id' => $type_id);

        if ($action == 'confirmed')
        {
            $this->types_model->delete_types($where_conditions);
            redirect(site_url(array('admin', 'types')));
        } else {
            $this->view_data['type'] = $this->types_model->get_type($where_conditions);
            $this->layout->set_title('Please confirm your action');
            $this->layout->render_view('admin/types/delete.php', $this->view_data);
        }
    }



    public function edit ($type_id, $action = null)
    {
        $this->load->model('admin/fields_model');
        
        $type = new $this->types_model();
        $type->set_id(intval($type_id));
        $this->view_data = array(
            'type'      => $this->types_model->get_type(array('id' => $type_id)),
            'fields'    => $type->get_fields(),
            'key_field' => $type->get_key_field()
        );

        if ($action == 'update')
        {
            $this->types_model->update_type($type_id);
            redirect(site_url(array('admin', 'types')));
        } else {
            $this->layout->set_title("Edit Type '" . $this->view_data['type']->display_name . "'");
            $this->layout->render_view('admin/types/edit.php', $this->view_data);
        }
    }



    public function move ($type_id, $offset)
    {
        $this->load->model('admin/order_model');

        $this->order_model->move_record(TYPES_TABLE_NAME, array('id' => $type_id), $offset);

        redirect(site_url(array('admin', 'types')));
    }



}

/* End of file admin/types.php */
/* Location: ./application/controllers/admin/types.php */