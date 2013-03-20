<?php


if(\Input::get('do') == 'themes' && (\Input::get('table') === 'tl_layout' && !\Input::get('act')))
{
    ThemeTabs::generateTabs($this);
}