<?php class Types_model extends CI_Model {

    var $id;
    var $index;
    var $display_name   = '';
    var $table_name     = '';
    var $key_field_id     = '';


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }



    function set_id ($id)
    {
        $this->id = $id;
    }



    private function normalise_table_name ($display_name)
    {
        $this->load->helper('url');
        return url_title($display_name, '_', true);
    }



    private function validate_type_table ($type)
    {
        if ($this->db->table_exists($type->table_name))
        {
            return true;
        } else {
            show_error('Table "' . $type->display_name . '" not found for type "' . $display_name . '"');
            return false;
        }
    }



    function get_types ($conditions = array())
    {
        $types = array();
        
        $this->db->order_by(ORDER_COLUMN_NAME, 'desc');
        $query = $this->db->get_where(TYPES_TABLE_NAME, $conditions);

        foreach ($query->result() as $type) {
            if ($this->validate_type_table($type))
            {
                array_push($types, $type);
            }
        }
        return $types;
    }



    function get_type ($conditions) {
        $result_array = $this->get_types($conditions);
        if (count($result_array) >= 1)
        {
            return $result_array[0];
        }
        return null;
    }



    function add_type ()
    {
        $this->load->dbforge();
        $this->load->model('admin/order_model');

        $this->index            = $this->order_model->get_increment(TYPES_TABLE_NAME);
        $this->display_name     = $_POST['display_name'];
        $this->table_name       = $this->normalise_table_name($this->display_name);
        $this->key_field_id     = null;

        if ($this->db->table_exists($this->table_name))
        {
            show_error("Table '" . $this->table_name . "' was already found in database");
            return false;
        }

        $table_fields = array(
            'id' => array(
                'type'              => 'INT',
                'auto_increment'    => TRUE
            ),
            'index' => array(
                'type'              => 'INT'
            )
        );
        $this->dbforge->add_field($table_fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table($this->table_name, TRUE);
        

        $this->db->insert(TYPES_TABLE_NAME, $this);

        return true;

    }



    function update_type ($type_id)
    {
        $this->load->dbforge();
        $current_type = $this->get_type(array('id' => $type_id));

        $this->display_name     = $_POST['display_name'];
        $this->table_name       = $this->normalise_table_name($this->display_name);
        
        if ($this->db->table_exists($this->table_name))
        {
            show_error("Table '" . $this->table_name . "' was already found in database");
            return false;
        }

        $this->dbforge->rename_table($current_type->table_name, $this->table_name);
        
        $this->db->update(TYPES_TABLE_NAME, $this, array('id' => $type_id));

        return true;

    }



    function delete_types ($conditions)
    {
        $this->load->model('admin/fields_model');

        $this->load->dbforge();
        $type = $this->get_type($conditions);
        if ($this->db->from(TYPES_TABLE_NAME)->where($conditions)->count_all_results() > 0)
        {
            $this->fields_model->delete_fields(array('type_id' => $type->id));
            $this->db->from(TYPES_TABLE_NAME)->where($conditions)->delete();
            $this->dbforge->drop_table($type->table_name);
        }
    }



    function get_fields ()
    {
        $this->load->model('admin/fields_model');
        return $this->fields_model->get_fields(array('type_id' => $this->id));
    }



    function has_key_field ()
    {
        $type = $this->get_type(array('id' => $this->id));
        return ($type->key_field_id != null) ? true : false;
    }



    function get_key_field ()
    {
        $this->load->model('admin/fields_model');
        $type = $this->get_type(array('id' => $this->id));

        if ($this->has_key_field())
        {
            return $this->fields_model->get_field(array('id' => $type->key_field_id));
        } else {
            return null;
        }
    }



    function set_key_field ($field_id)
    {
        $this->db->where(array('id' => $this->id))->update(TYPES_TABLE_NAME, array('key_field_id' => $field_id));
    }



    function unset_key_field ()
    {
        $this->db->where(array('id' => $this->id))->update(TYPES_TABLE_NAME, array('key_field_id' => null));
    }



    function reset_key_field ()
    {
        $fields = $this->get_fields();

        if (count($fields))
        {
            $this->set_key_field($fields[0]->id);
        } else {
            $this->unset_key_field();
        }
    }







} ?>