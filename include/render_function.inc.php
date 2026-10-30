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

if( ! defined( 'TC_RENDER_FUNCTIONS_INCLUDED' ) ) {

define( 'TC_RENDER_FUNCTIONS_INCLUDED' , 1 ) ;

function tc_content_render( $text , $nohtml , $nosmiley , $nobreaks , $nbsp = 0 )
{
	$myts =& TinyDTextSanitizer::getInstance();

	if( $nohtml >= 16 ) {

		// db content (PEAR wiki)
		if( ! defined( 'PATH_SEPARATOR' ) ) define( 'PATH_SEPARATOR' , DIRECTORY_SEPARATOR == '/' ? ':' : ';' ) ;
		ini_set( 'include_path' , ini_get('include_path') . PATH_SEPARATOR . XOOPS_ROOT_PATH . '/common/PEAR' ) ;
		include_once "Text/Wiki.php";
		// include_once "Text/sunday_Wiki.php";
		$wiki = new Text_Wiki(); // create instance

		// Configuration
		$wiki->deleteRule( 'Wikilink' ); // remove a rule for auto-linking
		$wiki->setFormatConf( 'Xhtml' , 'translate' , HTML_SPECIALCHARS ) ; // HTML_ENTITIES -> HTML_SPECIALCHARS

		// $wiki = new sunday_Text_Wiki(); // create instance
		//$text = str_replace ( "\r\n", "\n", $text );
		//$text = str_replace ( "~\n", "[br]", $text );
		//$text = $wiki->transform($text);
		//$content = str_replace ( "[br]", "<br/>", $text );
		// special thx to minahito! you are great!!
		$content = $wiki->transform($text);

		if( $nohtml & 2 ) {
			$content = $myts->displayTarea( $content , 1 , ! $nosmiley , 1 , 1 , ! $nobreaks , $nbsp ) ;
		}

	} else if( $nohtml >= 8 ) {

		// db content (PHP)
		ob_start() ;
		eval( $text ) ;
		$content = ob_get_contents() ;
		ob_end_clean() ;

		if( $nohtml & 2 ) {
			$content = $myts->displayTarea( $content , 1 , ! $nosmiley , 1 , 1 , ! $nobreaks , $nbsp ) ;
		}

	} else if( $nohtml < 4 ) {

		switch( $nohtml ) {
			case 0 : // HTML with BB
				$content = $myts->displayTarea( $text , 1 , ! $nosmiley , 1 , 1 , ! $nobreaks , $nbsp ) ;
				break ;
			case 1 : // Text with BB
				$content = $myts->displayTarea( $text , 0 , ! $nosmiley , 1 , 1 , ! $nobreaks , $nbsp ) ;
				break ;
			case 2 : // HTML without BB
				$content = $text ;
				break ;
			case 3 : // Text without BB
				$content = htmlspecialchars( $text , ENT_QUOTES ) ;
				if( ! $nobreaks ) $content = nl2br( $content ) ;
				break ;
		}

	} else {

		$content = $text ;

	}

	return $content ;
}


function tc_change_srchref( $content , $wrap_base_url )
{
	$patterns = array( "/src\=\"(?!http:|https:)([^, \r\n\"\(\)'<>]+)/i" , "/src\=\'(?!http:|https:)([^, \r\n\"\(\)'<>]+)/i" , "/src\=(?!http:|https:)([^, \r\n\"\(\)'<>]+)/i" , "/href\=\"(?!http:|https:)([^, \r\n\"\(\)'<>]+)/i" , "/href\=\'(?!http:|https:)([^, \r\n\"\(\)'<>]+)/i" , "/href\=(?!http:|https:)([^, \r\n\"\(\)'<>]+)/i" ) ;
	$replacements = array( "src=\"$wrap_base_url/\\1" , "src='$wrap_base_url/\\1" , "src=$wrap_base_url/\\1" , "href=\"$wrap_base_url/\\1" , "href='$wrap_base_url/\\1" , "href=$wrap_base_url/\\1" ) ;

	return preg_replace($patterns, $replacements, $content);
}



if( ! function_exists( 'mb_convert_encoding' ) ) {
	function mb_convert_encoding( $str ) { return $str ; }
}

if( ! function_exists( 'mb_internal_encoding' ) ) {
	function mb_internal_encoding( $str ) { return "UTF-8" ; }
}


}

?>