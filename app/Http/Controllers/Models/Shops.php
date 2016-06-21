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
class Shops extends \Illuminate\Database\Eloquent\Model {
	protected $table = 'shops';
	
	/**
	 * Get shop list for parse
	 */
	public function getList() {
		return $this->where( 'is_active', '=', '0' )->get();
	}
}
