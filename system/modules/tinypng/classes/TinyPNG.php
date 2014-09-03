<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   TinyPNG
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2014 numero2 - Agentur für Internetdienstleistungen
 */

class TinyPNG {


	/**
	 * Processes all PNG images just uploaded
	 */
	public function processImages( $arrImages = NULL )
	{

		if( empty($arrImages) )
			return false;

		foreach( $arrImages as $image ) {

			$file = new \File($image);

			if( $file->extension == "png" )
				$this->processImage( $image );
		}
	}


	/**
	* Process given PNG image using TinyPNG API
	*/
	public function processImage( $image = NULL ) {

		if( !$image )
			return false;

		$apiKey = $GLOBALS['TL_CONFIG']['tinypng_api_key'];

		if( empty($apiKey) ) {

			$_SESSION['TL_INFO'][] = sprintf(
				$GLOBALS['TL_LANG']['MSC']['tinypng_missing_key'],
				$file->filename
			);

			return false;
		}

		ini_set("max_execution_time",0);

		$file = new \File($image);
		$request = new \Request();

		$request->setHeader( "Content-type", "image/png" );
		$request->setHeader( "Authorization", "Basic " . base64_encode("api:$apiKey") );

		$request->send(
			"https://api.tinypng.com/shrink",
			fread( $file->handle,$file->size ),
			"POST"
		);

		// check if we got a positive response
		if( !empty($request->headers['Location']) ) {

			$newImageData = file_get_contents($request->headers['Location']);

			// check if compressed image is smaller than original
			if( strlen($newImageData) < $file->size ) {

				file_put_contents(
					TL_ROOT.'/'.$image,
					$newImageData
				);

				$_SESSION['TL_CONFIRM'][] = sprintf(
					$GLOBALS['TL_LANG']['MSC']['tinypng_compress_good'],
					$file->filename,
					($file->size/1024),
					(strlen($newImageData)/1024)
				);

			} else {

				$_SESSION['TL_INFO'][] = sprintf(
					$GLOBALS['TL_LANG']['MSC']['tinypng_compress_bad'],
					$file->filename
				);
			}

		} else {

			$_SESSION['TL_ERROR'][] = sprintf(
				$GLOBALS['TL_LANG']['ERR']['tinypng'],
				$file->filename
			);
		}
	}
}