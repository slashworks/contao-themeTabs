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

namespace Contao;

/**
 * Class ThemeTabs
 *
 * Backend module "theme tabs".
 * @copyright  Joe Ray Gregory @slashworks KG 2013
 * @author     Joe Ray Gregory <http://slash-works.de>
 * @package    ThemeTabs
 */

class ThemeTabs extends \Backend {

    static private $themeId;
    static private $token;
    static private $table;

    /**
     * generate the tab template
     * @param $scope
     */
    static public function generateTabs($scope)
    {
        // Add css file
        $GLOBALS['TL_CSS'][] = 'system/modules/themeTabs/assets/style.css';

        //fill class local vars
        self::$themeId = \Input::get('id');
        self::$table = \Input::get('table');
        self::$token = \Contao\RequestToken::get();

        //generate a data map to balanceing the differences between table names and language files
        $arrTypes = array
        (
            'tl_style_sheet' => array
            (
                'table' => 'tl_style_sheet',
                'label' => &$GLOBALS['TL_LANG']['MOD']['tl_style_sheet']
            ),

            'tl_module' => array
            (
                'table' => 'tl_module',
                'label' => &$GLOBALS['TL_LANG']['MOD']['modules']
            ),

            'tl_layout' => array
            (
                'table' => 'tl_layout',
                'label' => &$GLOBALS['TL_LANG']['MOD']['design']
            )
        );

        // generate backend object
        $tpl = new BackendTemplate('be_themetabs');

        // add template vars
        $tpl->items = self::generateTabDataAsArray($arrTypes);
        $tpl->themePartData = self::getThemePartsAsArray();
        $tpl->rt = self::$token;
        $tpl->typeMap = $arrTypes;

        // set the template to the message position
        \Message::addRaw($tpl->parse());
    }

    /**
     * get the data of each theme part
     * @return array
     */
    static private function getThemePartsAsArray()
    {
        $themePartDataObj = \Database::getInstance()->prepare('
			(SELECT
                l.id,
                l.name,
                "tl_layout" as tablename
            FROM tl_layout l
            WHERE
            	pid=?
            )
            UNION
            (SELECT
                m.id,
                m.name,
                "tl_module" as tablename
            FROM tl_module m
            WHERE
            	pid=?
            )
            UNION
            (SELECT
                s.id,
                s.name,
                "tl_style_sheet" as tablename
            FROM tl_style_sheet s
            WHERE
            	pid=?
            )
            ORDER BY tablename,id
        ')->execute(self::$themeId,self::$themeId,self::$themeId);

        $selectfields = array();
        while($themePartDataObj->next())
        {
            $selectfields[$themePartDataObj->tablename][] = array
            (
                'id' => $themePartDataObj->id,
                'name' => $themePartDataObj->name
            );
        }

        return $selectfields;
    }

    /**
     * generate the the tab navigation data array
     * @param $arrTypes
     * @return array
     */
    static private function generateTabDataAsArray($arrTypes)
    {
        $dataArr = array();

        foreach($arrTypes as $k => $v)
        {
            $dataArr[] = array
            (
                'label' => $v['label'],
                'href' => 'contao/main.php?do=themes&table='.$v['table'].'&id='.self::$themeId.'&rt='.self::$token,
                'active' => ($v['table'] == self::$table) ? true: false
            );
        }

        return $dataArr;
    }

}