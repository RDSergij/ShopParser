<?php
/*
 * @author Osadchyi Serhii
 */

namespace App\Http\Controllers;

/**
 * Main controller for schedule run
 *
 * @author RDSergij
 */
class Main extends Controller {
	/**
	 * Get and parse shops
	 */
	public function shops() {
		$ShopsObj = new Models\Shops();
		$shopsList = $ShopsObj->getList();
		if ( ! empty( $shopsList ) ) {
			foreach( $shopsList as $shopItem ) {
				$model = 'App\\Http\\Controllers\\Models\\Shops\\' . preg_replace_callback ( "/(_)(.)/",
						function( $matches ) {
							return strtoupper( $matches[2] );
						},
						$shopItem->alias );
				$shop = new $model( $shopItem );
				$ShopsObj->setShopBusy( $shopItem->id );
				$shop->parse();
				$ShopsObj->setShopUnBusy( $shopItem->id );
				unset( $shop );
			}
		}
	}
}
