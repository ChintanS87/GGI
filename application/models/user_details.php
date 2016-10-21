<?php

class User_Details extends DataMapper {

	var $model = 'user_details';
	var $table = 'user_details';
	var $has_one = array();
        var $has_many = array();
	
    function __construct($id = NULL) {
		parent::__construct($id);
    }
    
    
    function is_mobile_available($mobile)
    {
            $this->db->select('1', FALSE);
            $this->db->where('contact_number', $mobile);
 
            $query = $this->db->get($this->table);
            return $query->num_rows() == 0;
    }    
}

/* End of file product.php */
/* Location: ./application/models/product.php */
