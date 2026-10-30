<?php

//  ------------------------------------------------------------------------ //

//                XOOPS - PHP Content Management System                      //

//                    Copyright (c) 2000 XOOPS.org                           //

//                       <http://www.xoops.org/>                             //

//  ------------------------------------------------------------------------ //

//  This program is free software; you can redistribute it and/or modify     //

//  it under the terms of the GNU General Public License as published by     //

//  the Free Software Foundation; either version 2 of the License, or        //

//  (at your option) any later version.                                      //

//                                                                           //

//  You may not change or alter any portion of this comment or credits       //

//  of supporting developers from this source code or any supporting         //

//  source code which is considered copyrighted (c) material of the          //

//  original comment or credit authors.                                      //

//                                                                           //

//  This program is distributed in the hope that it will be useful,          //

//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //

//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //

//  GNU General Public License for more details.                             //

//                                                                           //

//  You should have received a copy of the GNU General Public License        //

//  along with this program; if not, write to the Free Software              //

//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //

// ------------------------------------------------------------------------- //

// Author: Tobias Liegl (AKA CHAPI)                                          //

// Site: http://www.chapi.de                                                 //

// Project: The XOOPS Project                                                //

// ------------------------------------------------------------------------- //

if (!defined('XOOPS_ROOT_PATH')) {
    exit;
}
global $xoopsDB;
$mydirname = basename(dirname(__FILE__));

if (!preg_match('/^(\D+)(\d*)$/', $mydirname, $regs)) {
    echo("invalid dirname: " . htmlspecialchars($mydirname));
}

$mydirnumber = $regs[2] === '' ? '' : intval($regs[2]);

include_once XOOPS_ROOT_PATH . "/modules/$mydirname/include/constants.inc.php";

$modversion['name'] = _MI_TINYCONTENT_NAME . $mydirnumber;

$modversion['version']   = isset($_SESSION['xoops_version']) && $_SESSION['xoops_version'] >= 20511 ? '4.0.0-Stable' : '4.0';
$modversion['min_php']   = '8.3.0';
$modversion['min_xoops'] = '2.5.11';

$modversion['author'] = 'Tobias Liegl (AKA CHAPI)';

$modversion['description'] = _MI_TINYCONTENT_DESC;

$modversion['credits'] = "The XOOPS Project";

$modversion['license'] = "GPL see LICENSE";

$modversion['help'] = "";

$modversion['official'] = 0;

$modversion['image'] = "images/tinycontent{$mydirnumber}.png";

$modversion['dirname'] = $mydirname;

//$modversion['dirname']        = _MI_DIR_NAME;

// All tables should not have any prefix!

$modversion['sqlfile']['mysql'] = "sql/tinycontent{$mydirnumber}.sql";

// Tables created by sql file (without prefix!)

//$modversion['tables'][0]    = _MI_DIR_NAME;

$modversion['tables'][0] = "tinycontent{$mydirnumber}";

// Admin things

$modversion['dirmoduleadmin'] = '/Frameworks/moduleclasses/moduleadmin';

$modversion['icons16'] = '../../Frameworks/moduleclasses/icons/16';

$modversion['icons32'] = '../../Frameworks/moduleclasses/icons/32';

$modversion['system_menu'] = 1;

$modversion['hasAdmin'] = 1;

$modversion['adminindex'] = "admin/index.php";

$modversion['adminmenu'] = "admin/menu.php";

// Search

$modversion['hasSearch'] = 1;

$modversion['search']['file'] = "include/search.inc.php";

$modversion['search']['func'] = "tinycontent{$mydirnumber}_search";

// Menu

$modversion['hasMain'] = 1;

// get my config

$module_handler = &xoops_gethandler('module');

$module = &$module_handler->getByDirname($mydirname);

if (is_object($module)) {

    $config_handler = &xoops_gethandler('config');

    $config = &$config_handler->getConfigsByCat(0, $module->getVar('mid'));

    $myts = \MyTextSanitizer::getInstance();

    // $db = Database::getInstance();

    // Submenu Items

    $result = $xoopsDB->query("SELECT storyid,title,link FROM " . $xoopsDB->prefix("tinycontent{$mydirnumber}") . " WHERE submenu='1' AND visible ORDER BY blockid");

    $i = 1;

    while (list($storyid, $title, $link) = $xoopsDB->fetchRow($result)) {

        $modversion['sub'][$i]['name'] = $myts->makeTboxData4Show($title);

        if (!empty($config['tc_force_mod_rewrite']) || $link == TC_WRAPTYPE_USEREWRITE) {

            if (empty($config['tc_modulesless_dir'])) {

                $wraproot = TC_REWRITE_DIR;

                $modversion['sub'][$i]['url'] = TC_REWRITE_DIR . sprintf(TC_REWRITE_FILENAME_FMT, $storyid);

            } else {

                $wraproot = '';

                $modversion['sub'][$i]['url'] = '../../' . $config['tc_modulesless_dir'] . '/' . sprintf(TC_REWRITE_FILENAME_FMT, $storyid);

            }

        } else {

            $wraproot = $link == TC_WRAPTYPE_CONTENTBASE ? "content/" : '';

            $modversion['sub'][$i]['url'] = "{$wraproot}index.php?id=$storyid";

        }

        $i++;

    }

}

// Templates

$modversion['templates'][1]['file'] = "tinycontent{$mydirnumber}_index.tpl";

$modversion['templates'][1]['description'] = "Layout for Monitor";

$modversion['templates'][2]['file'] = "tinycontent{$mydirnumber}_print.tpl";

