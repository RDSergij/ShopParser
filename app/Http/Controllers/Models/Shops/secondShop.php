<?php
/*
 * @author Osadchyi Serhii
 */

namespace App\Http\Controllers\Models\Shops;

/**
 * Model for second shop
 *
 * @author RDSergij
 */
use App\Http\Controllers\Models as Models;
class secondShop extends aShop {

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
			$xml = $this->xmlToObject( $body->getContents() )->getData();
			$data = $xml->stat;

			foreach ( $data as $attr ) {
				$records[] = [
					'shop_id'		=> $attr->advcampaign_id[0],
					'order_id'	    => $attr->order_id[0],
					'status'	    => $attr->status[0],
					'amount'	    => $attr->cart[0],
					'currency_id'	=> $this->currencies->getCurrencyId( $attr->currency[0] ),
					'datetime'		=> $attr->action_date[0],
				];
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
