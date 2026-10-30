<?php


if( defined( 'FOR_XOOPS_LANG_CHECKER' ) || ! defined( 'TINYCONTENT_AM_LOADED' ) ) {







// Appended by Xoops Language Checker -GIJOE- in 2006-11-07 06:20:58
define('_MD_A_MYMENU_MYTPLSADMIN','樣板');
define('_MD_A_MYMENU_MYBLOCKSADMIN','區塊/權限');
define('_MD_A_MYMENU_MYPREFERENCES','偏好設定');

// Appended by Xoops Language Checker -GIJOE- in 2006-04-11 11:14:42
define('_TC_UPDATE_WRAP_CONTENTS','重讀崁入文章的內容以利搜尋');

// Appended by Xoops Language Checker -GIJOE- in 2005-04-13 05:53:24
define('_TC_HTML_HEADER','HTML網頁檔頭');
define('_TC_CHECKED_ITEMS_ARE','將勾選的資料：');
define('_TC_BUTTON_MOVETO','搬移到');
define('_TC_CREATED','建立時間');
define('_TC_SAVEAS','另存成新文章');

// Appended by Xoops Language Checker -GIJOE- in 2005-02-11 18:59:09
define('_TC_TYPE_HTMLNOBB','HTML網頁內容 (bb code 關閉)');
define('_TC_TYPE_TEXTNOBB','純文字內容 (bb code 關閉)');

// Appended by Xoops Language Checker -GIJOE- in 2004-06-18 15:39:56
define('_TC_FMT_WRAPCHANGESRCHREF','【WRAP4】重寫HTML網頁內容的連結路徑（實驗性的）<font color=red><--建議使用</font><br /> 此功能會重寫相對連結為絕對連結，有圖檔的網頁特別適用。<br />');

// Appended by Xoops Language Checker -GIJOE- in 2004-05-06 09:53:54
define('_TC_SPAWLANG','zh-tw');
define('_TC_TH_VISIBLE','顯示');
define('_TC_TH_SUBMENU','子選單');
define('_TC_DISP_YES','顯示');
define('_TC_DISP_NO','不顯示');
define('_TC_CONTENT_TYPE','頁面類型');
define('_TC_TYPE_HTML','HTML網頁內容 (bb code 啟用)');
define('_TC_TYPE_TEXTWITHBB','純文字內容 (bb code 啟用)');
define('_TC_TYPE_PHPHTML','PHP程式 (bb code 關閉)');
define('_TC_TYPE_PHPWITHBB','PHP程式 (bb code 關閉)');
define('_TC_TYPE_PEARWIKI','PEAR Wiki (bb code 關閉)');
define('_TC_TYPE_PEARWIKIWITHBB','PEAR Wiki (bb code 啟用)');
define('_TC_TYPE_PUKIWIKI','PukiWiki (bb code 關閉)');
define('_TC_TYPE_PUKIWIKIWITHBB','PukiWiki (bb code 啟用)');
define('_TC_LASTMODIFIED','最後更新');
define('_TC_DONTUPDATELASTMODIFIED','勿自動更新本文章的最後修改時間');
define('_TC_CONTENTTYPE','類型');
define('_TC_ELINK','修改');
define('_TC_DELLINK','剪下');
define('_TC_WRAPROOT','崁入頁面中的路徑起始位置');
define('_TC_FMT_WRAPROOTTC','【WRAP1】相同於TinyContent模組<br />「%s」<br />');
define('_TC_FMT_WRAPROOTPAGE','【WRAP2】相同於崁入頁面。（無法使用評論功能）<br />「%s」假如可以的話，請使用 mod_rewrite。<br />');
define('_TC_FMT_WRAPBYREWRITE','【WRAP3】使用mod_rewrite（實驗性的）<br /> 上傳網頁檔案以及相關檔案（如：圖檔）到 %s<br />別忘了打開 mod_rewrite。<br />');
define('_TC_ERROREXIST','錯誤！已有相同檔名的檔案存在。');
define('_TC_FMT_WRAPPATHPERMOFF','<span style=\'font-size:11px;\'>此目錄「%s」不允許寫入。 <br />假如您想要經由瀏覽器上傳或刪除檔案，請打開寫入權限。<br />為了安全起見，建議您利用FTP軟體來上傳檔案或刪除檔案，如此一來，該目錄就可以不需要打開寫入權限。</span>');
define('_TC_FMT_WRAPPATHPERMON','<span style=\'font-size:11px;\'>不建議您用瀏覽器去上傳，盡可能用FTP軟體來上傳。</span>');
define('_TC_ALTER_TABLE','警告表格');
define('_TC_JS_CONFIRMDISCARD','所有修改將取消，確定嗎？');

define( 'TINYCONTENT_AM_LOADED' , 1 ) ;


//Admin Page Titles
define("_TC_ADMINTITLE","Tiny Content");

//Table Titles
define("_TC_ADDCONTENT","加入新內容");
define("_TC_EDITCONTENT","線上編輯內容");
define("_TC_ADDLINK","加入上傳的檔案");
define("_TC_EDITLINK","編輯連接");
define("_TC_ULFILE","上載檔案");
define("_TC_SFILE","搜尋");
define("_TC_DELFILE","刪除檔案");

//Table Data
define("_TC_HOMEPAGE","首頁");
define("_TC_LINKNAME","文章標題");
define("_TC_STORYID","編號");
define("_TC_VISIBLE","顯示");
define("_TC_CONTENT","內容");
define("_TC_YES","是");
define("_TC_NO","否");
define("_TC_URL","選擇檔案");
define("_TC_UPLOAD","上載");

define("_TC_LINKID","排序");
define("_TC_ACTION","確定");
define("_TC_EDIT","編輯");
define("_TC_DELETE","刪除");

define('_TC_DBUPDATED','資料庫更新成功！');
define('_TC_ERRORINSERT','資料庫更新失敗！');
define('_TC_RUSUREDEL','確定刪除這項內容？');
define('_TC_RUSUREDELF','確定刪除這個檔案？');
define('_TC_UPLOADED','檔案上傳成功！');
define('_TC_FDELETED','檔案刪除成功！');
define('_TC_ERRORUPL','檔案上載失敗！');
define('_TC_PERMERROR','錯誤：不能取存目錄，請改變目錄存放的權限為 777！');

// Added in v1.4
define('_TC_DISABLEBREAKS','不自動換行（當您使用「HTML網頁內容」時建議打勾）');
define('_TC_SUBMENU','顯示於主選單中的子選單');

}

?>
