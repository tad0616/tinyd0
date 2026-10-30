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
// Hacker: GIJ=CHECKMATE (AKA GIJOE)                                         //
// Site: http://www.peak.ne.jp/xoops/                                        //
// ------------------------------------------------------------------------- //

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

// XOOPS Header
$xoopsOption['template_main'] = "tinycontent{$mydirnumber}_index.tpl" ;
include( XOOPS_ROOT_PATH . '/header.php' ) ;

// $myts
$myts =& MyTextSanitizer::getInstance() ;

extract( $result_array ) ;

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

	$content = tc_content_render( $text , $nohtml , $nosmiley , $nobreaks , $xoopsModuleConfig['tc_space2nbsp'] ) ;

}

// "tell to a friend" (It is too difficult to treat this for multibyte langs...)
if( $xoopsModuleConfig['tc_use_taf_module'] ) {
	$mail_link = XOOPS_URL.'/modules/tellafriend/index.php?target_uri='.rawurlencode( XOOPS_URL . "/modules/$mydirname/index.php?id=$id" ).'&amp;subject='.rawurlencode(sprintf(_TC_INTARTICLE,$xoopsConfig['sitename'])) ;
} else {
	if( _TC_DONE_MAILTOENCODE ) {
		$mail_link = 'mailto:?subject=' . _TC_MB_INTARTICLE . '&amp;body=' . _TC_MB_INTARTFOUND . '%3A%20' . XOOPS_URL . "/modules/$mydirname/index.php?id=$id" ;
	} else {
		$mail_link = 'mailto:?subject='.rawurlencode(sprintf(_TC_INTARTICLE,$xoopsConfig['sitename'])).'&amp;body='.rawurlencode(sprintf(_TC_INTARTFOUND, $xoopsConfig['sitename'])).'%3A%20'.XOOPS_URL."/modules/$mydirname/index.php?id=$id" ;
	}
}

// mod_url & vmod_url
$mod_url = XOOPS_URL."/modules/$mydirname" ;
// check modulesless rewrite
if( ! empty( $xoopsModuleConfig['tc_modulesless_dir'] ) ) {
	$vmod_url = XOOPS_URL.'/'.$xoopsModuleConfig['tc_modulesless_dir'];
	$tc_rewrite_dir = '' ;
} else {
	$vmod_url = $mod_url ;
	$tc_rewrite_dir = TC_REWRITE_DIR ;
}


// Page Navigation
if( ! empty( $xoopsModuleConfig['tc_display_pagenav'] ) ) {

	$whr_sub = $xoopsModuleConfig['tc_display_pagenav'] == 2 ? "(submenu=1 OR storyid='$id')" : "1" ;
	$result = $xoopsDB->query("SELECT storyid,title,link,submenu FROM ".$xoopsDB->prefix( "tinycontent{$mydirnumber}" )." WHERE $whr_sub AND visible ORDER BY blockid" ) ;
	while( $tmp_array = $xoopsDB->fetchArray( $result ) ) {
		if( $tmp_array['storyid'] == $id ) {
			$next_array = $xoopsDB->fetchArray( $result ) ;
			break ;
		}
		$prev_array = $tmp_array ;
	}
}

// submenu unit mode
if( $xoopsModuleConfig['tc_display_pagenav'] == 3 ) {
	if( ! empty( $next_array ) && $next_array['submenu'] ) {
		unset( $next_array ) ;
	}
	if( ! empty( $tmp_array ) && $tmp_array['submenu'] ) {
		unset( $prev_array ) ;
	}
}

if( ! empty( $prev_array ) ) {
	$prev_title = $myts->makeTboxData4Show( $prev_array['title'] ) ;
	if( ! empty( $xoopsModuleConfig['tc_force_mod_rewrite'] ) || $prev_array['link'] == TC_WRAPTYPE_USEREWRITE ) {
		$prev_link = $tc_rewrite_dir . sprintf( TC_REWRITE_FILENAME_FMT , $prev_array['storyid'] ) ;
	} else {
		$wraproot = $prev_array['link'] == TC_WRAPTYPE_CONTENTBASE ? "content/" : '' ;
		$prev_link = "{$wraproot}index.php?id={$prev_array['storyid']}" ;
	}
} else {
	$prev_title = $prev_link = '' ;
}

