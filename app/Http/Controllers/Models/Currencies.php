<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Http\Controllers\Models;

/**
 * Description of Shops
 *
 * @author RDSergij
 */
class Currencies extends \Illuminate\Database\Eloquent\Model {
	protected $table = 'currencies';
	
	public static function getCurrencyId( $name ) {
		$name = strtolower( $name );
		$item = self::first( 'name', '=', $name );
		return $item->id;
	}
}
