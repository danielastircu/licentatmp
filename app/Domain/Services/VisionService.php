<?php


namespace App\Domain\Services;



class VisionService {

	public $googleConnection;

	public function __construct( GoogleConnection $googleConnection ) {

		$this->googleConnection = $googleConnection;
	}

	public function createPicture( $data, $file ) {

		$original = 'original_' . $data['id'] . ".jpg";
		$file->move( public_path() . '/assets/uploads/', $original );

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
		$src_image = imagecreatefromjpeg( public_path() . '/assets/uploads/' . $original );

		$src_image = imagerotate( $src_image, - $data['rotate'], 0 );
		// Cropping
		imagecopyresampled( $dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h );
		// Saving
		imagejpeg( $dst_image, public_path() . '/assets/uploads/final_' . $data['id'] . ".jpg" );
	}

	public function getImageData( $id ) {
		return $this->googleConnection->getImageData( public_path( 'assets/uploads/final_' . $id . '.jpg' ) );
	}

	public function getFullText($obj)
	{
		return $obj->fullText()->info()['text'];
	}

	/**
	 * @param $obj
	 *
	 * @return array -> all words from the picture
	 */
	public function getWords($obj)
	{
		$data = [];
		foreach ($obj->info()['textAnnotations'] as $key => $row) {
			if ($key == 0) {
				continue;
			}
			var_dump($row['description']);
			var_dump($row['boundingPoly']['vertices']);
			$data[] = $row['description'];
		}

		return $data;
	}

	/**
	 * @param $obj
	 *
	 * @return array -> $data[block_number][paragraph_number] -> string
	 */
	public function getBlocks($obj)
	{
		$blocks   = $obj->info()['fullTextAnnotation']['pages'][0]['blocks'];
		$newBlock = [];
		foreach ($blocks as $blockKey => $block) {
			$paragraphs   = $block['paragraphs'];
			$newParagraph = [];
			foreach ($paragraphs as $paragraphKey => $paragraph) {
				$words  = $paragraph['words'];
				$string = "";
				foreach ($words as $workKey => $word) {
					$symbols = $word['symbols'];
					foreach ($symbols as $keySymbol => $symbol) {
						$string .= $symbol['text'];
					}
					$string .= ' ';
				}
				$newParagraph[] = $string;
			}
			$newBlock[] = $newParagraph;
		}

		return $newBlock;
	}

	/**
	 * @param $obj
	 *
	 * @return array -> $data[block_number][paragraph_number] -> string
	 */
	public function getBlocksAsWords($obj)
	{
		$blocks   = $obj->info()['fullTextAnnotation']['pages'][0]['blocks'];
		$newBlock = [];
		foreach ($blocks as $blockKey => $block) {
			$newParagraph = [];

			$paragraphs = $block['paragraphs'];
			foreach ($paragraphs as $paragraphKey => $paragraph) {
				$wordsArray = [];


				$words = $paragraph['words'];
				foreach ($words as $workKey => $word) {
					$data   = [];
					$string = "";

					$symbols = $word['symbols'];

					list($data['coordinateY'],  $data['coordinateX']) = $this->setInitialCoordinates($data, $symbols);

					foreach ($symbols as $keySymbol => $symbol) {
						$string .= $symbol['text'];
						list($data['coordinateY'],  $data['coordinateX']) = $this->calculateMaximumCoordinatesOfWord($data, $symbol);
					}


					$data['word']  = $string;
					$data['start'] = $symbols[0]['boundingBox']['vertices'];
					$data['end']   = $symbols[count($symbols) - 1]['boundingBox']['vertices'];


					$wordsArray[] = $data;
				}

				$newParagraph[] = $wordsArray;
			}

			$newBlock[] = $newParagraph;
		}

		return $newBlock;
	}

	/**
	 * @param $obj
	 *
	 * @return array -> $data[block_number][paragraph_number] -> string
	 */
	public function getBlocksWithAxes($obj)
	{
		$blocks   = $obj->info()['fullTextAnnotation']['pages'][0]['blocks'];
		$newBlock = [];
		foreach ($blocks as $blockKey => $block) {
			$paragraphs   = $block['paragraphs'];
			$newParagraph = [];
			foreach ($paragraphs as $paragraphKey => $paragraph) {
				$words  = $paragraph['words'];
				$string = "";
				foreach ($words as $workKey => $word) {
					$symbols = $word['symbols'];
					foreach ($symbols as $keySymbol => $symbol) {
						$string .= $symbol['text'];
					}
					$string .= ' ';
				}
				$newParagraph[] = $string;
			}
			$newBlock[] = $newParagraph;
		}

		return $newBlock;
	}

