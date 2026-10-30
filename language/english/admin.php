<?php

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'TINYCONTENT_AM_LOADED' ) ) {

define('_MD_A_MYMENU_MYTPLSADMIN','Templates');
define('_MD_A_MYMENU_MYBLOCKSADMIN','Blocks/Permissions');
define('_MD_A_MYMENU_MYPREFERENCES','Preferences');


define( 'TINYCONTENT_AM_LOADED' , 1 ) ;

//Admin Page Titles
define("_TC_ADMINTITLE","Tiny Content");

// SPAW
define('_TC_SPAWLANG','en') ;

//Table Titles
define("_TC_ADDCONTENT","Add new Content");
define("_TC_EDITCONTENT","Edit Content");
define("_TC_ADDLINK","Add PageWrap");
define("_TC_EDITLINK","Modify PageWrap");
define("_TC_ULFILE","Upload File");
define("_TC_SFILE","Search");
define("_TC_DELFILE","Delete File");
define("_TC_UPDATE_WRAP_CONTENTS","Update wrapped contents for searching");

//Table Data
define("_TC_HOMEPAGE","Home");
define("_TC_LINKNAME","Link Title");
define("_TC_STORYID","ID");
define("_TC_VISIBLE","Visible");
define("_TC_TH_VISIBLE","Vis");
define("_TC_HTML_HEADER","HTML header");
define("_TC_CONTENT","Content");
define("_TC_YES","Yes");
define("_TC_NO","No");
define("_TC_URL","Select File");
define("_TC_UPLOAD","Upload");
define("_TC_DISABLEBREAKS","Disable Linebreak Conversion (Activate when using HTML)");
define("_TC_SUBMENU","Display in Submenu");
define("_TC_TH_SUBMENU","Sub");
define("_TC_DISP_YES","Display");
define("_TC_DISP_NO","Do Not Display");

define("_TC_CONTENT_TYPE","Page Type");
define("_TC_TYPE_HTML","HTML Content (bb code enabled)"); // nohtml=0
define("_TC_TYPE_HTMLNOBB","HTML Content (bb code disabled)"); // nohtml=2
define("_TC_TYPE_TEXTWITHBB","Text Content (bb code enabled)"); // nohtml=1
define("_TC_TYPE_TEXTNOBB","Text Content (bb code disabled)"); // nohtml=3
define("_TC_TYPE_PHPHTML","PHP codes (bb code disabled)"); // nohtml=8
define("_TC_TYPE_PHPWITHBB","PHP codes (bb code enabled)"); // nohtml=10
define("_TC_TYPE_PEARWIKI","PEAR Wiki (bb code disabled)"); // nohtml=16
define("_TC_TYPE_PEARWIKIWITHBB","PEAR Wiki (bb code enabled)"); // nohtml=18
define("_TC_TYPE_PUKIWIKI","PukiWiki (bb code disabled)"); // nohtml=32 (resv)
define("_TC_TYPE_PUKIWIKIWITHBB","PukiWiki (bb code enabled)"); // nohtml=34 (resv)

define("_TC_CHECKED_ITEMS_ARE","Checked records are:");
define("_TC_BUTTON_MOVETO","Export(Move)");

define("_TC_LASTMODIFIED","Last Modified");
define("_TC_DONTUPDATELASTMODIFIED","Do not update it automatically");
define("_TC_CREATED","Created");
define("_TC_SAVEAS","Save as");

define("_TC_LINKID","Priority");
define("_TC_CONTENTTYPE","Type");
define("_TC_ACTION","Action");
define("_TC_EDIT","Edit");
define("_TC_DELETE","Delete");
define("_TC_ELINK","Modify");
define("_TC_DELLINK","Cut");

define("_TC_WRAPROOT","PageWrap's Base");
define("_TC_FMT_WRAPROOTTC","Same as TinyContent module<br /> (%s) <br />");
define("_TC_FMT_WRAPROOTPAGE","Same as wrapped page.<br /> (%s) <br />use mod_rewrite if you can.<br />");
define("_TC_FMT_WRAPBYREWRITE","use mod_rewrite (experimental)<br /> upload HTMLs and others into %s<br />Do not forget turning mod_rewrite on<br />");
define("_TC_FMT_WRAPCHANGESRCHREF","rewrite attributes of html (experimental)<br /> this option rewrites relative links to absolute links.<br />This probably mis-recognizes sentences looks like HTML source<br />");

define("_TC_DBUPDATED","Database Updated Successfully!");
define("_TC_ERRORINSERT","Error while updating database!");
define("_TC_RUSUREDEL","Are you sure you want to delete this content? ");
define("_TC_RUSUREDELF","Are you sure you want to delete this file?");
define("_TC_UPLOADED","File Uploaded Successfully!");
define("_TC_FDELETED","File Deleted Successfully!");
define("_TC_ERROREXIST","Error. The same filename exists");
define("_TC_ERRORUPL","Error while uploading file!");
define("_TC_FMT_WRAPPATHPERMOFF","<span style='font-size:xx-small;'>The directory for wrapping (%s) is not allowed to be written to by httpd. <br />If you'd like to upload or delete files via HTTP, turn the writing permission on.<br />I recommend to upload or delete files only via ftp for security reasons, thus the writing permission of the directory should still be off.</span>");
define("_TC_FMT_WRAPPATHPERMON","<span style='font-size:xx-small;'>I don't recommend you upload via HTTP. Try to upload the files for wrapping via ftp, if you can.</span>" ) ;

define("_TC_ALTER_TABLE","Alter Table");

define("_TC_JS_CONFIRMDISCARD","Changes will be discarded. OK?");

}

?>