<?php

//	$xoopsOption['nocommon'] = true ;
//	require '../../../mainfile.php' ;

	$lang = empty( $_GET['lang'] ) ? '' : str_replace( '..' , '' , $_GET['lang'] ) ;

	if( file_exists( "../language/$lang/text_wiki_sample.wiki" ) ) {
		$fp = fopen( "../language/$lang/text_wiki_sample.wiki" , 'r' ) ;
	} else {
		$fp = fopen( "../language/english/text_wiki_sample.wiki" , 'r' ) ;
	}
	$wiki_source = fread( $fp , 65536 ) ;
	fclose( $fp ) ;

	if( ! defined( 'PATH_SEPARATOR' ) ) define( 'PATH_SEPARATOR' , DIRECTORY_SEPARATOR == '/' ? ':' : ';' ) ;
	ini_set( 'include_path' , ini_get('include_path') . PATH_SEPARATOR . dirname(dirname(dirname(dirname(__FILE__)))) . '/common/PEAR' ) ;
	include_once "Text/Wiki.php";
	// include_once "Text/sunday_Wiki.php";
	$wiki = new Text_Wiki(); // create instance

	// Configuration
	$wiki->deleteRule( 'Wikilink' ); // remove a rule for auto-linking
	$wiki->setFormatConf( 'Xhtml' , 'translate' , false ) ; // remove HTML_ENTITIES

	// $wiki = new sunday_Text_Wiki(); // create instance
	//$text = str_replace ( "\r\n", "\n", $text );
	//$text = str_replace ( "~\n", "[br]", $text );
	//$text = $wiki->transform($text);
	//$content = str_replace ( "[br]", "<br/>", $text );
	// special thx to minahito! you are great!!
	$wiki_body = $wiki->transform( $wiki_source ) ;
	
	echo '
	<html>
	<head>
		<title>PEAR::Text_Wiki Sample</title>
		<style>
		body, p, br, td, th {
			font-family: "Lucida Grande", Verdana, Arial, Geneva;
			font-size: 9pt;
			color: black;
			line-spacing: 120%;
		}
		
		table {
			border-spacing: 0px;
			border: 1px solid gray;
		}
		
		th , td {
			margin: 1px;
			border: 1px solid silver;
			padding: 4px;
		}
		
		h1 { font-size: 24pt;}
		h2 { font-size: 18pt; border-bottom: 1px solid gray; clear: both;}
		h3 { font-size: 14pt;}
		h4 { font-size: 12pt;}
		h5 { font-size: 10pt;}
		h6 { font-size: 9pt;}
		
	
		blockquote {
			border: 1px solid silver;
			background: #eee;
			margin: 4px;
			padding: 4px 12px;
		}
		
		table.admin {
			border: 2px solid #039;
			border-spacing: 0px;
			padding: 0px;
		}
		
		th.admin {
			padding: 4px;
			background: #039;
			color: white;
			font-weight: bold;
			vertical-align: bottom;
		}
		
		td.admin {
			border: 1px solid white;
			padding: 4px;
			background: #eee;
			vertical-align: top;
		}
		
		
		a:link, a:active, a:visited {
			color: blue;
			text-decoration: none;
			border-bottom: 1px solid blue;
		}
		
		a:hover {
			color: blue;
			text-decoration: none;
			border-bottom: 1px dotted blue;
		}
		
	
		li {
			margin-top: 3pt;
			margin-bottom: 3pt;
		}
		
		pre {
			border: 1px dashed #036;
			background: #eee;
			padding: 6pt;
			font-family: ProFont, Monaco, Courier, "Andale Mono", monotype;
			font-size: 9pt;
		}
		
		input[type="text"], input[type="password"], textarea {
			font-family: ProFont, Monaco, Courier, "Andale Mono", monotype;
			font-size: 9pt;
		}
		
		table.nav_table {
			width: 100%;
		}
		
		td.tabs_marginal {
			background: white;
			border-bottom: 1px solid black;
		}
		
		td.tabs_unselect {
			background: #aaa;
			border-top: 1px solid black;
			border-left: 1px solid black;
			border-right: 1px solid black;
			border-bottom: 1px solid black;
			text-align: center;
		}
		
		td.tabs_selected {
			background: #ddd;
			border-top: 1px solid black;
			border-left: 1px solid black;
			border-right: 1px solid black;
			border-bottom: none;
			text-align: center;
			font-weight: bold;
		}
		
		td.wide_marginal {
			background: #ddd;
			border-bottom: 1px solid black;
		}
		
		td.wide_unselect {
			background: #ddd;
			border-bottom: 1px solid black;
			text-align: center;
		}
		
		td.wide_selected {
			background: #ddd;
			border-bottom: 1px solid black;
			text-align: center;
			font-weight: bold;
		}
		
		td.tall_unselect {
			font-weight: normal;
		}
		
		td.tall_selected {
			font-weight: normal;
		}
		
		table.yawiki {
			border-spacing: 0px;
			border: 1px solid gray;
		}
		
		tr.yawiki {
		}
		
		th.yawiki {
			margin: 1px;
			border: 1px solid silver;
			padding: 4px;
			font-weight: bold;
		}
		
		td.yawiki {
			margin: 1px;
			border: 1px solid silver;
			padding: 4px;
		}
		
		th.yawiki-form {
			text-align: right;
			padding: 4px;
		}
		
		td.yawiki-form {
			text-align: left;
			padding: 4px;
		}
		
		legend.yawiki-form {
			font-size: 120%;
		}
		
		label.yawiki-form {
			font-weight: bold;
		}
		
		div.toc_list {
			border: 1px solid #ccc;
			background-color: #eee;
			padding: 1em;
			margin-bottom: 2em;
			float: left;
			clear: both;
		}
		
		div.toc_item {
			font-size: 90%;
			margin-top: 0.5em;
		}
		
	</style>
	</head>
	<body>
	'.$wiki_body.'
	</body>
	</html>
	' ;
	
?>