<?php


if(\Input::get('do') == 'themes' && (\Input::get('table') === 'tl_module' && !\Input::get('act')))
{
    ThemeTabs::generateTabs($this);
}