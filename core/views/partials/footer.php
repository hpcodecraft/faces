        </section>

    <!--<section class="sidebar"></section>-->

  </div>

  <?php if( $view == 'single') require_once('views/single-meta.php'); ?>

  <footer>
    <ul>
      <li>
        <b><?=number_format( $stats['total_views'], 0, ',', '.').' '.t('face-plural')?> viewed</b>
      </li>
      <li>
        <b><?=$stats['total_faces'].' '.t('face-plural')?> stored</b>
      </li>
      <?php if( isset( $_CONFIG['flattr'] ) and strlen( $_CONFIG['flattr'] ) > 0 ): ?>
      <li>&nbsp;</li>
      <li>
        <a class="FlattrButton" style="display:none;" rev="flattr;button:compact;" href="<?=$_CONFIG['baseurl']?>"></a>
        <noscript><a href="<?=$_CONFIG['flattr']?>" target="_blank">
        <img src="http://api.flattr.com/button/flattr-badge-large.png" alt="Flattr this" title="Flattr this" border="0" /></a></noscript>
      </li>
      <?php endif; ?>
    </ul>
  </footer>

  <!-- JS -->
  <script src="<?=$_CONFIG['baseurl']?>/core/js/min/app-min.js"></script>

  <?php if( isset($_COOKIE[ $_CONFIG['cookie'] ] )): ?>

  <script>
    var cookie = <?=stripslashes( $_COOKIE[ $_CONFIG['cookie'] ] )?>;
  </script>

  <?php endif; ?>

  <script>
    var app  = <?=stripslashes(json_encode($_CONFIG))?>;
    var view = '<?=$view?>';
    var Face = <?=json_encode($faces)?>;
  </script>

  <?php if( $view == 'single' ): ?>
  <script>
    var prev = <?=$prev?>;
    var next = <?=$next?>;
  </script>
  <?php endif; ?>

  <?php if( isset( $_CONFIG['flattr'] ) and strlen( $_CONFIG['flattr'] ) > 0 ): ?>
  <script>
      (function() {
  	var s = document.createElement("script"), t = document.getElementsByTagName("script")[0];
  	s.type = "text/javascript";
  	s.async = true;
  	s.src = "http://api.flattr.com/js/0.6/load.js?mode=auto";
  	t.parentNode.insertBefore(s, t);
      })();
  </script>
  <?php endif; ?>

  <?php if( isset( $_CONFIG['analytics'] ) and strlen( $_CONFIG['analytics'] ) > 0 ): ?>
  <script>
      var _gaq = _gaq || [];
      _gaq.push(["_setAccount", "<?=$_CONFIG['analytics']?>"]);
      _gaq.push(["_trackPageview"]);

      (function() {
  	var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
  	ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
  	var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
      })();
  </script>
  <?php endif; ?>
</body>
</html>