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

// sleep( 1 ) ;	// for getting session

include( '../../mainfile.php' ) ;
include_once( 'class/tinyd.textsanitizer.php' ) ;
include_once( 'include/render_function.inc.php' ) ;
include_once( 'include/constants.inc.php' ) ;
// include_once( "include/gtickets.php" ) ;

// $myts
$myts =& TinyDTextSanitizer::getInstance() ;

// only Administrator can show
if( ! is_object( $xoopsUser ) || ! $xoopsUser->isAdmin() ) exit ;

// for "Duplicatable"
$mydirname = basename( dirname( __FILE__ ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

// utility variables
$mymodpath = XOOPS_ROOT_PATH."/modules/$mydirname" ;
$mytablename = $xoopsDB->prefix( "tinycontent{$mydirnumber}" ) ;

// check if post data is passed via session...
if( empty( $_SESSION['tinyd_preview_post'] ) ) exit ;

$post = $_SESSION['tinyd_preview_post'] ;
unset( $_SESSION['tinyd_preview_post'] ) ;

// cache file name check (thx JM2)
/* if( ! preg_match( '/^'.$mydirname.'_preview_\d{10}$/' , $_GET['preview'] ) ) exit ;

$content_cache_full_path = XOOPS_CACHE_PATH . '/' . $_GET['preview'] ;
$fp = fopen( $content_cache_full_path , 'r' ) ;
if( $fp === false ) die( _TC_FILENOTFOUND . " $content_cache_full_path" ) ;
$text = fread( $fp , 65536 ) ;
fclose( $fp ) ;
@unlink( $content_cache_full_path ) ;*/

// force turning PHP debug on
$original_level = error_reporting( E_ALL ) ;

$content = tc_content_render( $post['message'] , $post['nohtml'] , $post['nosmiley'] , $post['nobreaks'] , $xoopsModuleConfig['tc_space2nbsp'] ) ;

// restore error_report_level
error_reporting( $original_level ) ;

echo '<html><head><meta http-equiv="content-type" content="text/html; charset='._CHARSET.'" /><meta http-equiv="content-language" content="'._LANGCODE.'" /><title>'.$xoopsConfig['sitename'].'</title></head><body>'.$content.'</body></html>';

?>