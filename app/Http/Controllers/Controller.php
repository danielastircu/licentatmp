<?php

namespace App\Http\Controllers;

use App\Domain\Services\LanguageService;
use App\Domain\Services\ProductService;
use App\Domain\Services\VisionService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Config;
use Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


	public $languageService;
	public $productService;
	public $visionService;

	public function __construct(
		LanguageService $languageService,
		ProductService $productService,
		VisionService $visionService
	) {
		$this->languageService = $languageService;
		$this->productService  = $productService;
		$this->visionService   = $visionService;
	}

	public function homepage() {
		return view( 'homepage' );
	}

	public function ajaxGetProducts() {
		return $this->productService->dtListProducts();
	}

	public function ajaxAddProduct() {
		$data = Request::all();

		return $this->productService->saveProduct( $data );
	}

	public function ajaxDeleteProduct() {
		$id = Request::get( 'id' );

		return $this->productService->deleteProduct( $id ) ? 1 : 0;
	}

	public function getEditProductModal() {
		$idProduct = Request::get( 'id' );

		$languages = Config::get( 'languages' );

		$data['product']        = $this->productService->getProduct( $idProduct );
		$data['productDetails'] = $this->productService->getProductDetailByLanguage( $idProduct, $languages );

		return view( 'editProductModal' )->with( 'data', $data )->render();
	}

	public function ajaxEditProduct() {
		$data = Request::all();

		return $this->productService->editProduct( $data ) ? 1 : 0;
	}

	public function getImageData() {

//		/
		$data = Request::all();
		$file = Request::file( 'file' );


		$this->visionService->createPicture( $data, $file );

		$this->visionService->getImageData( $data['id'] );

		var_dump( $data );
		die;
	}
}
