<?php

namespace App\Domain\Repositories;


class LanguageRepository extends BaseRepository {

	public function __construct() {

		return parent::__construct( 'Language' );
	}
}