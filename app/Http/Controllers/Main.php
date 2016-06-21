<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

//use App\Http\Controllers\Controller;

/**
 * Description of main
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
				$shop->parse();
				unset( $shop );
			}
		}
	}
}
