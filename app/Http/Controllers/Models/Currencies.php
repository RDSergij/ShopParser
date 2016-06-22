<?php
/*
 * @author Osadchyi Serhii
 */
namespace App\Http\Controllers\Models;

/**
 * Model for currencies
 *
 * @author RDSergij
 */
use DB;
class Currencies extends \Illuminate\Database\Eloquent\Model {
	protected $table = 'currencies';
	public $timestamps = false;

	/**
	 * Currencies cache
	 *
	 * @var array
	 */
	private static $currencies;

	/**
	 * Get currency id from cache
	 * 
	 * @param string $key 
	 * @return null/int
	 */
	private static function getCacheCurrency( $key ) {
		if ( ! empty( self::$currencies[ $key ] ) ){
			return self::$currencies[ $key ];
		}
		return null;
	}

	/**
	 * Set currency to static cache
	 * 
	 * @param string $key 
	 * @param integer $id 
	 */
	private static function setCacheCurrency( $key, $id ) {
		self::$currencies[ $key ] = $id;
	}

	/**
	 * Get currency id by name
	 * 
	 * @param string $name
	 * @return integer
	 */
	public function getCurrencyId( $name ) {
		$name = strtolower( $name );
		if ( ! empty( self::getCacheCurrency( $name ) ) ) {
			return  self::getCacheCurrency( $name );
		}
		$item = $this->where( [ 'name' => $name ] )->first();
		if ( empty( $item->id ) ) {
			$new = new self;
			$new->name = $name;
			$new->save();
			$id = $new->id;
		} else {
			$id = $item->id;
		}
		self::setCacheCurrency( $name, $id );
		return $item->id;
	}
}
