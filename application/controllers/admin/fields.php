<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fields extends CI_Controller {


    public function __construct()
    {
        parent::__construct();

        $this->view_data = array();

        $this->load->model('admin/field_modules_model');
        $this->load->model('admin/fields_model');

        $this->load->helper(array('url', 'admin/navigation', 'admin/auth'));

        $this->layout->set_layout('admin');
        $this->layout->set_navigation(get_admin_navigation(), 'types');

        set_auth_level(1);
    }
    


    public function index ($type_id)
    {
        $this->load->model('admin/types_model');

        $type_obj = new $this->types_model();
        $type_obj->set_id(intval($type_id));

        $type = $this->types_model->get_type(array('id' => $type_id));

        $this->view_data = array(
            'type'      => $type,
            'fields'    => $type_obj->get_fields(),
            'key_field' => $type_obj->get_key_field()
        );

        $this->layout->set_title("Fields list for type '" . $type->display_name . "'");

        $this->layout->render_view('admin/fields/index.php', $this->view_data);

    }



    public function add ($type_id, $action = '')
    {
        $this->load->model('admin/types_model');

        $type = $this->types_model->get_type(array('id' => $type_id));

        $this->view_data = array(
            'type'                  => $type,
            'types'                 => $this->types_model->get_types(),
            'default_field_module'  => $this->field_modules_model->get_default(),
            'field_modules'        => $this->field_modules_model->get_modules()
            );

        if ($action == 'submit')
        {
            $this->fields_model->add_field();
            redirect(site_url(array('admin', 'types', 'edit', $type->id)));
        } else {
            $this->layout->set_title("Add a field for Type '" . $this->view_data['type']->display_name . "'");
            $this->layout->render_view('admin/fields/add.php', $this->view_data);
        }

    }



    public function delete ($field_id, $action = '')
    {
        $this->load->model('admin/types_model');

        $field = $this->view_data['field'] = $this->fields_model->get_field(array('id' => $field_id));
        $type = $this->view_data['type'] = $this->types_model->get_type(array('id' => $this->view_data['field']->type_id));

        if ($action == 'confirmed')
        {
            $this->fields_model->delete_fields(array('id' => $field_id));
            redirect(site_url(array('admin', 'types', 'edit', $type->id)));
        } else {
            $this->layout->set_title('Please confirm your action');
            $this->layout->render_view('admin/fields/delete.php', $this->view_data);
        }   
    }



    public function edit ($field_id, $action = '')
    {
        $this->load->model('admin/types_model');
        $this->load->model('admin/field_modules_model');

        $field = $this->fields_model->get_field(array('id' => $field_id));
        $type = $this->types_model->get_type(array('id' => $field->type_id));

        $this->view_data = array(
            'field'         => $field,
            'type'          => $type,
            'types'         => $this->types_model->get_types(),
            'field_modules' => $this->field_modules_model->get_modules()
        );

        if ($action == 'update')
        {
            $this->fields_model->update_field();
            redirect(site_url(array('admin', 'types', 'edit', $type->id)));
        } else {
            $this->layout->set_title("Edit field '" . $field->display_name . "' for '" . $type->display_name . '"');
            $this->layout->render_view('admin/fields/edit.php', $this->view_data);
        }   
    }



    public function set_key ($field_id, $action = '')
    {
        $this->load->model('admin/types_model');

        $field = $this->fields_model->get_field(array('id' => $field_id));
        $type = $this->types_model->get_type(array('id' => $field->type_id));
    
        $type_obj = new $this->types_model();
        $type_obj->set_id($type->id);
        $type_obj->set_key_field($field_id);

        redirect(site_url(array('admin', 'types', 'edit', $type->id)));
    }



    public function move ($field_id, $offset)
    {
        $this->load->model('admin/order_model');

        $field = $this->fields_model->get_field(array('id' => $field_id));
        $type = $this->types_model->get_type(array('id' => $field->type_id));

        $this->order_model->move_record(FIELDS_TABLE_NAME, array('id' => $field_id), $offset);

        redirect(site_url(array('admin', 'types', 'edit', $type->id)));
    }




}

/* End of file admin/fields.php */
/* Location: ./application/controllers/admin/fields.php */