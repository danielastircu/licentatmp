<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository implements RepositoryInterface {

	protected $model;

	public function __construct( $modelName ) {
		/**
		 * We use this predefined namespace (which corresponds with the path) for each
		 * Model object injected in the repository. Each concrete repository will have
		 * to call the parent constructor inside its own constructor
		 */
		$className = 'App\\Domain\\Models\\' . $modelName;

		if ( class_exists( $className ) ) {
			$this->model = new $className;
		} else {
			throw new \Illuminate\Database\Eloquent\ModelNotFoundException( "Model not found!" );
		}
	}

	/**
	 * Get the model of the repository
	 *
	 * @return Model
	 */
	public function getModel() {
		return $this->model;
	}

	/**
	 * Create a new entry in the model's table and return the instance.
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function create( $data ) {
		return $this->model->create( $data );
	}

	/**
	 * Updates an entry in the model's table
	 *
	 * @param array $data
	 *
	 * @return bool | int
	 */
	public function update( $data ) {
		return $this->model->update( $data );
	}

	/**
	 * Updates an entry in the model's table
	 *
	 * @param       $model
	 * @param array $data
	 *
	 * @return bool | Model
	 */
	public function updateModel( $model, $data ) {
		$model->update( $data );

		return $model;
	}

	/**
	 * @param $data
	 *
	 * @return bool|mixed
	 */
	public function save( $data ) {
		$primaryKey = $this->model->getKeyName();
		if ( isset( $data[ $primaryKey ] ) && $data[ $primaryKey ] != "" ) {
			$response = $this->model->find( $data[ $primaryKey ] )->fill( $data )->save();

			return $response ? $data[ $primaryKey ] : false;
		} else {
			$response = $this->create( $data );

			return $response ? $response->id : false;
		}
	}


	/**
	 * Deletes an entry
	 *
	 * @param Integer $id
	 *
	 * @return bool
	 */
	public function delete( $id ) {
		$instance = $this->model->find( $id );
		if ( $instance ) {
			return $instance->delete();
		}

		return false;
	}

	/**
	 * Get an entry by its id
	 *
	 * @param Integer $id
	 *
	 * @return model instance | bool
	 */
	public function find( $id ) {
		$model = $this->model->find( $id );

		return $model;
	}

	/**
	 * Find all entries of this model
	 *
	 * @return mixed
	 */
	public function findAll() {
		return $this->model->all();
	}

	/**
	 * Find first entries by a column
	 *
	 * @param $column
	 * @param $value
	 *
	 * @return mixed
	 */
	public function findBy( $column, $value ) {
		return $this->model->where( $column, "=", $value )->first();
	}

	/**
	 * Find all results by a specific field
	 *
	 * @param string $column
	 * @param string $value
	 *
	 * @return mixed
	 */
	public function findAllByField( $column, $value ) {
		return $this->model->where( $column, "=", $value )->get();
	}

	/**
	 * Find all results by a custom field and condition
	 *
	 * @param string $column
	 * @param string $value
	 * @param string $condition
	 */
	public function findAllBy( $column, $value, $condition = "=" ) {
		return $this->model->where( $column, $condition, $value )->get();
	}

	/**
	 * @param        $column
	 * @param        $value
	 * @param        $order
	 * @param string $direction
	 *
	 * @return mixed
	 */
	public function findAllByFieldOrdered( $column, $value, $order, $direction = 'desc' ) {
		return $this->model->where( $column, "=", $value )->orderBy( $order, $direction )->get();
	}

	/**
	 * @param        $order
	 * @param string $direction
	 *
	 * @return model instance
	 */
	public function findAllOrdered( $order, $direction = 'asc' ) {
		return $this->model->orderBy( $order, $direction )->get();
	}

	/**
	 * @param $fields
	 *
	 * @return mixed
	 */
	public function findAllByFields( $fields ) {
		return $this->model->where( $fields )->get();
	}

	/**
	 * @return int
	 */
	public function countAll() {
		return $this->model->count();
	}

	/**
	 * @return model instance
	 */
	public function newModelInstance() {
		return $this->model->newInstance();
	}

	public function getDataTableAction( $class, $title, $href, $icon, $target = null, $dataId = null ) {
		return '<a class="data-table-actions ' . $class . '" ' . $target . ' title="' . $title . '" href="' . $href . '" data-id="' . $dataId . '" ><i class="data-table-icon fa ' . $icon . '"></i></a>';
	}

	public function getCheckboxDesign( $class = "", $dataOther = "" ) {
		return ' <p data-order="' . $class . '"><span ' . $dataOther . ' class= "data-table icheckbox_square-grey ' . $class . ' "></span></p>';
	}


}