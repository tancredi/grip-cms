<?php class Settings_model extends CI_Model {

    var $key;
    var $value  = '';


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }



    function get_settings ($conditions = array())
    {
        $query = $this->db->get_where(SETTING_TABLE_NAME, $conditions);
        return $query->result();
    }



    function get_setting ($key) {
        $result_array = $this->get_types(array('key' => $key));
        if (count($result_array) >= 1)
        {
            return $result_array[0];
        }
        return null;
    }



    function add_setting ($key, $value = '')
    {
        $this->key = $key;
        $this->value = $value;

        $this->db->insert(SETTING_TABLE_NAME, $this);

        return true;

    }



    function update_setting ($key, $value)
    {
        $this->key = $key;
        $this->value = $value;

        $this->db->update(SETTING_TABLE_NAME, $this, array('key' => $key));

        return true;

    }



    function unset ($key)
    {
        $this->db->from(SETTING_TABLE_NAME)->where(array('key' => $key))->delete();
    }



    function set ($key, $value = '')
    {
        if ($this->get_setting($key) != null)
        {
            $this->update_setting($key, $value);
        }
        else
        {
            $this->add_setting($key, $value);
        }
    }







} ?>