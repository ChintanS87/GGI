<?php

class User_Coins extends DataMapper {

	var $model = 'user_coins';
	var $table = 'user_coins';
	var $has_one = array();
        var $has_many = array();
	
    function __construct($id = NULL) {
		parent::__construct($id);
    }
      
}

/* End of file product.php */
/* Location: ./application/models/product.php */
