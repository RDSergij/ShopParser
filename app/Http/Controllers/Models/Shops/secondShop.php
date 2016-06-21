<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Models\Shops;

/**
 * Description of firstShop
 *
 * @author RDSergij
 */

class secondShop extends aShop {

	public function __construct( $options ) {
		parent::__construct( $options );
	}
	
	/**
	 * Parse data for model
	 */
	public function parse() {

		//$response = $this->apiClient->request('GET', $this->apiUrl );
//$body = $response->getBody();
//echo $body;
		if ( 'csv' == $this->dataType ) {
			$this->csvToArray( $this->data );
			//var_dump( $this->getDa );
		} else {
			//...
		}
	}
}
