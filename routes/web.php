<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get( '/', function () {
//	return view( 'welcome' );
//} );

Route::get( '/', [
	'uses' => 'Controller@homepage'
] );

Route::get( 'get-products', [
	'uses' => 'Controller@ajaxGetProducts'
] );

Route::get( 'view-product', [
//	TODO
	'uses' => 'Controller@ajaxGetProducts'
] );

Route::post( 'add-product', [
	'uses' => 'Controller@ajaxAddProduct'
] );


Route::post( 'edit-product', [
	'uses' => 'Controller@ajaxEditProduct'
] );


Route::get( 'delete-product', [
	'uses' => 'Controller@ajaxDeleteProduct'
] );

Route::get( 'get-edit-product-modal', [
	'uses' => 'Controller@getEditProductModal'
] );

Route::post( 'get-image-data', [
	'uses' => 'Controller@getImageData'
] );


