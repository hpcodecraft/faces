<?php

  class API_Output_XML {

    public function handle( $data ) {
      header('Cache-Control: no-cache, must-revalidate');
      header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
      header ("Content-Type:text/xml");

      // function to convert an array to XML using SimpleXML
      function array_to_xml($array, &$xml) {
        foreach($array as $key => $value) {
          if(is_array($value)) {
            if(!is_numeric($key)){
              $subnode = $xml->addChild($key);
              array_to_xml($value, $subnode);
            } else {
              $subnode = $xml->addChild('item_'.$key);
              array_to_xml($value, $subnode);
            }
          } else {
            if(!is_numeric($key)){
              $xml->addChild($key, $value);
            }
            else {
             $xml->addChild('item_'.$key, $value);
            }
          }
        }
      }

      // create simpleXML object
      $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><response></response>");
      $node = $xml[0];

      // function call to convert array to xml
      array_to_xml($data, $node);

      // display XML to screen
      echo $xml->asXML();
    }
  }
?>