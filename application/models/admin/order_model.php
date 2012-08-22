<?php class Order_model extends CI_Model {

    var $table_name     = '';



    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }



    function set_table_name ($table_name)
    {
        $this->table_name = $table_name;
    }



    function get_max ()
    {
        $this->db->select_max(ORDER_COLUMN_NAME, 'max');
        $query = $this->db->get($this->table_name);
        $result = $query->result();
        return $result[0]->max;
    }



    function get_increment ($table_name = null)
    {
        if ($table_name != null)
        {
            $this->set_table_name($table_name);
        }
        return $this->get_max() + 1;
    }



    function move_record ($table_name, $record_conditions, $offset)
    {
        $this->set_table_name($table_name);
        $order_column_name = ORDER_COLUMN_NAME;
        $direction = ($offset > 0) ? 1 : -1;

        $result = $this->db->get_where($this->table_name, $record_conditions)->result();
        $subject = $result[0];

        if ($direction == 1)
        {
            $this->db->where(ORDER_COLUMN_NAME . ' >', $subject->$order_column_name);
            $this->db->where(ORDER_COLUMN_NAME . ' <=', $subject->$order_column_name + $offset);
        } else {
            $this->db->where(ORDER_COLUMN_NAME . ' <', $subject->$order_column_name);
            $this->db->where(ORDER_COLUMN_NAME . ' >=', $subject->$order_column_name + $offset);
        }
        $targets = $this->db->get($this->table_name)->result();

        $offset -=  $offset - $direction * count($targets);

        foreach ($targets as $target)
        {
            $this->db->where(array('id' => $target->id));
            $this->db->update($this->table_name, array(ORDER_COLUMN_NAME => $target->$order_column_name - $direction)); 
        }

        $this->db->where(array('id' => $subject->id));
        $this->db->update($this->table_name, array(ORDER_COLUMN_NAME => $subject->$order_column_name + $offset));
    }













} ?>