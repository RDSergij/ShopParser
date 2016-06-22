<?php
/*
 * @author Osadchyi Serhii
 */
namespace App\Http\Controllers\Models;

/**
 * Model for orders
 *
 * @author RDSergij
 */
use DB;
class Orders extends \Illuminate\Database\Eloquent\Model {
	protected $table = 'orders';

	/**
	 * Multiple save
	 * 
	 * @param array $orders
	 */
	public function multiSave( $orders ) {
		DB::table( $this->table )->insert( $orders );
	}
}
