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


$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace(
	',imageHeight',
	',imageHeight,tinypng_api_key',
	$GLOBALS['TL_DCA']['tl_settings']['palettes']['default']
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['tinypng_api_key'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['tinypng_api_key'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('tl_class'=>'w50')
);