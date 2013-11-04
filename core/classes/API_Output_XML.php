<?php

  class API_Output_XML {

    public function handle( $data ) {
      header('Cache-Control: no-cache, must-revalidate');
      header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
      header ("Content-Type:text/xml");

      $xml = '<?xml version="1.0" encoding="utf-8"?><response>';

      foreach( $data as $k => $v ) {
        if( !is_array( $v )) {
          $xml.= '<'.$k.'>'.$v.'</'.$k.'>';
        }
        else { // sublevel
          $xml.= '<'.$k.'>';

          foreach( $v as $i ) {
            $xml.='<item>';
            foreach( $i as $sk => $sv ) {
            $xml.= '<'.$sk.'>'.$sv.'</'.$sk.'>';
            }
            $xml.='</item>';
          }

          $xml.= '</'.$k.'>';
        }
      }

      $xml.= '</response>';

      echo $xml;
    }
  }

?>