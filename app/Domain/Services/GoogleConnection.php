<?php

namespace App\Domain\Services;

//require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\Vision\VisionClient;
use Google\Auth\Cache\MemoryCacheItemPool;


class GoogleConnection {
	public function getImageData( $imagePath ) {

		$guzzleClient = new \GuzzleHttp\Client( [ 'curl' => [ CURLOPT_SSL_VERIFYPEER => false, ], ] );
		$handler      = function ( $request, array $options = [ ] ) use ( $guzzleClient ) {
			return $guzzleClient->send( $request, $options );
		};

		$config['projectId']       = 'xyxle-products';
		$config['keyFile']         = json_decode( file_get_contents( storage_path( 'xyxle-products-3669bd20bfc8.json' ) ), true );
		$config['httpHandler']     = $handler;
		$config['authHttpHandler'] = $handler;

		$vision              = new VisionClient( $config );
		$familyPhotoResource = fopen( $imagePath, 'r' );

		$image = $vision->image( $familyPhotoResource, [
			'DOCUMENT_TEXT_DETECTION'
		], [
			'imageContext' => [
				'languageHints' => [
					'de',
					'fr',
					'it'
				]
			]
		] );


		$result = $vision->annotate( $image );

		return $result;

	}
}