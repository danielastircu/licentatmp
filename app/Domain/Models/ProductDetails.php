<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;


class ProductDetail extends Model {

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [ 'id' ];


	public $timestamps = false;


	protected $table = 'product_details';
}
