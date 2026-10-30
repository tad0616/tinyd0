<?php
// Module Info Tiny Content

if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'TINYCONTENT_MI_LOADED' ) ) {

define( 'TINYCONTENT_MI_LOADED' , 1 ) ;

// The name of this module
define("_MI_TINYCONTENT_NAME","TinyD");

// A brief description of this module
define("_MI_TINYCONTENT_DESC","Creating content made as easy as it can be.");

// Name for Menu Block
define("_MI_TC_BNAME1","TinyD %s Menu");
define("_MI_TC_BNAME2","TinyD %s Content");
define("_MI_TC_BDESC1","Builds the navigation");
define("_MI_TC_BDESC2","Show a content as a block. [summary] tag valid");

// Admin Menu
define("_TC_MD_ADMENU1","Add Content");
define("_TC_MD_ADMENU2","Add PageWrap");
define("_TC_MD_ADMENU3","Edit/Delete Content");
define("_TC_MD_ADMENU_MYBLOCKSADMIN","Blocks/Groups");
define("_TC_MD_ADMENU_MYTPLSADMIN","Templates");

// WYSIWYG Defines for v1.4
//define('_MI_WYSIWYG','Use Wysiwyg Editor?');
//define('_MI_WYSIWYG_DESC','');
define('_MI_COMMON_HTMLHEADER','Common HTML headers');
define('_MI_COMMON_HTMLHEADER_DESC','Check if xoops_module_header exists in your theme');
define('_MI_TAREA_WIDTH','Width of TextAreas');
define('_MI_TAREA_WIDTH_DESC','');
define('_MI_HEADER_TAREA_HEIGHT','Height of TextArea for HTML header');
define('_MI_HEADER_TAREA_HEIGHT_DESC','');
define('_MI_TAREA_HEIGHT','Height of TextArea for body');
define('_MI_TAREA_HEIGHT_DESC','');
define('_MI_FORCE_MOD_REWRITE','use mod_rewrite with whole of this module');
define('_MI_FORCE_MOD_REWRITE_DESC',"Don't forget turning mod_rewrite on. eg) rename .htaccess.rewrite to .htaccess");
define('_MI_MODULESLESS_DIR','Name of the directory with modules/less mode');
define('_MI_MODULESLESS_DIR_DESC','experimental implementation. you should add some specific sentences into XOOPS_ROOT_PATH/.htaccess<br />leave blank normally');
define('_MI_SPACE2NBSP','doubled space is changed as space+&amp;nbsp; (when linebreak on)');
define('_MI_DISPLAY_PRINT_ICON','Displays icon of "Printer friendly"');
define('_MI_DISPLAY_FRIEND_ICON','Displays icon of "Tell a friend"');
define('_MI_USE_TAF_MODULE','User "Tell a Friend" module');
define('_MI_DISPLAY_PAGENAV','Page Navigation');
define('_MI_DISPLAY_PAGENAV_NONE','Do Not display');
define('_MI_DISPLAY_PAGENAV_DISP','All visible contents');
define('_MI_DISPLAY_PAGENAV_SUB','Only submenu contents');
define('_MI_DISPLAY_PAGENAV_PERSUB','Divide by submenu');
define('_MI_NAVBLOCK_TARGET','Target for tinycontent block');
define('_MI_NAVBLOCK_TARGET_DISP','Titles of all visible contents');
define('_MI_NAVBLOCK_TARGET_SUB','Titles of only submenu contents');


//***********************************************************************//
// No language config below!!! Do not change this!!!                     //
//  (These constants are not used in Duplicatable)                       //
//***********************************************************************//

define("_MI_TINYCONTENT_PREFIX", "tinycontent");
define("_MI_DIR_NAME", "tinycontent");

}

?>
