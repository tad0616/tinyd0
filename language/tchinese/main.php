<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'TINYCONTENT_MB_LOADED' ) ) {



// Appended by Xoops Language Checker -GIJOE- in 2005-04-19 18:26:42
define('_TC_FMT_DEFAULT_COMMENT_TITLE','Re: %s');

// Appended by Xoops Language Checker -GIJOE- in 2004-06-02 17:58:48
define('_TC_NEXTPAGE','往下');
define('_TC_PREVPAGE','往前');
define('_TC_TOPOFCONTENTS','Top of contents');

define( 'TINYCONTENT_MB_LOADED' , 1 ) ;

define('_TC_FILENOTFOUND','找不到檔案！請檢查網址！');
define("_TC_PRINTERFRIENDLY","友善列印頁");
define("_TC_SENDSTORY","傳送此文章給好友");

// whether parameter for "mailto:" is already rawurlencoded
define("_TC_DONE_MAILTOENCODE" , false ) ;

// %s is your site name. for single byte languages (ignored when _TC_DONE_MAILTOENCODE is true)
define("_TC_INTARTICLE","有趣的文章在 %s");
define("_TC_INTARTFOUND","這裡有篇我在 %s 找到的好文章");

// for multibyte languages (ignored when _TC_DONE_MAILTOENCODE is false)
define("_TC_MB_INTARTICLE","" ) ;
define("_TC_MB_INTARTFOUND","" ) ;

// %s represents your site name
define("_TC_THISCOMESFROM","此文章來自 %s");
define("_TC_URLFORSTORY","此文的網址是：");
}

if( ! defined( 'FOR_XOOPS_LANG_CHECKER' ) && ! function_exists( 'tc_convert_wrap_to_ie' ) ) {
	function tc_convert_wrap_to_ie( $str ) {
		return $str ;
	}
}


?>