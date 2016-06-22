<?php
/*
 * @author Osadchyi Serhii
 */

namespace App\Http\Controllers\Models\Shops;

/**
 * Abstract class for all shops
 *
 * @author RDSergij
 */
use GuzzleHttp\Client;
use App\Http\Controllers\Models\Currencies;
abstract class aShop extends \Illuminate\Database\Eloquent\Model {
	/**
	 * Id of shop from DB
	 *
	 * @var int
	 */
	protected $shopId;

	/**
	 * Url of API
	 *
	 * @var string
	 */
	protected $apiUrl;

	/**
	 * Data from API
	 *
	 * @var array 
	 */
	protected $data;

	/**
	 * Memo type
	 *
	 * @var string
	 */
	protected $dataType;

	/**
	 * API cient
	 *
	 * @var object
	 */
	protected $apiClient;

	/**
	 * Model object of curencies
	 *
	 * @var object
	 */
	protected $currencies;

	public function __construct( $options ) {
		// Set variables
		$this->setApiUrl( $options->apiurl );
		$this->setDataType( $options->datatype );
		$this->setShopId( $options->id );
		$this->apiClient = new Client();
		$this->currencies = new Currencies();
	}

	/**
	 * Must be in child classes
	 */
	abstract public function parse();

	/**
	 * Set api url
	 * 
	 * @param string $url
	 */
	public function setApiUrl( $url ) {
		$this->apiUrl = $url;
	}

	/**
	 * Set type of data
	 * 
	 * @param string $dataType
	 */
	public function setDataType( $dataType ) {
		$this->dataType = $dataType;
	}

	/**
	 * Set data
	 * 
	 * @param string $data
	 */
	public function setData( $data ) {
		$this->data = $data;
	}

	/**
	 * Set id of shop
	 * 
	 * @param int $shopId
	 */
	public function setShopId( $shopId ) {
		$this->shopId = $shopId;
	}

	/**
	 * Set api url
	 * 
	 * @param string $url
	 */
	public function getApiUrl() {
		return $this->apiUrl;
	}

	/**
	 * Get api url
	 */
	public function getDataType() {
		return $this->dataType;
	}

	/**
	 * Get shop id
	 */
	public function getShopId() {
		return $this->shopId;
	}

	/**
	 * Get data
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Parser csv to array
	 * 
	 * @param string $dataString
	 * @param bool $headersIndex
	 * @param string $delimiter
	 * @param string $endOfLine
	 * @return \App\Http\Controllers\Models\Shops\aShop
	 */
	protected function csvToArray( $dataString, $headersIndex = true, $delimiter = ',', $endOfLine = "\n" ) {
		$lines = str_getcsv( $dataString, $endOfLine );
		$return = [];
		if ( $headersIndex ) {
			$headers = str_getcsv( $lines[0], $delimiter );
			$headers = array_map( function( $header ) {
				$header = trim($header);
				$header = str_replace( ' ', '_', $header);
				$header = strtolower( $header );
				return $header;
			}, $headers );
			unset( $lines[0] );
		}
		foreach ( $lines as $value ) {
			$rows = str_getcsv( $value, $delimiter );
			if ( $headersIndex ) {
				$rows = array_combine ( $headers, $rows );
			}
			$return[] = $rows;
		}
		$this->setData( $return );
		return $this;
	}

	/**
	 * Parser xml to object
	 * 
	 * @param string $dataString
	 * @return \App\Http\Controllers\Models\Shops\aShop
	 */
	protected function xmlToObject( $dataString ) {
		$this->data = simplexml_load_string( $dataString );
		return $this;
	}
}
