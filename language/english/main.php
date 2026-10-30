<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'TINYCONTENT_MB_LOADED' ) ) {

define( 'TINYCONTENT_MB_LOADED' , 1 ) ;


define('_TC_FILENOTFOUND','File not found! Please check the URL!');
define("_TC_PRINTERFRIENDLY","Printer Friendly Page");
define("_TC_SENDSTORY","Send this Story to a Friend");

define("_TC_NEXTPAGE","Next");
define("_TC_PREVPAGE","Previous");
define("_TC_TOPOFCONTENTS","Top of contents");

// whether parameter for "mailto:" is already rawurlencoded
define("_TC_DONE_MAILTOENCODE" , false ) ;

// %s is your site name. for single byte languages (ignored when _TC_DONE_MAILTOENCODE is true)
define("_TC_INTARTICLE","Interesting Article at %s");
define("_TC_INTARTFOUND","Here is an interesting article I have found at %s");

// for multibyte languages (ignored when _TC_DONE_MAILTOENCODE is false)
define("_TC_MB_INTARTICLE","" ) ;
define("_TC_MB_INTARTFOUND","" ) ;

// %s represents your site name
define("_TC_THISCOMESFROM","This article comes from %s");
define("_TC_URLFORSTORY","The URL for this story is:");
}

if( ! defined( 'FOR_XOOPS_LANG_CHECKER' ) && ! function_exists( 'tc_convert_wrap_to_ie' ) ) {
	function tc_convert_wrap_to_ie( $str ) {
		return $str ;
	}
}


?>