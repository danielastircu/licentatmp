<?php

namespace App\Domain\Services;


use App\Domain\Repositories\LanguageRepository;

class LanguageService {

	public $languageRepository;

	public function __construct( LanguageRepository $languageRepository ) {

		$this->languageRepository = $languageRepository;
	}

	public function getLanguage() {
		return $this->languageRepository->findAll()->toArray();
	}
}