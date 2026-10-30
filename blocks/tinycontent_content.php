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
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

if( ! defined( 'TC_BLOCK_CONTENT_INCLUDED' ) ) {

define( 'TC_BLOCK_CONTENT_INCLUDED' , 1 ) ;

function b_tinycontent_content_show( $options )
{
	global $xoopsDB , $xoopsConfig ;

	$mydirname = $options[0] ;
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	$mytablename = $xoopsDB->prefix( "tinycontent{$mydirnumber}" ) ;
	$mymodpath = XOOPS_ROOT_PATH . "/modules/$mydirname" ;
	$mymoddir = XOOPS_URL . "/modules/$mydirname" ;

	if( ! class_exists( 'TinyDTextSanitizer' ) ) {
		include_once( "$mymodpath/class/tinyd.textsanitizer.php" ) ;
	}
	if( ! defined( 'TC_RENDER_FUNCTIONS_INCLUDED' ) ) {
		include_once( "$mymodpath/include/render_function.inc.php" ) ;
	}

	if( ! defined( 'TINYCONTENT_MB_LOADED' ) ) {
		if ( file_exists( "$mymodpath/language/{$xoopsConfig['language']}/main.php" ) ) {
			include_once( "$mymodpath/language/{$xoopsConfig['language']}/main.php" ) ;
		} else {
			include_once( "$mymodpath/language/english/main.php" ) ;
		}
	}

	// get my config
	$module_handler =& xoops_gethandler('module');
	$config_handler =& xoops_gethandler('config');
	$module =& $module_handler->getByDirname($mydirname);
	$config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	$space2nbsp = empty( $config['tc_space2nbsp'] ) ? 0 : 1 ;

	$result = $xoopsDB->query( "SELECT text,title,link,nohtml,nosmiley,nobreaks,address FROM $mytablename WHERE storyid='{$options[1]}'" ) ;
	list( $text,$title,$link,$nohtml,$nosmiley,$nobreaks,$address ) = $xoopsDB->fetchRow( $result ) ;

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
		/* if( $link == TC_WRAPTYPE_CHANGESRCHREF ) */ $content = tc_change_srchref( $content , "$mymoddir/content" ) ;
		ob_end_clean() ;

	} else {

		$myts =& TinyDTextSanitizer::getInstance();
		$shorten_text = $myts->tinyExtractSummary( $text ) ;
		$is_summary = ( $shorten_text != $text ) ;
		$content = tc_content_render( $shorten_text , $nohtml , $nosmiley , $nobreaks , $space2nbsp ) ;

	}

	// if template file exists, parse it.
	if( file_exists( "$mymodpath/templates/blocks/tinycontent_content_block.tpl" ) ) {
		$myts =& TinyDTextSanitizer::getInstance() ;
		$tpl = new XoopsTpl();
		$tpl->assign( array(
			'storyid' => $options[1] ,
			'mymoddir' => $mymoddir ,
			'is_summary' => $is_summary ,
			'lang_more' => _MORE ,
			'title' => $myts->makeTboxData4Show( $title ) ,
			'content' => $content
		) ) ;
		$block['content'] = $tpl->fetch( "file:$mymodpath/templates/blocks/tinycontent_content_block.tpl" ) ;

	} else {

		$block['content'] = $content ;

	}


	return $block ;
}


function b_tinycontent_content_edit( $options )
{
	global $xoopsDB , $xoopsConfig ;

	$mydirname = $options[0] ;
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	$mytablename = $xoopsDB->prefix( "tinycontent{$mydirnumber}" ) ;
	$mymoddir = XOOPS_URL . "/modules/$mydirname" ;
	$mydirname4edit = htmlspecialchars( $mydirname , ENT_QUOTES ) ;
	$old_storyid = empty( $options[1] ) ? 0 : intval( $options[1] ) ;

	$storyid_options = "<option value='0'>----</option>\n" ;
	$result = $xoopsDB->query( "SELECT storyid,title FROM $mytablename" ) ;
	while( list( $storyid , $title ) = $xoopsDB->fetchRow( $result ) ) {
		$selected = $storyid == $old_storyid ? "selected='selected'" : "" ;
		$storyid_options .= "<option value='$storyid' $selected>".htmlspecialchars(xoops_substr($title,0,50),ENT_QUOTES)."</option>\n" ;
	}

	$ret = "
		<input type='hidden' name='options[0]' value='$mydirname4edit' />
		<input type='hidden' name='id4js' value='$old_storyid' />
		<input type='hidden' name='title4js' value='----' />
		<select name='options[1]' onchange='document.blockform.id4js.value=this.value;document.blockform.title4js.value=this.options[this.selectedIndex].text;'>$storyid_options</select>
		<img src='$mymoddir/images/reflect.gif' onClick=\"document.blockform.btitle.value=document.blockform.title4js.value\" alt='reflect' />
		<img src='$mymoddir/images/editicon.gif' onClick=\"window.open('{$mymoddir}/admin/index.php?op=edit&amp;id='+document.blockform.id4js.value,'','');return(false);\" alt='"._EDIT."' />
	\n" ;

	return $ret ;
}



}


?>