<?php class Field_modules_model extends CI_Model {

    var $name;
    var $display_name;
    var $requires_relation;
    var $mysql_type         = array();
    var $media_type         = '';


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }



    function get_settings ()
    {
        $this->config->load('field_modules');
        $field_modules = $this->config->item('field_modules');
        return $field_modules;
    }



    function get_modules ()
    {
        $settings = $this->get_settings();
        return $settings['modules'];
    }



    function get_module ($module_name)
    {
        $field_modules = $this->get_modules();
        $module = $field_modules[$module_name];

        $this->name = $module_name;
        $this->display_name = $module['display_name'];
        $this->requires_relation = $module['requires_relation'];
        $this->mysql_type = $module['mysql_type'];
        $this->media_type = $module['media_type'];
        
        return $this;
    }



    function get_default ()
    {
        $field_modules = $this->get_settings();
        return $field_modules['default'];
    }



    function get_field_relation_entries ($field, $conditions = array())
    {
        $this->load->model('admin/admin/types_model');
        $this->load->model('admin/admin/fields_model');

        $entries = array();
        
        $relation_type = $this->types_model->get_type(array('id' => $field->relation_type_id));
        $relation_field = $this->fields_model->get_field(array('id' => $relation_type->key_field_id));

        $this->db->select('id, ' . $relation_field->field_name);
        $query = $this->db->get_where($relation_type->table_name, $conditions);

        foreach ($query->result_array() as $row)
        {
            array_push($entries, array(
                'id'    => $row['id'],
                'value' => $row[$relation_field->field_name]
            ));
        }

        return $entries;
    }



    function render_field_module ($module_name, $mode, $module_data = array())
    {
        $this->load->model('admin/admin/types_model');
        $this->load->model('admin/admin/fields_model');

        if ($mode == 'edit' && !file_exists(APPPATH . "views/admin/field_modules/$module_name/$mode.php"))
        {
            $mode = 'add';
        }

        if (isset($module_data['field']) && $module_data['field']->relation_type_id !== null)
        {
            $module_data['entries'] = $this->get_field_relation_entries($module_data['field']);
        }

        $field_module = $this->get_module($module_name);
        return $this->load->view("admin/field_modules/$module_name/$mode", $module_data, true);
    }

    

} ?>