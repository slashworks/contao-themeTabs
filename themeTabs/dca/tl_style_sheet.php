<?php


if(\Input::get('do') == 'themes' && (\Input::get('table') === 'tl_style_sheet' && !\Input::get('act')))
{
    ThemeTabs::generateTabs($this);
}