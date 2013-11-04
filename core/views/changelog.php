<h1>changelog</h1>
<ul>
  <?php
    $sql = "SELECT id, posted, content FROM changelog ORDER BY posted DESC";
    $rs = mysql_query( $sql, $db );
    while( $row = mysql_fetch_assoc( $rs )) {

    $d = date( 'Y-m-d', $row['posted'] );
  ?>

  <li>
    <a name="<?=$d?>"><b><?=$d?></b></a>
    <ul>
      <li><?=str_replace("\n", "</li><li>", $row['content'])?></li>
    </ul>
  </li>

  <?php
    }
  ?>
</ul>