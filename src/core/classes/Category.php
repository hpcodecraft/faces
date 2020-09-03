<?php

class Category {
  public $id;
  public $name;
  public $weight;

  public function __construct( $id, $name, $weight ) {
    $this->id     = $id;
    $this->name   = $name;
    $this->weight = $weight;
  }

  static public function add( $args ) {
    if( $_SESSION['admin'] !== true ) return false;

    global $db;
    // get max weight
    $sql = "SELECT MAX(weight)+1 FROM categories";
    $rs = mysqli_query( $db, $sql );
    $weight = mysqli_fetch_field( $rs );
    // save new category
    $sql = "INSERT INTO categories (id, name, weight) VALUES (null, '".$args['name']."', ".$weight.")";
    $rs = mysqli_query( $db, $sql );
    $id = mysqli_insert_id();

    if( mysqli_affected_rows() == 1 ) {
      $args['success'] = true;
      $args['msg'] = 'Added category "'.$args['name'].'".';
      $args['id'] = $id;
      $args['weight'] = $weight;
    }
    else {
      $args['success'] = false;
      $args['msg'] = 'Adding category "'.$args['name'].'" failed.';
    }
    return $args;
  }

  static public function setName( $args ) {
    if( $_SESSION['admin'] !== true ) return false;

    global $db;
    $sql = "UPDATE categories SET name='".$args['name']."' WHERE id=".$args['id'];
    $rs = mysqli_query( $db, $sql );

    if( mysqli_affected_rows() == 1 ) {
      $args['success'] = true;
      $args['msg'] = 'Saved new category name "'.$args['name'].'".';
    }
    else {
      $args['success'] = false;
      $args['msg'] = 'Saving new category name "'.$args['name'].'" failed.';
    }

    return $args;
  }

  static public function remove( $args ) {
    if( $_SESSION['admin'] !== true ) return false;

    global $db;
    $sql = "DELETE FROM categories WHERE id=".$args['id'];
    $rs = mysqli_query( $db, $sql );

    if( mysqli_affected_rows() == 1 ) {
      $args['success'] = true;
      $args['msg'] = 'Deleted category "'.$args['name'].'".';
    }
    else {
      $args['success'] = false;
      $args['msg'] = 'Deleting category "'.$args['name'].'" failed.';
    }

    return $args;
  }

  static public function up( $args ) {
    if( $_SESSION['admin'] !== true ) return false;

    $id = (int)$args['id'];

    global $db;
    // select weight of category
    $sql = "SELECT weight FROM categories WHERE id=".$id;
    $rs = mysqli_query( $db, $sql );
    $weight = mysqli_fetch_field( $rs );


    // select weight of prior category
    $sql = "SELECT id, weight FROM categories WHERE weight<(SELECT weight FROM categories WHERE id=".$id.") ORDER BY weight DESC LIMIT 0,1";
    $rs = mysqli_query( $db, $sql );
    $changeWith = mysqli_fetch_assoc( $rs );

    // switch weights
    $sql = "UPDATE categories SET weight=".$weight." WHERE id=".$changeWith['id'];
    $rs = mysqli_query( $db, $sql );

    $sql = "UPDATE categories SET weight=".$changeWith['weight']." WHERE id=".$id;
    $rs = mysqli_query( $db, $sql );

    $tmp = $weight;
    $weight = $changeWith['weight'];
    $changeWith['weight'] = $tmp;

    $args['weight'] = $weight;
    $args['changed'] = $changeWith;

    $args['success'] = true;
    $args['msg'] = 'Moved category up.';

    return $args;
  }

  static public function down( $args ) {
    if( $_SESSION['admin'] !== true ) return false;

    $id = (int)$args['id'];

    global $db;
    // select weight of category
    $sql = "SELECT weight FROM categories WHERE id=".$id;
    $rs = mysqli_query( $db, $sql );
    $weight = mysqli_fetch_field( $rs );


    // select weight of next category
    $sql = "SELECT id, weight FROM categories WHERE weight>(SELECT weight FROM categories WHERE id=".$id.") ORDER BY weight ASC LIMIT 0,1";
    $rs = mysqli_query( $db, $sql );
    $changeWith = mysqli_fetch_assoc( $rs );

    // switch weights
    $sql = "UPDATE categories SET weight=".$weight." WHERE id=".$changeWith['id'];
    $rs = mysqli_query( $db, $sql );

    $sql = "UPDATE categories SET weight=".$changeWith['weight']." WHERE id=".$id;
    $rs = mysqli_query( $db, $sql );

    $tmp = $weight;
    $weight = $changeWith['weight'];
    $changeWith['weight'] = $tmp;

    $args['weight'] = $weight;
    $args['changed'] = $changeWith;

    $args['success'] = true;
    $args['msg'] = 'Moved category down.';

    return $args;
  }
}
?>
