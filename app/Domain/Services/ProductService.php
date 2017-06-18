<?php

namespace App\Domain\Services;


use App\Domain\Repositories\ProductRepository;

class ProductService {

	public $productRepository;

	public function __construct( ProductRepository $productRepository ) {

		$this->productRepository = $productRepository;
	}

	public function getProduct( $id ) {
		return $this->productRepository->find( $id )->toArray();
	}

	public function getProductDetailByLanguage( $idProduct, $language ) {

		$data = [ ];
		foreach ( $language as $key => $row ) {
			$data[ $key ] = $this->productRepository->getProductDetailByLanguage( $idProduct, $key );
		}

		return $data;
	}

	public function dtListProducts() {
		return $this->productRepository->dtListProducts();
	}

	public function saveProduct( $data ) {
		return $this->productRepository->save( $data );
	}

	public function deleteProduct( $id ) {
		return $this->productRepository->delete( $id );
	}

	public function editProduct( $data ) {

		$details = $data['detail'];
		unset( $data['detail'] );

		$result = $this->productRepository->save( $data );

		foreach ( $details as $key => $row ) {
			$row['idProduct'] = $data['id'];
			$row['codeLanguage']      = $key;
			$result           = $result && $this->productRepository->saveProductDetails( $row );
		}

		return $result;

	}
}