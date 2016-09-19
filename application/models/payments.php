<?php

class Payments extends DataMapper {

	var $model = 'payments';
	var $table = 'user_payments';
	var $has_one = array();
        var $has_many = array();
	
    function __construct($id = NULL) {
		parent::__construct($id);
    }
}

/* End of file product.php */
/* Location: ./application/models/product.php */
