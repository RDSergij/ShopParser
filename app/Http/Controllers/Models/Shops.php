<?php
/*
 * @author Osadchyi Serhii
 */
namespace App\Http\Controllers\Models;

/**
 * Model for shops
 *
 * @author RDSergij
 */
class Shops extends \Illuminate\Database\Eloquent\Model {
	protected $table = 'shops';
	public $timestamps = false;

	/**
	 * Get shop list for parse
	 */
	public function getList() {
		return $this->where( 'is_busy', '=', '0' )->get();
	}

	/**
	 * Set shop as busy
	 * 
	 * @param int $shopId
	 */
	public function setShopBusy( $shopId ) {
		$shop = self::find( $shopId );
		$shop->is_busy = 1;
		$shop->save();
	}

	/**
	 * Set shop unbusy
	 * 
	 * @param int $shopId
	 */
	public function setShopUnBusy( $shopId ) {
		$shop = self::find( $shopId );
		$shop->is_busy = 0;
		$shop->save();
	}
}
