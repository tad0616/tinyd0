<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

// referer check
$ref = xoops_getenv('HTTP_REFERER');
if( $ref == '' || strpos( $ref , XOOPS_URL.'/modules/system/admin.php' ) === 0 ) {
	/* TinyD specific part */

	// update D blocks's edit_func
	global $xoopsDB ;
	$query = "SELECT mid FROM ".$xoopsDB->prefix('modules')." WHERE dirname='".$modversion['dirname']."' ";
	$result = $xoopsDB->query( "SELECT mid FROM ".$xoopsDB->prefix('modules')." WHERE dirname='{$modversion['dirname']}'" ) ;
	list( $mid ) = $xoopsDB->fetchRow( $result ) ;
	$xoopsDB->query( "UPDATE ".$xoopsDB->prefix("newblocks")." SET edit_func='b_tinycontent_content_edit' WHERE show_func='b_tinycontent_content_show' AND mid='$mid'" ) ;

	// last_modified from TinyContent
	if( $xoopsDB->query( "SELECT last_modified FROM ".$xoopsDB->prefix("tinycontent{$mydirnumber}") ) === false ) {
		$xoopsDB->queryF( "ALTER TABLE ".$xoopsDB->prefix("tinycontent{$mydirnumber}")." ADD last_modified timestamp(14)" ) ;
	}

	// created & html_header from TinyD <= 2.0x
	if( $xoopsDB->query( "SELECT created,html_header FROM ".$xoopsDB->prefix("tinycontent{$mydirnumber}") ) === false ) {
		$xoopsDB->queryF( "ALTER TABLE ".$xoopsDB->prefix("tinycontent{$mydirnumber}")." ADD created datetime NOT NULL default '2001-1-1 00:00:00', ADD html_header text default NULL" ) ;
	}

	/* General part */

	// Keep the values of block's options when module is updated (by nobunobu)
	include dirname( __FILE__ ) . "/updateblock.inc.php" ;

}

?>