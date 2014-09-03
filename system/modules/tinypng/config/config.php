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


$GLOBALS['TL_HOOKS']['postUpload'][] = array('TinyPNG', 'processImages');