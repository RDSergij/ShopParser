<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Models\Shops;

/**
 * Description of aShop
 *
 * @author RDSergij
 */
use GuzzleHttp\Client;
abstract class aShop extends \Illuminate\Database\Eloquent\Model {
	protected $shopId;
	protected $apiUrl;
	protected $data;
	protected $dataType;
	protected $apiClient;

	public function __construct( $options ) {
		$this->setApiUrl( $options->apiurl );
		$this->setDataType( $options->datatype );
		$this->setShopId( $options->id );
		$this->apiClient = new Client();
	}

	abstract public function parse();

	public function setApiUrl( $url ) {
		$this->apiUrl = $url;
	}

	public function setDataType( $dataType ) {
		$this->dataType = $dataType;
	}

	public function setShopId( $shopId ) {
		$this->shopId = $shopId;
	}

	public function getApiUrl() {
		return $this->apiUrl;
	}

	public function getDataType() {
		return $this->dataType;
	}

	public function getShopId() {
		return $this->shopId;
	}

	public function getData() {
		return $this->data;
	}

	protected function csvToArray( $dataString, $delimiter = ',' ) {
		$this->data = str_getcsv( $dataString, $delimiter );
	}

	protected function xmlToObject( $dataString ) {
		$this->data = simplexml_load_string( $dataString );
	}
}
