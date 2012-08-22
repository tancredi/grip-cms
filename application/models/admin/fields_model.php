<?php class Fields_model extends CI_Model {

    var $id;
    var $index;
    var $display_name       = '';
    var $field_name         = '';
    var $type_id;
    var $module             = '';
    var $relation_type_id;


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }



    function set_id ($id)
    {
        $this->id = $id;
    }



    private function normalise_field_name ($display_name)
    {
        $this->load->helper('url');
        return url_title($display_name, '_', true);
    }



    function set_type_id ($type_id)
    {
        $this->type_id = $type_id;
    }



    private function validate_field ($field)
    {
        $this->type_id = $field->type_id;
        $table_name = $this->get_type()->table_name;
        if ($this->db->field_exists($field->field_name, $table_name))
        {
            return true;
        } else {
            show_error("Field '$field->field_name' not found for table '$table_name'");
            return false;
        }
    }



    function get_fields ($conditions = array(), $return_array = false)
    {
        $fields = array();
        $this->db->order_by(ORDER_COLUMN_NAME, 'desc');
        $query = $this->db->get_where(FIELDS_TABLE_NAME, $conditions);

        if ($return_array)
        {
            $result = $query->result_array();
        } else {
            $result = $query->result();
        }

        return $result;
    }



    function get_field ($conditions) {
        $result_array = $this->get_fields($conditions);
        if (count($result_array) >= 1)
        {
            return $result_array[0];
        }
        return false;
    }



    function get_last_field ()
    {
        $query = $this->db->limit(1)->from(FIELDS_TABLE_NAME)->order_by('id', 'desc')->get();
        $result = $query->result();
        return $result[0];
    }



    function get_type ($conditions = array())
    {
        $this->load->model('admin/types_model');
        if (count($conditions) == 0) {
            $conditions = array('id' => $this->type_id);
        }
        return $this->types_model->get_type($conditions);
    }



    function delete_fields ($conditions)
    {
        $ci =& get_instance();
        $ci->load->model('admin/types_model');

        $this->load->dbforge();
        $field = $this->get_field($conditions);
        $type = $this->get_type(array('id' => $field->type_id));

        $type_obj = new $ci->types_model();
        $type_obj->set_id($field->type_id);

        if ($this->db->from(FIELDS_TABLE_NAME)->where($conditions)->count_all_results() != 0)
        {
            $this->db->from(FIELDS_TABLE_NAME)->where($conditions)->delete();
            $this->dbforge->drop_column($type->table_name, $field->field_name);
        }

        if ($type_obj->get_key_field() == null) {
            $type_obj->reset_key_field();
        }
    }



    function add_field ()
    {
        $this->load->dbforge();
        $this->load->model('admin/order_model');
        $this->load->model('admin/field_modules_model');

        $this->index               = $this->order_model->get_increment(FIELDS_TABLE_NAME);
        $this->type_id             = $_POST['type_id'];
        $this->display_name        = $_POST['display_name'];
        $this->field_name          = $this->normalise_field_name($this->display_name);
        $this->module              = $_POST['module'];
        $this->relation_type_id    = ($_POST['relation_type_id'] == '') ? null : $_POST['relation_type_id'];

        $type_object = new $this->types_model();
        $type_object->set_id($this->type_id);

        $type = $this->get_type();

        $table_name = $type->table_name;
        $field_modules = $this->field_modules_model->get_modules();

        if ($this->db->field_exists($this->field_name, $table_name))
        {
            show_error("Field '" . $this->field_name . "' already exists in table '$table_name'");
            return false;
        }

        $this->dbforge->add_column($table_name,
            array($this->field_name => $field_modules[$this->module]['mysql_type'])
        );
        
        $this->db->insert(FIELDS_TABLE_NAME, $this);

        if (!$type_object->has_key_field())
        {
            $type_object->reset_key_field();
        }
    }



    function update_field ()
    {
        $this->load->dbforge();
        $this->load->model('admin/field_modules_model');
        $this->id                  = $_POST['field_id'];
        $this->type_id             = $_POST['type_id'];
        $this->display_name        = $_POST['display_name'];
        $this->field_name          = $this->normalise_field_name($this->display_name);
        $this->module              = $_POST['module'];
        $this->relation_type_id    = ($_POST['relation_type_id'] == '') ? null : $_POST['relation_type_id'];

        $type = $this->get_type();

        $current_field = $this->get_field(array('id' => $this->id));

        $field_name_changed = ($current_field->field_name != $this->field_name) ? true : false;
        
        $table_name = $type->table_name;
        $field_modules = $this->field_modules_model->get_modules();

        if ($field_name_changed && $this->db->field_exists($this->field_name, $table_name))
        {
            show_error("Field '" . $this->field_name . "' already exists in table '$table_name'");
            return false;
        }

        $field_data = array_merge(
            $field_modules[$this->module]['mysql_type'],
            array('name' => $this->field_name)
        );

        if ($field_name_changed)
        {
            $this->dbforge->modify_column($table_name, array(
                $current_field->field_name => $field_data
            ));
        }
        
        $this->db->update(FIELDS_TABLE_NAME, array(
            'display_name'      => $this->display_name,
            'field_name'        => $this->field_name,
            'module'            => $this->module,
            'relation_type_id'  => $this->relation_type_id
        ), array (
            'id' => $this->id
        ));

        return true;
    }

    

} ?>