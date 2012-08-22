<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Type extends CI_Controller {


    public function __construct($table_name = '')
    {
        parent::__construct();

        $this->view_data = array();
        $this->load->model('admin/type_model');
        $this->load->model('admin/field_modules_model');

        $this->load->helper(array('url', 'admin/navigation', 'admin/auth'));

        $this->layout->set_layout('admin');
        $this->layout->set_navigation(get_admin_navigation());

        set_auth_level(2);
    }



    public function index ($table_name, $sort_column = null, $sort_direction = null, $page = 0)
    {
        $this->load->library('table');
        $this->load->helper('admin/media_type');
        $this->load->model('admin/field_modules_model');
        $this->load->model('admin/fields_model');

        $this->instance = new $this->type_model();
        $this->instance->set_type(array('table_name' => $table_name));

        $order_by = array($sort_column, $sort_direction);

        $type = $this->instance->type;
        $fields = $this->instance->get_fields(true);

        $entries_total = $this->instance->get_entries_count();
        $pages_total = ceil($entries_total / MAX_ENTRIES_PER_PAGE);

        $pagination_data = array(
            'current_page'  => $page,
            'entries_total' => $entries_total,
            'pages_total'   => $pages_total,
            'order_by'      => $order_by,
            'type'          => $type
        );

        $entries = $this->instance->get_entries(MAX_ENTRIES_PER_PAGE, MAX_ENTRIES_PER_PAGE * $page, $order_by);

        // Prepare table data [start]

        $table_data = array(array());

        foreach ($fields as $field)
        {
            $table_header = $this->load->view(
                'admin/type/partials/index-table-header.php', array(
                    'type'      => $type,
                    'order_by'  => $order_by,
                    'field'     => $field
                ), true);
            array_push($table_data[0], $table_header);
        }

        $commands_header = '';
        array_push($table_data[0], $commands_header);

        foreach ($entries as $entry)
        {
            $row_data = array();
            $i = 0;
            foreach ($entry as $field_name => $value)
            {
                if ($field_name != 'id')
                {
                    $field_module = $this->field_modules_model->get_module($fields[$i]->module);

                    if ($field_module->requires_relation == true)
                    {
                        if (count(explode(',', $value)) >> 1)
                        {
                            $value = count(explode(',', $value)) . ' entries';
                        }
                        else if ($value != '')
                        {
                            $field = $this->fields_model->get_field(array('field_name' => $field_name));
                            $relation_entry = $this->field_modules_model->get_field_relation_entries($field, array('id' => $value));
                            
                            if ($relation_entry != null)
                            {
                                $relation_entry = $relation_entry[0];
                                $value = $relation_entry['value'];
                            }
                        }
                    }

                    array_push($row_data, get_field_module_media_type_output($fields[$i]->module, 'index', $value));
                    $i++;
                }
            }

            $entry_commands_html = $this->load->view('admin/type/partials/entry-actions.php', array(
                'type'  => $type,
                'entry' => $entry
            ), true);
            array_push($row_data, $entry_commands_html);

            array_push($table_data, $row_data);
        }

        $this->view_data = array(
            'type'          => $type,
            'table_data'    => $table_data,
            'entries'       => $entries
        );

        // Prepare table data [end]

        $this->layout->set_navigation(get_admin_navigation(), $table_name);

        $this->layout->add_view('admin/type/partials/index-pagination.php', $pagination_data);
        $this->layout->add_view('admin/type/index.php', $this->view_data);
        $this->layout->add_view('admin/type/partials/index-pagination.php', $pagination_data);
        $this->layout->add_view('admin/type/partials/index-add-entry.php', $pagination_data);

        $this->layout->set_title("Administrate " . $this->instance->type->display_name);
        $this->layout->render();
    }



    public function add ($table_name, $action = null)
    {
        $this->load->helper('form');

        $this->instance = new $this->type_model();
        $this->instance->set_type(array('table_name' => $table_name));
        $fields = $this->instance->get_fields(true);
        $type = $this->instance->type;

        foreach ($fields as $key => $field)
        {
            $fields[$key] = $this->field_modules_model->render_field_module($field->module, 'add', array(
                'field'         => $field,
                'current_value' => null
            ));
        }

        $this->view_data = array(
            'fields'        => $fields,
            'type'          => $type
        );

        $this->layout->set_navigation(get_admin_navigation(), $table_name);
        $this->layout->set_title($this->instance->type->display_name . " - New Entry");

        if ($action == 'submit')
        {
            $this->instance->add_entry();
            redirect(site_url(array('admin', 'type', 'index', $table_name)));
        }
        else
        {
            $this->layout->render_view('admin/type/add', $this->view_data);
        }
    }



    public function edit ($table_name, $entry_id, $action = null)
    {
        $this->load->helper('form');

        $this->instance = new $this->type_model();
        $this->instance->set_type(array('table_name' => $table_name));
        $fields = $this->instance->get_fields(true);
        $type = $this->instance->type;
        $entry = $this->instance->get_entry(array('id' => $entry_id));

        foreach ($fields as $key => $field)
        {
            $fields[$key] = $this->field_modules_model->render_field_module($field->module, 'edit', array(
                'field'         => $field,
                'current_value' => $entry[$field->field_name]
            ));
        }

        $this->view_data = array(
            'fields'    => $fields,
            'type'      => $type,
            'entry'     => $entry
        );

        $this->layout->set_navigation(get_admin_navigation(), $table_name);
        $this->layout->set_title($this->instance->type->display_name . " - Edit Entry");

        if ($action == 'submit')
        {
            $this->instance->update_entry(array('id' => $entry_id));
            redirect(site_url(array('admin', 'type', 'view', $table_name, $entry_id)));
        }
        else
        {
            $this->layout->render_view('admin/type/edit', $this->view_data);
        }
    }



    public function delete ($table_name, $entry_id, $action = null)
    {
        $this->instance = new $this->type_model();
        $this->instance->set_type(array('table_name' => $table_name));

        $this->layout->set_navigation(get_admin_navigation(), $table_name);
        $this->layout->set_title($this->instance->type->display_name . " - Delete Entry");

        $this->view_data = array (
            'type'      => $this->instance->type,
            'entry_id'  => $entry_id
        );

        if ($action == 'confirmed')
        {
            $this->instance->delete_entry(array('id' => $entry_id));
            redirect(site_url(array('admin', 'type', 'index', $table_name)));
        }
        else
        {
            $this->layout->render_view('admin/type/delete', $this->view_data);
        }
    }



    public function view ($table_name, $entry_id)
    {
        $this->load->helper('admin/media_type');
        
        $this->instance = new $this->type_model();
        $this->instance->set_type(array('table_name' => $table_name));

        $fields = $this->instance->get_fields(true);
        $entry = $this->instance->get_entry(array('id' => $entry_id));

        $entry_data = array();

        foreach ($fields as $field)
        {
            $value = $entry[$field->field_name];

            $field_module = $this->field_modules_model->get_module($field->module);

            if ($field_module->requires_relation == true)
            {
                $ids = explode(',', $value);
                $i = 0;

                if ($value != '')
                {
                    $value = '';
                    foreach ($ids as $id)
                    {
                        $relation_entry = $this->field_modules_model->get_field_relation_entries($field, array('id' => $id));
                        
                        if ($relation_entry != null)
                        {
                            $relation_entry = $relation_entry[0];
                            $value .= $relation_entry['value'];

                            if ($i != count($ids) - 1)
                            {
                                $value .= '<br /><br />';
                            }
                        }
                        $i++;
                    }
                }
            }

            $entry_data[$field->field_name] = get_field_module_media_type_output($field->module, 'view', $value);
        }

        $this->view_data = array (
            'type'          => $this->instance->type,
            'fields'        => $fields,
            'entry'         => $entry,
            'entry_data'    => $entry_data
        );

        
        $this->layout->set_navigation(get_admin_navigation(), $table_name);
        $this->layout->set_title($this->instance->type->display_name . " - View Entry");
        $this->layout->render_view('admin/type/view', $this->view_data);
    }



    public function move ($table_name, $entry_id, $offset)
    {
        $this->load->model('admin/order_model');

        $this->order_model->move_record($table_name, array('id' => $entry_id), $offset);

        redirect(site_url(array('admin', 'type', 'index', $table_name)));
    }


}

/* End of file admin/type.php */
/* Location: ./application/controllers/admin/type.php */