<?php
  define('NO_DISPATCH',true);
  require('bootstrap.php');
  require('views/global/header.php');
?>

      <section class="content protest">
        <?php include('views/protest/'.$conf->{'protest type'}.'.php'); ?>
      </section>
    </div>
  </body>
</html>