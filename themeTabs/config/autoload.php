<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package ThemeTabs
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Contao\ThemeTabs' => 'system/modules/themeTabs/classes/ThemeTabs.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_themetabs' => 'system/modules/themeTabs/templates',
));
