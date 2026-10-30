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

include( '../../mainfile.php' ) ;
include_once( 'class/tinyd.textsanitizer.php' ) ;
include_once( 'include/render_function.inc.php' ) ;
include_once( 'include/constants.inc.php' ) ;

// for "Duplicatable"
$mydirname = basename( dirname( __FILE__ ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

// utility variables
$mymodpath = XOOPS_ROOT_PATH."/modules/$mydirname" ;
$mytablename = $xoopsDB->prefix( "tinycontent{$mydirnumber}" ) ;

// check if $_GET['id'] is specified
$id = empty( $_GET['id'] ) ? 0 : intval( $_GET['id'] ) ;
if( $id <= 0 )  {
	redirect_header( XOOPS_URL.'/' , 2 , _TC_FILENOTFOUND ) ;
	exit ;
}

// main query
$result = $xoopsDB->query( "SELECT storyid,title,text,visible,nohtml,nosmiley,nobreaks,link,address,UNIX_TIMESTAMP(last_modified) AS last_modified,html_header FROM $mytablename WHERE storyid='$id' AND visible" ) ;
if( ( $result_array = $xoopsDB->fetchArray( $result ) ) == false ) {
	redirect_header( XOOPS_URL.'/' , 2 , _TC_FILENOTFOUND ) ;
	exit ;
}

// redirect if its base of wrapping is wrap_path (content)
if( $result_array['link'] >= TC_WRAPTYPE_CONTENTBASE ) {
	if( headers_sent() ) {
		redirect_header( XOOPS_URL . "/modules/$mydirname/content/index.php?op=print&id={$result_array['storyid']}" , 0 , '&nbsp;' ) ;
	} else {
		header( "Location: content/index.php?op=print&id={$result_array['storyid']}" ) ;
	}
	exit ;
}

include( "include/print.inc.php" ) ;

?>