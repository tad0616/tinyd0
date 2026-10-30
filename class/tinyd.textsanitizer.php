<?php

if( ! class_exists( 'TinyDTextSanitizer' ) ) {

  include_once( XOOPS_ROOT_PATH . '/class/module.textsanitizer.php' ) ;

  class TinyDTextSanitizer extends MyTextSanitizer {

    var $nbsp = 0 ;

    function TinyDTextSanitizer()
    {
      //parent::MyTextSanitizer() ;
    }


    static function &getInstance()
    {
      static $instance;
      if (!isset($instance)) {
        $instance = new TinyDTextSanitizer();
      }
      return $instance;
    }



    function displayTarea( $text, $html = 0, $smiley = 1, $xcode = 1, $image = 1, $br = 1 , $nbsp = 0 )
    {

      $text = preg_replace( "/javascript:/si" , "jjaavvaassccrriipptt::" , $text ) ;
      $this->nbsp = $nbsp ;
      $text = parent::displayTarea( $text , $html , $smiley , $xcode , $image , $br ) ;
      $text = preg_replace( "/jjaavvaassccrriipptt::/" , "javascript:" , $text ) ;
      return $this->tinyDCodeDecode( $text , $nbsp ) ;
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



    function &nl2Br( $text )

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




    function htmlSpecialChars($text)

    {

      return htmlspecialchars($text, ENT_QUOTES);

      //return preg_replace("/&amp;/i", '&', htmlspecialchars($text, ENT_QUOTES));

      // return preg_replace(array("/&amp;/i", "/&nbsp;/i"), array('&', '&amp;nbsp;'), htmlspecialchars($text, ENT_QUOTES));

    }




  }



}



?>