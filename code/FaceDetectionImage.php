<?php

// TODO: Could also use https://github.com/infusion/PHP-Facedetect

class FaceDetectionImage extends DataExtension {

	public static $BoxColor = '#FF0000';
	public static $BoxBorderColor = '#FFFFFF';

	// Returns an image after adding in image detection
	public function generateFaceDetection($gd) {
		// Nothing set - run face detection
		$detectionDataFile = dirname(dirname(__FILE__)).'/thirdparty/php-facedetection/detection.dat';
		$detector = new Face_Detector($detectionDataFile);
		// Don't run on the full size image if it's larger than 500px x 500px - takes too long!
		if ( $this->owner->Width > 500 || $this->owner->Height > 500 ) {
			return $gd;
		}
		$detector->face_detect( BASE_PATH . '/' . $this->owner->Filename );
		$face = $detector->getFace();

		// No change?
		if ( !$face ) {
			return $gd;
		}

		$newGD = imagecreatetruecolor($gd->getWidth(), $gd->getHeight());
		imagealphablending($newGD, false);
		imagesavealpha($newGD, true);

		imagecopyresampled($newGD, $gd->getGD(), 0, 0, 0, 0, $gd->getWidth(), $gd->getHeight(), $gd->getWidth(), $gd->getHeight());

		// Draw face box (2ps)
		imagerectangle(
			$newGD,
			$face['x'] + 1,
			$face['y'] + 1,
			$face['x'] + $face['w'] - 1,
			$face['y']+ $face['w'] - 1,
			GD::color_web2gd($newGD, self::$BoxColor)
		);
		imagerectangle(
			$newGD,
			$face['x'],
			$face['y'],
			$face['x'] + $face['w'],
			$face['y'] + $face['w'],
			GD::color_web2gd($newGD, self::$BoxColor)
		);
		// Draw face box border
		imagerectangle(
			$newGD,
			$face['x'] - 1,
			$face['y'] - 1,
			$face['x'] + $face['w'] + 1,
			$face['y'] + $face['w'] + 1,
			GD::color_web2gd($newGD, self::$BoxBorderColor)
		);


		// Create a new GD
		$output = clone $gd;
		$output->setGD($newGD);
		return $output;
	}
	public function FaceDetection() {
		return $this->owner->getFormattedImage('FaceDetection');
	}

}