<?php

class Product extends DataMapper {

	var $model = 'product';
	var $table = 'product_details';
	var $has_one = array('auction');
        var $has_many = array();
	
    function __construct($id = NULL) {
		parent::__construct($id);
    }
}

/* End of file product.php */
/* Location: ./application/models/product.php */
