<?php

class Image {

  public $source;

  public $dir;
  public $name;
  public $type;
  public $size;

  public $width;
  public $height;

  private $_validTypes = array('image/jpeg','image/gif','image/png');

  public function __construct( $source ) {

    if( filter_var( $source, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED )) {
      // http remote file

    }
    else {
      // local file
      $i = getimagesize( $source );

      if( !in_array( $i['mime'], $this->_validTypes )) {
        throw new Exception('invalid file type');
      }
      else {

        $f = pathinfo( $source );

        $this->source = $source;

        $this->dir  = $f['dirname'];
        $this->name = $f['filename'];
        $this->type = $f['extension'];
        $this->size = filesize( $source );

        $this->width  = $i[0];
        $this->height = $i[1];
      }
    }
  }


  public function createThumbnail( $size, $dir=null ) {

    if( $dir == null ) return false;
    $o = null;

    switch( $this->type ) {
      case 'gif':
        $o = imagecreatefromgif($this->source);
        break;

      case 'png':
        $o = imagecreatefrompng($this->source);
        break;

      case 'jpg':
        $o = imagecreatefromjpeg($this->source);
        break;
    }

    if( $o != null ) {
      $tDim = $this->_getThumbDimensions( $size );
      $t = imagecreatetruecolor( $tDim['width'], $tDim['height'] );
      imageantialias($t,true);

      // preserve transparency
      if($this->type == 'gif' or $this->type == 'png'){
        imagecolortransparent($t, imagecolorallocatealpha($t, 0, 0, 0, 127));
        imagealphablending($t, false);
        imagesavealpha($t, true);
      }

      imagecopyresampled($t, $o, 0, 0, 0, 0, $tDim['width'], $tDim['height'], $this->width, $this->height );

      $dest = $dir.'/thumb_'.$size.'_'.$this->name.'.'.$this->type;

      switch($this->type){
        case 'gif':
          imagegif($t, $dest);
          break;

        case 'png':
          imagepng($t, $dest, 9);
          break;

        case 'jpg':
          imagejpeg($t, $dest, 100);
          break;
      }
    }
  }

  private function _getThumbDimensions( $thumbSize ) {

    $return = array( 'width' => 0, 'height' => 0 );

    if( $this->width > $this->height ) { // resize with width as goal
      $return['width'] = (int)$thumbSize;
      $return['height'] = (int)($thumbSize/$this->width * $this->height);
    }
    else if( $this->width < $this->height ) { // resize with height as goal
      $return['width'] = (int)($thumbSize/$this->height * $this->width);
      $return['height'] = (int)$thumbSize;
    }
    else {
      $return['width'] = (int)$thumbSize;
      $return['height'] = (int)$thumbSize;
    }

    return $return;
  }
}

?>