if( ! empty( $next_array ) ) {
	$next_title = $myts->makeTboxData4Show( $next_array['title'] ) ;
	if( ! empty( $xoopsModuleConfig['tc_force_mod_rewrite'] ) || $next_array['link'] == TC_WRAPTYPE_USEREWRITE ) {
		$next_link = $tc_rewrite_dir . sprintf( TC_REWRITE_FILENAME_FMT , $next_array['storyid'] ) ;
	} else {
		$wraproot = $next_array['link'] == TC_WRAPTYPE_CONTENTBASE ? "content/" : '' ;
		$next_link = "{$wraproot}index.php?id={$next_array['storyid']}" ;
	}
} else {
	$next_title = $next_link = '' ;
}

if( ! empty( $homepage_id ) ) {
	if( ! empty( $xoopsModuleConfig['tc_force_mod_rewrite'] ) || $homepage_link_type == TC_WRAPTYPE_USEREWRITE ) {
		$top_link = $tc_rewrite_dir . sprintf( TC_REWRITE_FILENAME_FMT , $homepage_id ) ;
	} else {
		$wraproot = $homepage_link_type == TC_WRAPTYPE_CONTENTBASE ? "content/" : '' ;
		$top_link = "{$wraproot}index.php?id=$homepage_id" ;
	}
} else {
	$top_link = 'index.php' ;
}


// convert from {X_SITEURL} to XOOPS_URL
$content = str_replace( '{X_SITEURL}' , XOOPS_URL , $content ) ;

// assignment to Smarty
$xoopsTpl->assign( 'mod_url' , $mod_url ) ;
$xoopsTpl->assign( 'vmod_url' , $vmod_url ) ;
$xoopsTpl->assign( 'tinyd_title' , $myts->makeTboxData4Show( $title ) ) ;
$xoopsTpl->assign( 'xoops_pagetitle' , $myts->makeTboxData4Show( $title ) ) ;
$xoopsTpl->assign( 'xoops_module_header' , $xoopsModuleConfig['tc_common_htmlheader'] . "\n" . $html_header . "\n" . $xoopsTpl->get_template_vars( "xoops_module_header" ) ) ;
$xoopsTpl->assign( 'content' , $content ) ;
$xoopsTpl->assign( 'mail_link', $mail_link ) ;
$xoopsTpl->assign( 'lang_printerpage' , _TC_PRINTERFRIENDLY ) ;
$xoopsTpl->assign( 'lang_sendstory' , _TC_SENDSTORY ) ;
$xoopsTpl->assign( 'lang_nextpage' , _TC_NEXTPAGE ) ;
$xoopsTpl->assign( 'lang_prevpage' , _TC_PREVPAGE ) ;
$xoopsTpl->assign( 'lang_topofcontents' , _TC_TOPOFCONTENTS ) ;
$xoopsTpl->assign( 'is_display_print_icon' , $xoopsModuleConfig['tc_display_print_icon'] ) ;
$xoopsTpl->assign( 'is_display_friend_icon' , $xoopsModuleConfig['tc_display_friend_icon'] ) ;
$xoopsTpl->assign( 'is_display_pagenav' , $xoopsModuleConfig['tc_display_pagenav'] ) ;
$xoopsTpl->assign( 'prev_title' , $prev_title ) ;
$xoopsTpl->assign( 'prev_link' , $prev_link ) ;
$xoopsTpl->assign( 'next_title' , $next_title ) ;
$xoopsTpl->assign( 'next_link' , $next_link ) ;
$xoopsTpl->assign( 'top_link' , $top_link ) ;
$xoopsTpl->assign( 'id' , $id ) ;
$xoopsTpl->assign( 'homepage_id' , isset( $homepage_id ) ? $homepage_id : 0 ) ;
$xoopsTpl->assign( 'last_modified' , $last_modified ) ;


include( XOOPS_ROOT_PATH.'/footer.php' ) ;

?>
