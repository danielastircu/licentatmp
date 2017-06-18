<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 6/16/2017
 * Time: 2:54 PM
 */

namespace App\Domain\Repositories;


interface  RepositoryInterface {
	public function create( $data );

	public function update( $data );

	public function delete( $id );

	public function find( $id );

	public function findAll();
}