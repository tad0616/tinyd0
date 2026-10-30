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

// check modulesless rewrite
if( ! stristr( $_SERVER['REQUEST_URI'] , 'modules' ) ) {
	$tinyd_vmod_dir = $_SERVER['REQUEST_URI'] ;
	$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'] ;
}

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

// check if $_GET['wrap'] is specified & exists the file
if( empty( $_GET['wrap'] ) ) {
	redirect_header( XOOPS_URL.'/' , 2 , _TC_FILENOTFOUND ) ;
	exit ;
}

// before fopen it eliminates '..' (thx JM2)
$wrap = str_replace( '..' , '' , $_GET['wrap'] ) ;
if( ! ( $fp = fopen( "content/$wrap" , "r" ) ) ) {
	redirect_header( XOOPS_URL.'/' , 2 , _TC_FILENOTFOUND ) ;
	exit ;
}

$body_flag = false ;
$content = "" ;
while( $buf = fgets( $fp , 4096 ) ) {
//	if( ! $body_flag && preg_match( "/<body.*>(.*)/i" , $buf , $regs ) ) {
//		$body_flag = true ;
//		$content .= $regs[1] ;
//	} else {
		$content .= $buf ;
//	}
}
fclose( $fp ) ;

/* $str=str_replace("\r\n","\n",$str);
   $str=str_replace("\r","\n",$str);
   $lines = explode("\n",$str); */

include XOOPS_ROOT_PATH."/header.php";
echo tc_convert_wrap_to_ie( $content ) ;
include XOOPS_ROOT_PATH."/footer.php";

?>