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
// Hacker: GIJ=CHECKMATE (AKA GIJOE)                                         //
// Site: http://www.peak.ne.jp/xoops/                                        //
// ------------------------------------------------------------------------- //

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

require_once( XOOPS_ROOT_PATH.'/class/template.php' ) ;

// $myts
$myts =& MyTextSanitizer::getInstance() ;

extract( $result_array ) ;

// header part
header( 'Content-Type:text/html; charset='._CHARSET ) ;
$tpl = new XoopsTpl();
$tpl->xoops_setTemplateDir(XOOPS_ROOT_PATH.'/themes');
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(0);

$tpl->assign('charset', _CHARSET);
$tpl->assign('sitename', $xoopsConfig['sitename']);
$tpl->assign('site_url', XOOPS_URL);
$tpl->assign('content_url', XOOPS_URL."/modules/$mydirname/index.php?id=$storyid");
$tpl->assign('lang_comesfrom', sprintf(_TC_THISCOMESFROM, $xoopsConfig['sitename']));
$tpl->assign('lang_contentfrom', _TC_URLFORSTORY);

$myts =& MyTextSanitizer::getInstance() ;
$tpl->assign( 'title' , $myts->makeTboxData4Show( $title ) ) ;
$tpl->assign( 'tinyd_title' , $myts->makeTboxData4Show( $title ) ) ;

$tpl->assign( 'modulename' , $xoopsModule->getVar('name') ) ;

// getting "content"
if( $link > 0 ) {

	// external (=wrapped) content
	$wrap_file = "$mymodpath/content/$address" ;
	if( ! file_exists( $wrap_file ) ) {
		redirect_header( XOOPS_URL.'/' , 2 , _TC_FILENOTFOUND ) ;
		exit ;
	}

	ob_start() ;
	include( $wrap_file ) ;
	$content = tc_convert_wrap_to_ie( ob_get_contents() ) ;
	if( $link == TC_WRAPTYPE_CHANGESRCHREF ) $content = tc_change_srchref( $content , XOOPS_URL . "/modules/$mydirname/content" ) ;
	ob_end_clean() ;

} else {

	$content = tc_content_render( $text , $nohtml , $nosmiley , $nobreaks ,  $xoopsModuleConfig['tc_space2nbsp'] ) ;

}

// convert from {X_SITEURL} to XOOPS_URL
$content = str_replace( '{X_SITEURL}' , XOOPS_URL , $content ) ;

$tpl->assign( 'content' , $content ) ;

$main_template = empty( $tinyd_singlecontent ) ? "db:tinycontent{$mydirnumber}_print.tpl" : "db:tinycontent{$mydirnumber}_index.tpl" ;

$tpl->display( $main_template ) ;

?>