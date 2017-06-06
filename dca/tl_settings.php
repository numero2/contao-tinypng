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
 * Add palettes to tl_settings
 */
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace(
	',imageHeight',
	',imageHeight,tinypng_api_key',
	$GLOBALS['TL_DCA']['tl_settings']['palettes']['default']
);


/**
 * Add fields to tl_settings
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['tinypng_api_key'] = array(
	'label'        => &$GLOBALS['TL_LANG']['tl_settings']['tinypng_api_key'],
	'exclude'      => true,
	'inputType'    => 'text',
	'eval'         => array('tl_class'=>'w50')
);