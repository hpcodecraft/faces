<table id="logtable">
  <tr>
    <th>time</th>
    <th>ip</th>
    <th>query</th>
  </tr>
  <?php foreach( $log['api'] as $l ): ?>
  <tr>
    <td><?=date('d.m.Y, H:i:s', $l['time'] )?></td>
    <td><?=$l['ip']?></td>
    <td><?=$l['query']?></td>
  </tr>
  <?php endforeach; ?>
</table>