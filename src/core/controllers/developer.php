<?php
function callAPI($query) {
  global $_CONFIG, $view;
  $formats = array(
    'json' => '',
    'jsonp' => ':myJSONPcallback',
    'xml' => '',
  );

  $html = '<div class="api-call"><div class="api-formats">';

  foreach($formats as $format => $appendix) {
    if($format == 'json') $html.= '<button class="format active" data-format="'.$format.'">'.strtoupper($format).'</button>';
    else $html.= '<button class="format" data-format="'.$format.'">'.strtoupper($format).'</button>';
  }

  $html.= '</div>';

  foreach($formats as $format => $appendix) {

    $requestUrl = $_CONFIG['baseurl'].'/api.'.$format.$appendix.'/'.$query;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $requestUrl); // Set URL
    curl_setopt($ch, CURLOPT_REFERER, $_CONFIG['baseurl'].'/'.$view); // Set a referer
    curl_setopt($ch, CURLOPT_HEADER, 0); // Include header in result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return or print out the data? (true = return, false = print)
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout in seconds
    curl_setopt($ch, CURLOPT_CRLF, true);
    $output = curl_exec($ch); // Download the given URL, and return output
    curl_close($ch);

    $html.= '
      <div class="api-result '.$format.'">
        Requested URL: <a href="'.$requestUrl.'">'.$requestUrl.'</a><br>
        Response in '.strtoupper($format).' format:<br>
        <pre><code>'.htmlentities($output).'</code></pre>
      </div>
    ';
  }

  $html.= '</div>';
  return $html;
}
?>