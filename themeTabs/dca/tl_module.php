<?php

/**
 * ThemeTabs for Contao Open Source CMS
 *
 * Copyright (C) 2013 Joe Ray Gregory
 *
 * @package ThemeTabs
 * @link    http://slash-works.de KG
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

if(\Input::get('do') == 'themes' && (\Input::get('table') === 'tl_module' && !\Input::get('act')))
{
    ThemeTabs::generateTabs($this);
}