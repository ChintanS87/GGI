<?php

class Auction extends DataMapper {

	var $model = 'auction';
	var $table = 'auction_details';
	var $has_one = array();
        var $has_many = array();
	
    function __construct($id = NULL) {
		parent::__construct($id);
    }
}

/* End of file product.php */
/* Location: ./application/models/product.php */
