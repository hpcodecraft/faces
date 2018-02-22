<?php

  class RSS {

    private $_dom;
    private $_channel;

    public function __construct( $encoding = 'UTF-8', $XMLVersion = '1.0', $RSSVersion = '2.0' ) {
      $this->_dom = new DOMDocument( $XMLVersion, $encoding );
      $this->_dom->formatOutput = true;

      $root = $this->_dom->createElement('rss');
      $root->setAttribute('version', $RSSVersion );
      $this->_dom->appendChild($root);

      $this->_channel = $this->_dom->createElement('channel');
      $root->appendChild($this->_channel);
    }

    public function setMeta( $feedTitle, $feedDescription, $feedLink, $feedLanguage = 'en') {

      $meta = $this->_dom->createElement('title', utf8_encode($feedTitle));
      $this->_channel->appendChild($meta);

      $meta = $this->_dom->createElement('description', $feedDescription);
      $this->_channel->appendChild($meta);

      $meta = $this->_dom->createElement('language', utf8_encode($feedLanguage));
      $this->_channel->appendChild($meta);

      $meta = $this->_dom->createElement('link', htmlentities($feedLink));
      $this->_channel->appendChild($meta);

      $meta = $this->_dom->createElement('lastBuildDate', utf8_encode(date("D, j M Y H:i:s ").'GMT'));
      $this->_channel->appendChild($meta);

    }

    public function setLogo( $title, $src, $link ) {
      $logo = $this->_dom->createElement('image');
      $this->_channel->appendChild($logo);

      $sub = $this->_dom->createElement('title', utf8_encode($title));
      $logo->appendChild($sub);

      $sub = $this->_dom->createElement('url', htmlentities($src));
      $logo->appendChild($sub);

      $sub = $this->_dom->createElement('link', htmlentities($link));
      $logo->appendChild($sub);
    }

    public function addItem( $title, $body, $link, $date, $guid, $enclosure, $length ) {
      $item = $this->_dom->createElement('item');
      $this->_channel->appendChild($item);

      $data = $this->_dom->createElement('title', utf8_encode($title));
      $item->appendChild($data);

      $data = $this->_dom->createElement('description', utf8_encode($body));
      $item->appendChild($data);

      $data = $this->_dom->createElement('link', htmlentities($link));
      $item->appendChild($data);

      $data = $this->_dom->createElement('pubDate', utf8_encode($date));
      $item->appendChild($data);

      $data = $this->_dom->createElement('guid', htmlentities($guid));
      $data->setAttribute('isPermaLink', 'true');
      $item->appendChild($data);

      $data = $this->_dom->createElement('enclosure', htmlentities($enclosure));
      $data->setAttribute('type', $this->getEnclosureMimeType( $enclosure ));
      $data->setAttribute('url', $enclosure);
      $data->setAttribute('length', $length);
      $item->appendChild($data);
    }

    public function save( $file = 'rss.xml' ) {
      $this->_dom->save( $file );
    }

    public function xml() {
      return $this->_dom->saveXML();
    }

    private function getEnclosureMimeType( $enclosure ) {
      $temp = explode('.', $enclosure );
      $mime = array_pop( $temp );

      switch( $mime ) {
        case 'png':
        case 'gif':
          return 'image/'.$mime;

        case 'jpeg':
        case 'jpg':
          return 'image/jpeg';

        default: break;
      }
    }
  }

?>