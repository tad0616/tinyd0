<?php

if( ! class_exists( 'TinyDTextSanitizer' ) ) {

  include_once( XOOPS_ROOT_PATH . '/class/module.textsanitizer.php' ) ;

  class TinyDTextSanitizer extends MyTextSanitizer {

    var $nbsp = 0 ;

    public static function getInstance()
    {
      static $instance;
      if (!isset($instance)) {
        $instance = new TinyDTextSanitizer();
      }
      return $instance;
    }



    public function &displayTarea( $text, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1 , $nbsp = 0 )
    {

      $text = preg_replace( "/javascript:/si" , "jjaavvaassccrriipptt::" , $text ) ;
      $this->nbsp = $nbsp ;
      $text = parent::displayTarea( $text , $html , $smiley , $xcode , $image , $br ) ;
      $text = preg_replace( "/jjaavvaassccrriipptt::/" , "javascript:" , $text ) ;
      $text = $this->tinyDCodeDecode( $text , $nbsp ) ;
      return $text ;
    }


    function tinyDCodeDecode( $text )
    {
      $removal_tags = array( '[summary]' , '[/summary]' , '[pagebreak]' ) ;
      $text = str_replace( $removal_tags , '' , $text ) ;
      $patterns = array();
      $replacements = array();
      $patterns[] = "/\[siteimg align=(['\"]?)(left|center|right)\\1]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
      $replacements[] = '<img src="'.XOOPS_URL.'/\\3" align="\\2" alt="" />';
      $patterns[] = "/\[siteimg]([^\"\(\)\?\&'<>]*)\[\/siteimg\]/sU";
      $replacements[] = '<img src="'.XOOPS_URL.'/\\1" alt="" />';

      return preg_replace($patterns, $replacements, $text);
    }



    function tinyExtractSummary( $text )
    {
      $patterns[] = "/^(.*)\[summary\](.*)\[\/summary\](.*)$/sU";
      $replacements[] = '$2';
      return preg_replace($patterns, $replacements, $text);

    }



    public function nl2Br( $text )

    {

      $text = preg_replace("/(\015\012)|(\015)|(\012)/","<br />",$text);

      if( $this->nbsp ) {

        $patterns = array( '  ' , '\"' ) ;

        $replaces = array( ' &nbsp;' , '"' ) ;

        $text = substr(preg_replace_callback('/\>.*\</sU', function ($matches) use ($patterns, $replaces) {
          return str_replace($patterns, $replaces, $matches[0]);
        }, ">$text<"), 1, -1);

      }

      return $text ;

    }




    public function htmlSpecialChars($text, $quote_style = null, $charset = null, $double_encode = true)

    {

      return htmlspecialchars((string) $text, $quote_style === null ? ENT_QUOTES : $quote_style, $charset ?: (defined('_CHARSET') ? _CHARSET : 'UTF-8'), $double_encode);

      //return preg_replace("/&amp;/i", '&', htmlspecialchars($text, ENT_QUOTES));

      // return preg_replace(array("/&amp;/i", "/&nbsp;/i"), array('&', '&amp;nbsp;'), htmlspecialchars($text, ENT_QUOTES));

    }




  }



}



?>