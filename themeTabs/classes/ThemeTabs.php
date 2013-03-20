<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jrgregory
 * Date: 20.03.13
 * Time: 14:56
 * To change this template use File | Settings | File Templates.
 */

namespace Contao;


class ThemeTabs extends \Backend {
    static public function generateTabs($scope)
    {
        $GLOBALS['TL_CSS'][] = 'system/modules/themeTabs/assets/style.css';

        $themeId = \Input::get('id');
        $table = \Input::get('table');
        $rt = \Contao\RequestToken::get();

        $arrTypes = array('tl_style_sheet' => 'style_sheet', 'modules' => 'module', 'design' => 'layout');

        $dataArr = array();



        foreach($arrTypes as $k => $v)
        {
            $dataArr[] = array
            (
                'label' => $GLOBALS['TL_LANG']['MOD'][$k],
                'href' => 'contao/main.php?do=themes&table=tl_'.$v.'&id='.$themeId.'&rt='.$rt,
                'active' => ('tl_'.$v == $table) ? true: false
            );
        }



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
        ')->execute($themeId,$themeId,$themeId);

        $selectfields = array();
        while($themePartDataObj->next())
        {
            $selectfields[$themePartDataObj->tablename][] = array
            (
                'id' => $themePartDataObj->id,
                'name' => $themePartDataObj->name
            );
        }

        $tpl = new BackendTemplate('be_themetabs');

        $tpl->items = $dataArr;
        $tpl->themePartData = $selectfields;
        $tpl->rt = $rt;
        $tpl->typeMap = $arrTypes;


        \Message::addRaw($tpl->parse());
    }
}