$modversion['templates'][2]['description'] = "Layout for Printer";

// Blocks

$modversion['blocks'][1]['file'] = "tinycontent_navigation.php";

$modversion['blocks'][1]['name'] = sprintf(_MI_TC_BNAME1, $mydirnumber);

$modversion['blocks'][1]['description'] = _MI_TC_BDESC1;

$modversion['blocks'][1]['show_func'] = "tinycontent{$mydirnumber}_block_nav";

$modversion['blocks'][1]['template'] = "tinycontent{$mydirnumber}_nav_block.tpl";

$modversion['blocks'][1]['can_clone'] = false;

$modversion['blocks'][1]['options'] = "{$mydirname}";

$modversion['blocks'][2]['file'] = "tinycontent_content.php";

$modversion['blocks'][2]['name'] = sprintf(_MI_TC_BNAME2, $mydirnumber);

$modversion['blocks'][2]['description'] = _MI_TC_BDESC2;

$modversion['blocks'][2]['show_func'] = "b_tinycontent_content_show";

$modversion['blocks'][2]['edit_func'] = "b_tinycontent_content_edit";

$modversion['blocks'][2]['template'] = "";

$modversion['blocks'][2]['can_clone'] = true;

$modversion['blocks'][2]['options'] = "{$mydirname}|1";

// Configs

$modversion['config'][1] = [

    'name'        => 'tc_common_htmlheader',

    'title'       => '_MI_COMMON_HTMLHEADER',

    'description' => '_MI_COMMON_HTMLHEADER_DESC',

    'formtype'    => 'textarea',

    'valuetype'   => 'text',

    'default'     => '',

];

$modversion['config'][] = [

    'name'        => 'tc_tarea_width',

    'title'       => '_MI_TAREA_WIDTH',

    'description' => '_MI_TAREA_WIDTH_DESC',

    'formtype'    => 'text',

    'valuetype'   => 'int',

    'default'     => 35,

];

$modversion['config'][] = [

    'name'        => 'tc_header_tarea_height',

    'title'       => '_MI_HEADER_TAREA_HEIGHT',

    'description' => '_MI_HEADER_TAREA_HEIGHT_DESC',

    'formtype'    => 'text',

    'valuetype'   => 'int',

    'default'     => 3,

];

$modversion['config'][] = [

    'name'        => 'tc_tarea_height',

    'title'       => '_MI_TAREA_HEIGHT',

    'description' => '_MI_TAREA_HEIGHT_DESC',

    'formtype'    => 'text',

    'valuetype'   => 'int',

    'default'     => 37,

];

$modversion['config'][] = [

    'name'        => 'tc_force_mod_rewrite',

    'title'       => '_MI_FORCE_MOD_REWRITE',

    'description' => '_MI_FORCE_MOD_REWRITE_DESC',

    'formtype'    => 'yesno',

    'valuetype'   => 'int',

    'default'     => 0,

];

$modversion['config'][] = [

    'name'        => 'tc_modulesless_dir',

    'title'       => '_MI_MODULESLESS_DIR',

    'description' => '_MI_MODULESLESS_DIR_DESC',

    'formtype'    => 'text',

    'valuetype'   => 'text',

    'default'     => '',

];

$modversion['config'][] = [

    'name'        => 'tc_space2nbsp',

    'title'       => '_MI_SPACE2NBSP',

    'description' => '',

    'formtype'    => 'yesno',

    'valuetype'   => 'int',

    'default'     => 0,

];

$modversion['config'][] = [

    'name'        => 'tc_display_print_icon',

    'title'       => '_MI_DISPLAY_PRINT_ICON',

    'description' => '',

    'formtype'    => 'yesno',

    'valuetype'   => 'int',

    'default'     => 1,

];

$modversion['config'][] = [

    'name'        => 'tc_display_friend_icon',

    'title'       => '_MI_DISPLAY_FRIEND_ICON',

    'description' => '',

    'formtype'    => 'yesno',

    'valuetype'   => 'int',

    'default'     => 1,

];

$modversion['config'][] = [

    'name'        => 'tc_use_taf_module',

    'title'       => '_MI_USE_TAF_MODULE',

    'description' => '',

    'formtype'    => 'yesno',

    'valuetype'   => 'int',

    'default'     => 0,

];

$modversion['config'][] = [

    'name'        => 'tc_display_pagenav',

    'title'       => '_MI_DISPLAY_PAGENAV',

    'description' => '',

    'formtype'    => 'select',

    'valuetype'   => 'int',

    'default'     => 0,

    'options'     => [

        '_MI_DISPLAY_PAGENAV_NONE'   => 0,

        '_MI_DISPLAY_PAGENAV_DISP'   => 1,

        '_MI_DISPLAY_PAGENAV_SUB'    => 2,

        '_MI_DISPLAY_PAGENAV_PERSUB' => 3],

];

$modversion['config'][] = [

    'name'        => 'tc_navblock_target',

    'title'       => '_MI_NAVBLOCK_TARGET',

    'description' => '',

    'formtype'    => 'select',

    'valuetype'   => 'int',

    'default'     => 1,

    'options'     => [

        '_MI_NAVBLOCK_TARGET_DISP' => 1,

        '_MI_NAVBLOCK_TARGET_SUB'  => 2],

];

// Notification

$modversion['hasNotification'] = 0;

// onUpdate

if (!empty($_POST['fct']) && !empty($_POST['op']) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname']) {

    include dirname(__FILE__) . "/include/onupdate.inc.php";

}
