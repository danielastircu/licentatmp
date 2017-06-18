<?php


namespace App\Domain\Services;



class VisionService {

	public $googleConnection;

	public function __construct( GoogleConnection $googleConnection ) {

		$this->googleConnection = $googleConnection;
	}

	public function createPicture( $data, $file ) {

		$original = 'original_' . $data['id'] . ".jpg";
		$file->move( public_path() . '/assets/uploads', $original );

		$dst_x = 0;   // X-coordinate of destination point
		$dst_y = 0;   // Y-coordinate of destination point
		$src_x = floor( $data['coordinates']['x'] ); // Crop Start X position in original image
		$src_y = floor( $data['coordinates']['y'] ); // Crop Srart Y position in original image
		$dst_w = ceil( $data['coordinates']['w'] ); // Thumb width
		$dst_h = ceil( $data['coordinates']['h'] ); // Thumb height
		$src_w = ceil( $data['coordinates']['w'] ); // Crop end X position in original image
		$src_h = ceil( $data['coordinates']['h'] ); // Crop end Y position in original image


		$dst_image = imagecreatetruecolor( $dst_w, $dst_h );
		// Get original image
		$src_image = imagecreatefromjpeg( public_path() . 'assets/uploads/' . $original );

		$src_image = imagerotate( $src_image, - $data['rotate'], 0 );
		// Cropping
		imagecopyresampled( $dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h );
		// Saving
		imagejpeg( $dst_image, public_path() . '/assets/uploads/3final_' . $data['id'] . ".jpg" );
	}

	public function getImageData( $id ) {
		$this->googleConnection->getImageData( public_path( 'assets/uploads/final_' . $id . '.jpg' ) );
	}
}