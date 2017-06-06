<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   TinyPNG V2
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2017 numero2 - Agentur für Internetdienstleistungen
 */


/**
 * Namespace
 */
namespace numero2\TinyPNG;


class TinyPNG {


	/**
	 * Processes all PNG images just uploaded
	 */
	public function processImages( $arrImages = NULL ) {

		if( empty($arrImages) )
			return false;

		foreach( $arrImages as $image ) {

			$file = new \File($image);

			if( in_array($file->extension,array('png','jpg','jpeg')) !== FALSE) {
                $this->processImage( $image );
            }
		}
	}


	/**
	* Process given PNG image using TinyPNG API
	*/
	public function processImage( $image = NULL ) {

		if( !$image ) {
            return false;
        }

		$apiKey = NULL;
		$apiKey = $GLOBALS['TL_CONFIG']['tinypng_api_key'];

		if( empty($apiKey) ) {
            \Message::addInfo($GLOBALS['TL_LANG']['MSC']['tinypng_missing_key']);
			return false;
		}

		ini_set("max_execution_time",0);

		$file = new \File($image,true);
		$req = new \Request();

		$req->setHeader( "Content-type", $file->mime );
		$req->setHeader( "Authorization", "Basic " . base64_encode("api:$apiKey") );

		$req->send(
			"https://api.tinify.com/shrink"
        ,   fread( $file->handle,$file->size )
        ,   "POST"
		);

		// check if we got a positive response
		if( $req->code >= 200 && $req->code <= 299 ) {

            $aResponse = NULL;
            $aResponse = json_decode($req->response);

            // has the image been compressed?
            if( $aResponse !== NULL && $aResponse->output->ratio > 0 ) {

                $compressedImage = NULL;
                $compressedImage = file_get_contents($aResponse->output->url);

                if( $compressedImage ) {

                    $fileSaved = false;
                    $fileSaved = file_put_contents(
    					TL_ROOT.'/'.$image
                    ,   $compressedImage
    				);

                    if( $fileSaved ) {

                        \Message::addConfirmation(sprintf(
                            $GLOBALS['TL_LANG']['MSC']['tinypng_compress_good']
                        ,   $file->filename
                        ,   ($file->size/1024)
                        ,   ($aResponse->output->size/1024)
                        ));

                        return;
                    }
                }

            } else {

                \Message::addInfo(sprintf(
					$GLOBALS['TL_LANG']['MSC']['tinypng_compress_bad']
                ,   $file->filename
				));

                return;
            }
		}

        \Message::addError(sprintf(
            $GLOBALS['TL_LANG']['ERR']['tinypng']
        ,   $file->filename
        ));
	}
}