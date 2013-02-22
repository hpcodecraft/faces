<h2>manage changelog</h2>
<form action="changelog" method="POST">
  <ul>
    <li class="col">
      <h3>new entry</h3>
      <ul>
        <li>
          <textarea name="changelog-text" placeholder="your text"></textarea>
        </li>
        <li>
          <button type="submit">save</button>
        </li>
      </ul>
    </li>
    <li class="col">
      <h3>current changelog</h3>
      <ul>
        <?php foreach( $log as $l ): ?>
        <li class="margin-bottom">
          <time><?=date('d.m.Y, H:i:s', $l['posted'])?></time>
          <p><?=$l['content']?></p>
        </li>
        <?php endforeach; ?>
      </ul>
    </li>
  </ul>
</form>