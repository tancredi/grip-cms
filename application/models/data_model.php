<?php class Data_model extends CI_Model {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }



    function get_entries ($table_name, $conditions = array(), $order_by = array(ORDER_COLUMN_NAME, 'desc'))
    {
        $this->db->order_by($order_by[0], $order_by[1]);
        $query = $this->db->get_where($table_name, $conditions);

        return $query->result();
    }



    function get_entry ($table_name, $conditions = array(), $order_by = array(ORDER_COLUMN_NAME, 'desc')) {
        $result_array = $this->get_entries($table_name, $conditions, $order_by);
        if (count($result_array) >= 1)
        {
            return $result_array[0];
        }
        return null;
    }




} ?>