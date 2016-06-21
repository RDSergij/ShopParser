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

class firstShop extends aShop {

	public function __construct( $options ) {
		parent::__construct( $options );
	}
	
	/**
	 * Parse data for model
	 */
	public function parse() {
		$response = $this->apiClient->request('GET', $this->apiUrl );
		if ( '200' !=  $response->getStatusCode() ) {
			return null;
		}
		$datatype = $response->getHeader('content-type');
		if ( 'text/csv' == $datatype[0] ) {
			$body = $response->getBody();
			$this->csvToArray( $body->getContents(), "\t" );
			$data = $this->getData();
			$headers = array_shift ( $data );
			var_dump( $data[0] );
			$headers = array_map( function( $header ) {
				$header = str_replace( ' ', '_', $header);
				$header = strtolower( $header );
			}, $headers );
			$records = [];
			foreach ( $data as $rows ) {
				$rows = array_combine ( $headers, $rows );
				if ( 'Winning Bid (Revenue)' == $rows['event_type'] ) {
					$records[] = [
						'shop_id'		=> $this->getShopId(),
						'order_id'	    => $rows['unique_transaction_id'],
						'status'	    => 'approved',
						'amount'	    => $rows['ebay_total_sale_amount'],
						'currency_id'	=> Currencies::getCurrencyId( 'usd' ),
						'datetime'		=> $rows['click_timestamp'],
					];
				}
			}
			if ( ! empty( $records ) && count( $records ) ) {
				$orders = new Orders();
				$orders->saveMany( $records );
			}
		} else {
			//...
		}
	}
}
