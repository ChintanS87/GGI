<?php

class Referals extends DataMapper {

	var $model = 'referals';
	var $table = 'referals';
	var $has_one = array();
        var $has_many = array();
	
    function __construct($id = NULL) {
		parent::__construct($id);
    }
}

/* End of file referals.php */
/* Location: ./application/models/referals.php */
