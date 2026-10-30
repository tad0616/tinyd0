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
$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

include_once( XOOPS_ROOT_PATH . "/modules/$mydirname/include/constants.inc.php" ) ;

if( ! class_exists( 'TinyDTextSanitizer' ) ) {
	include_once( XOOPS_ROOT_PATH . "/modules/$mydirname/class/tinyd.textsanitizer.php" ) ;
}


eval( '

function tinycontent'.$mydirnumber.'_search( $keywords , $andor , $limit , $offset , $userid )
{
	return tinyd_search_base( "'.$mydirname.'" , "'.$mydirnumber.'" , $keywords , $andor , $limit , $offset , $userid ) ;
}

' ) ;


if( ! function_exists( 'tinyd_search_base' ) ) {

function tinyd_search_base( $mydirname , $mydirnumber , $keywords , $andor , $limit , $offset , $userid )
{
	// get my config
	$module_handler =& xoops_gethandler('module');
	$config_handler =& xoops_gethandler('config');
	$module =& $module_handler->getByDirname($mydirname);
	$config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));

	$myts =& TinyDTextSanitizer::getInstance() ;
	$db = XoopsDatabaseFactory::getDatabaseConnection() ;

	// XOOPS Search module
	$showcontext = empty( $_GET['showcontext'] ) ? 0 : 1 ;
	$select4con = $showcontext ? "text" : "'' AS text" ;

	$sql = "SELECT storyid,title,link,UNIX_TIMESTAMP(last_modified),$select4con FROM ".$db->prefix( "tinycontent$mydirnumber" )." WHERE visible AND ! (nohtml & 8) " ;

	if( ! empty( $userid ) ) {
		$sql .= " AND 0 ";
	}

	$whr = "" ;
	if( is_array( $keywords ) && count( $keywords ) > 0 ) {
		$whr = "AND (" ;
		switch( strtolower( $andor ) ) {
			case "and" :
				foreach( $keywords as $keyword ) {
					$whr .= "CONCAT(title,' ',text) LIKE '%$keyword%' AND " ;
				}
				$whr = substr( $whr , 0 , -5 ) ;
				break ;
			case "or" :
				foreach( $keywords as $keyword ) {
					$whr .= "CONCAT(title,' ',text) LIKE '%$keyword%' OR " ;
				}
				$whr = substr( $whr , 0 , -4 ) ;
				break ;
			default :
				$whr .= "CONCAT(title,' ',text) LIKE '%{$keywords[0]}%'" ;
				break ;
		}
		$whr .= ")" ;
	}

	$sql = "$sql $whr ORDER BY storyid ASC" ;
	$result = $db->query( $sql , $limit , $offset ) ;
	$ret = array() ;
	$context = '' ;
	while( list( $id , $title , $link , $timestamp , $text ) = $db->fetchRow( $result ) ) {

		// get context for module "search"
		if( function_exists( 'search_make_context' ) && $showcontext ) {
			$full_context = strip_tags( $myts->displayTarea( $text , 1 , 1 , 1 , 1 , 1 ) ) ;
			if( function_exists( 'easiestml' ) ) $full_context = easiestml( $full_context ) ;
			$context = search_make_context( $full_context , $keywords ) ;
		}

		if( ! empty( $config['tc_force_mod_rewrite'] ) ) {
			if( ! empty( $config['tc_modulesless_dir'] ) ) { 
				$href = '../../' . $config['tc_modulesless_dir'] . '/' . sprintf( TC_REWRITE_FILENAME_FMT , $id ) ;
			} else {
				$href = TC_REWRITE_DIR . sprintf( TC_REWRITE_FILENAME_FMT , $id ) ;
			}
		} else {
			if( $link == TC_WRAPTYPE_USEREWRITE ) {
				$href = TC_REWRITE_DIR . sprintf( TC_REWRITE_FILENAME_FMT , $id ) ;
			} else if( $link == TC_WRAPTYPE_CONTENTBASE ) {
				$href = "content/index.php?id=$id" ;
			} else {
				$href = "index.php?id=$id" ;
			}
		}

		$ret[] = array(
			"image" => "images/content.gif" ,
			"link" => $href ,
			"title" => $title ,
			"time" => $timestamp ,
			"uid" => "0" ,
			"context" => $context
		) ;
	}

	return $ret ;
}

}


?>