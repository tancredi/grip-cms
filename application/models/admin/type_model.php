<?php class Type_model extends CI_Model {


    var $type;


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }



    function set_type ($conditions)
    {
        $this->type = $this->types_model->get_type($conditions);
    }



    function get_fields ($return_array = false)
    {
        $this->load->model('admin/types_model');
        $type = new $this->types_model();
        $type->set_id($this->type->id);
        return $type->get_fields($return_array);
    }



    function get_entries ($limit = null, $offset = null, $order_by = null, $conditions = null)
    {
        $this->load->model('admin/types_model');
        $this->load->model('admin/fields_model');

        $type = $this->types_model->get_type(array('id' => $this->type->id));
        $fields = $this->fields_model->get_fields(array('type_id' => $this->type->id));
        $select_fields_array = array();

        foreach ($fields as $field)
        {
            array_push($select_fields_array, $field->field_name);
        }
        
        if ($limit != null)
        {
            $this->db->limit($limit);
        }

        if ($offset != null)
        {
            $this->db->offset($offset);
        }

        if ($conditions != null)
        {
            $this->db->where($conditions);
        }

        if ($order_by != null && $order_by[0] != null && $order_by[1] != null)
        {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by(ORDER_COLUMN_NAME, 'desc');
        }

        $this->db->from($this->type->table_name)->select('id, ' . implode(', ', $select_fields_array));

        return $this->db->get()->result_array();
    }



    function get_entries_count () {
        return $this->db->from($this->type->table_name)->count_all_results();
    }



    function get_entry ($conditions, $order_by = null)
    {

        $entries = $this->get_entries(null, null, $order_by, $conditions);
        return $entries[0];
    }



    function get_last_entry ()
    {
        return $this->get_entry(array(), array('id', 'desc'));
    }

    function upload_file ($field_name, $allowed_types = '*')
    {
        if ($_FILES[$field_name]['size'] !== 0)
        {
            $this->config->load('file_upload');
            $upload_config = $this->config->item('file_upload');
            $upload_config['allowed_types'] = $allowed_types;
            $this->load->library('upload', $upload_config);

            if (!$this->upload->do_upload($field_name))
            {
                show_error($this->upload->display_errors());
                die();
            }
            else
            {
                $path = $upload_config['upload_path'];
                $path = (substr($path, 0, 1) == '.') ? substr($path, 1) : $path;
                $file = $this->upload->data();
                return $path . $file['file_name'];
            }
        } else {
            return '';
        }
    }



    function add_entry ()
    {
        $this->load->model('admin/order_model');

        $fields = $this->get_fields();
        $data = array();
        $data['index'] = $this->order_model->get_increment($this->type->table_name);

        foreach ($fields as $field)
        {
            if (isset($_POST[$field->field_name]))
            {
                $data[$field->field_name] = $_POST[$field->field_name];
            }
            else if (isset($_FILES[$field->field_name]))
            {
                $data[$field->field_name] = $this->upload_file($field->field_name);
            }
            else
            {
                show_error('No data was passed for field "' . $field->display_name . '"');
                die();
            }
        }

        $this->db->insert($this->type->table_name, $data);
    }



    function update_entry ($conditions)
    {
        $fields = $this->get_fields();
        foreach ($fields as $field)
        {
            
            if (isset($_POST[$field->field_name]))
            {
                $data[$field->field_name] = $_POST[$field->field_name];
            }
            else if (isset($_FILES[$field->field_name]))
            {
                if ($_FILES[$field->field_name]['name'] != '')
                {
                    $data[$field->field_name] = $this->upload_file($field->field_name);
                }
            }
        }

        $this->db->where($conditions)->update($this->type->table_name, $data);
    }



    function delete_entry ($conditions)
    {
        $this->db->where($conditions)->delete($this->type->table_name);
    }




} ?>