	/**
	 * @param $obj
	 *
	 * @return array
	 */
	public function getWordAndLanguage($obj)
	{
		$blocks = $obj->info()['fullTextAnnotation']['pages'][0]['blocks'];
		$data   = [];
		foreach ($blocks as $blockKey => $block) {
			$paragraphs = $block['paragraphs'];
			foreach ($paragraphs as $paragraphKey => $paragraph) {
				$words = $paragraph['words'];
				foreach ($words as $workKey => $word) {
					$string  = "";
					$newWord = [];
					$symbols = $word['symbols'];
					foreach ($symbols as $keySymbol => $symbol) {
						$string .= $symbol['text'];
					}
					$newWord['word']     = $string;
					$newWord['language'] = $word['property']['detectedLanguages'];

					$data[] = $newWord;
				}
			}
		}

		return $data;
	}

	public function getBlocksLanguage($obj)
	{
		$blocks   = $obj->info()['fullTextAnnotation']['pages'][0]['blocks'];
		$newBlock = [];
		foreach ($blocks as $blockKey => $block) {
			$paragraphs   = $block['paragraphs'];
			$newParagraph = [];
			foreach ($paragraphs as $paragraphKey => $paragraph) {
				$words   = $paragraph['words'];
				$string  = "";
				$newData = [];
				foreach ($words as $workKey => $word) {
					$symbols = $word['symbols'];
					foreach ($symbols as $keySymbol => $symbol) {
						$string .= $symbol['text'];
					}
					$string .= ' ';
				}
				$newData['language']  = $paragraph['property']['detectedLanguages'];
				$newData['paragraph'] = $string;
				$newParagraph[]       = $newData;
			}
			$newBlock[] = $newParagraph;
		}

		return $newBlock;
	}

	public function setInitialCoordinates($data, $symbols)
	{

		//        Y coordinates
		if($symbols[0]['boundingBox']['vertices'][0]['y'] > $symbols[0]['boundingBox']['vertices'][1]['y']){
			$data['coordinateY']['minY'] = $symbols[0]['boundingBox']['vertices'][1]['y'];
		} else{
			$data['coordinateY']['minY'] = $symbols[0]['boundingBox']['vertices'][0]['y'];
		}

		if($symbols[0]['boundingBox']['vertices'][2]['y'] > $symbols[0]['boundingBox']['vertices'][3]['y']){
			$data['coordinateY']['maxY'] = $symbols[0]['boundingBox']['vertices'][2]['y'];
		} else{
			$data['coordinateY']['maxY'] = $symbols[0]['boundingBox']['vertices'][3]['y'];
		}

		//        X coordinates
		if($symbols[0]['boundingBox']['vertices'][0]['x'] > $symbols[0]['boundingBox']['vertices'][3]['x']){
			$data['coordinateX']['minX'] = $symbols[0]['boundingBox']['vertices'][3]['x'];
		} else{
			$data['coordinateX']['minX'] = $symbols[0]['boundingBox']['vertices'][0]['x'];
		}

		if($symbols[0]['boundingBox']['vertices'][1]['x'] > $symbols[0]['boundingBox']['vertices'][2]['x']){
			$data['coordinateX']['maxX'] = $symbols[0]['boundingBox']['vertices'][1]['x'];
		} else{
			$data['coordinateX']['maxX'] = $symbols[0]['boundingBox']['vertices'][2]['x'];
		}


		return array($data['coordinateY'],  $data['coordinateX']);
	}

	public function calculateMaximumCoordinatesOfWord($data, $symbol)
	{

		//        Y coordinates min
		if($data['coordinateY']['minY'] > $symbol['boundingBox']['vertices'][0]['y']){
			$data['coordinateY']['minY'] = $symbol['boundingBox']['vertices'][0]['y'];
		}
		if($data['coordinateY']['minY'] > $symbol['boundingBox']['vertices'][1]['y']){
			$data['coordinateY']['minY'] = $symbol['boundingBox']['vertices'][1]['y'];
		}

		//        Y coordinates max
		if($data['coordinateY']['maxY'] < $symbol['boundingBox']['vertices'][2]['y']){
			$data['coordinateY']['maxY'] = $symbol['boundingBox']['vertices'][2]['y'];
		}
		if($data['coordinateY']['maxY'] < $symbol['boundingBox']['vertices'][3]['y']){
			$data['coordinateY']['maxY'] = $symbol['boundingBox']['vertices'][3]['y'];
		}


		//        X coordinates min
		if($data['coordinateX']['minX'] > $symbol['boundingBox']['vertices'][0]['x']){
			$data['coordinateX']['minX'] = $symbol['boundingBox']['vertices'][0]['x'];
		}
		if($data['coordinateX']['minX'] > $symbol['boundingBox']['vertices'][3]['x']){
			$data['coordinateX']['minX'] = $symbol['boundingBox']['vertices'][3]['x'];
		}

		//        X coordinates max
		if($data['coordinateX']['maxX'] < $symbol['boundingBox']['vertices'][1]['x']){
			$data['coordinateX']['maxX'] = $symbol['boundingBox']['vertices'][1]['x'];
		}
		if($data['coordinateX']['maxX'] < $symbol['boundingBox']['vertices'][2]['x']){
			$data['coordinateX']['maxX'] = $symbol['boundingBox']['vertices'][2]['x'];
		}


		return array($data['coordinateY'],  $data['coordinateX']);


	}
}