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
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'numero2\TinyPNG',
));


/**
 * Register the classes
 */
ClassLoader::addClasses( array
(
    // Forms
    'numero2\TinyPNG\TinyPNG' => 'system/modules/tinypng/classes/TinyPNG.php',
));