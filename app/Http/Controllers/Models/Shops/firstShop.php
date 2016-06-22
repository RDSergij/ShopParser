<?php
/*
 * @author Osadchyi Serhii
 */

namespace App\Http\Controllers\Models\Shops;

/**
 * Model for first shop
 *
 * @author RDSergij
 */
use App\Http\Controllers\Models as Models;
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

		if ( $this->getDataType() == $datatype[0] ) {
			$body = $response->getBody();
			$data = $this->csvToArray( $body->getContents(), true, "\t", "\n" )->getData();

			foreach ( $data as $rows ) {
				if ( 'Winning Bid (Revenue)' == $rows['event_type'] ) {
					$records[] = [
						'shop_id'		=> 1, //$this->getShopId(),
						'order_id'	    => $rows['unique_transaction_id'],
						'status'	    => 'approved',
						'amount'	    => $rows['ebay_total_sale_amount'],
						'currency_id'	=> $this->currencies->getCurrencyId( 'usd' ),
						'datetime'		=> $rows['click_timestamp'],
					];
				}
			}

			if ( ! empty( $records ) && count( $records ) ) {
				$orders = new Models\Orders();
				$orders->multiSave( $records );
			}
		} else {
			//...
		}
	}
}
