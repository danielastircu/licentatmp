<?php

namespace App\Domain\Repositories;


use App\Domain\Models\ProductDetail;
use Datatable;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository {

	public function __construct() {

		return parent::__construct( 'Product' );
	}

	public function dtListProducts() {

//		$products = $this->productQuery();
		return Datatable::collection( $this->findAll() )
		                ->showColumns( [ 'id', 'name', 'id' ] )
		                ->addColumn( 'actions', function ( $item ) {
			                $result = "<p class='text-center'>";
			                $result .= $this->getDataTableAction( 'view', 'View', "#", 'glyphicon glyphicon-list-alt', "", $item->id );
			                $result .= $this->getDataTableAction( 'edit', 'Edit', "#", 'glyphicon glyphicon-edit', "", $item->id );
			                $result .= $this->getDataTableAction( 'delete', 'Delete', "#",
				                'glyphicon glyphicon-trash', "", $item->id );

			                return $result . "</p>";
		                } )
		                ->make();
	}

	public function getProductDetailByLanguage( $idProduct, $language ) {
		$detail = ProductDetail::where( 'idProduct', $idProduct )->where( 'codeLanguage', $language )->first();
		if ( $detail ) {
			return $detail->toArray();
		}

		return null;
	}

	public function saveProductDetails( $data ) {
		$productDetailModel = new ProductDetail();
		$primaryKey         = $productDetailModel->getKeyName();
		if ( isset( $data[ $primaryKey ] ) && $data[ $primaryKey ] != "" ) {
			$response = $productDetailModel->find( $data[ $primaryKey ] )->fill( $data )->save();

			return $response ? $data[ $primaryKey ] : false;
		} else {
			$response = $productDetailModel->create( $data );

			return $response ? $response->id : false;
		}
	}


}