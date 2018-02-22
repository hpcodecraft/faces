<h2><?=t('site-name')?> - API Reference</h2>

<h3>Before you read on</h3>
<p>
  If you only want to display the image in your client and already have the number/id of a face, you don't need to use the API at all.
  Just add <b>/full</b> (for the full-sized image) or /<b>thumb</b> (for the thumbnail) to its URL to get it.
</p>
<p>
  Example:<br>
  <a target="_blank" href="<?=$_CONFIG['baseurl']?>/1/full"><?=$_CONFIG['baseurl']?>/1/full</a><br>
  <a target="_blank" href="<?=$_CONFIG['baseurl']?>/1/thumb"><?=$_CONFIG['baseurl']?>/1/thumb</a>
</p>

<h3>How to use the API</h3>
<p>
  A typical API call looks like this:<br>
  <strong><span style="color:limegreen;"><?=$_CONFIG['baseurl']?>/api</span>.<span style="color:red;">json</span>/<span style="color:orange;">tag</span><span style="color:magenta;">:happy</span></strong>
</p>

<h3>The URL parts explained:</h3>
<p style="color:limegreen;">The API endpoint URL. It always stays the same, just copy it from above.</p>
<p>
  <ul style="color:red;">
    <li>The output format. Valid formats are:</li>
    <li>json - Returns JSON data</li>
    <li>xml - Returns XML data</li>
    <li>
      jsonp - Returns JSON data wrapped into a callback function. If you want to use JSONP you'll also have to add the callback functions name like so:<br>
      <?=$_CONFIG['baseurl']?>/api.jsonp:myJSONPcallback/tag:happy
    </li>
  </ul>
</p>
<p>
  <ul style="color:orange;">
    <li>The API command. Valid commands are:</li>
    <li>id - Get one or more faces by their ids</li>
    <li>tag - Get all faces matching a tag</li>
    <li>tags - Get a list of all available tags</li>
    <li>category - Get all faces in a category</li>
    <li>categories - Get a list of all available categories</li>
  </ul>
</p>
<p style="color:magenta;">
  The URL parameter, depending on the command. Not every command needs a parameter - see the examples below for more info.
</p>

<h2>Examples</h2>

<h3>Get data by id</h3>
<p>See the example below to learn how to get a faces data by its id:</p>
<?= callAPI('id:1') ?>
<p>If you want to get data for multiple faces just pass several comma-separated ids like so:</p>
<?= callAPI('id:23,42') ?>

<h3>Get data by tag</h3>
<p>You can also receive all faces that match a given tag. To do so, pass in the tag:</p>
<?= callAPI('tag:happy') ?>

<h3>Get list of all available tags</h3>
<p>Call the URL from the example below to get a list of all available tags:</p>
<?= callAPI('tags') ?>

<h3>Get data by category</h3>
<p>To get all faces in a given category you can pass in a category id:</p>
<?= callAPI('category:1') ?>

<h3>Get list of all available categories</h3>
<p>See the example below to learn how to get a list of all categories:</p>
<?= callAPI('categories') ?>





<!--
<h3 id="example1">Example 1</h3>
Requested URL: <b><a href="<?=$_CONFIG['baseurl']?>/api/id/1"><?=$_CONFIG['baseurl']?>/api/id/1</a></b>
&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/id/1&callback=myJSONPcallback" target="_blank">JSONP</a>
&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/id/1&out=xml" target="_blank">XML</a><br/>
JSON-response:
<pre>{
  "unix_date":1311462196,
  "total_faces":"50",
  "total_views":"123",
  "items":[
    {
      "face_id":"1",
      "face_views":"4",
      "face_hidden":0,
      "face_category":"pinkie pie",
      "face_filename":"3cc43dc9",
      "face_url":"http://ponyfac.es/faces/3cc43dc9.gif",
      "face_tags":"pinkie pie, happy, clap",
      "face_thumbnail":"http://ponyfac.es/thumbs/thumb_120_3cc43dc9.png"
    }
  ]
}</pre>


<ul>
	<li><h1><?=t('site-name')?> - API Reference</h1></li>

  <li>
    <h2>CAUTION!</h2>
    <ul>
      <li>This API will be updated soon with possibily breaking changes, please stay tuned!</li>
    </ul>
  </li>


	<li>
		<h2><a name="overview"></a>Overview</h2>
			<ul>
				<li>The API by default outputs <b>JSON</b> delivering all data about the faces stored at <?=$_CONFIG['baseurl']?></li>
				<li>(JSONP and XML output is also possibe, see below)</li>
				<li>The base URL for fetching data is <b><?=$_CONFIG['baseurl']?>/api/</b></li>
			</ul>
	</li>
	<li>
		<h2><a name="functionality"></a>API Functionality</h2>
			<ul>
				<li>
					<p>There are four ways to get data from the API:</p>
					<ul>
						<li><h3>by id</h3>
							<ul>
								<li>The parameter id returns the face-data for the given id: <a href="#example1">Example 1</a></li>
								<li>It also supports multiple comma-separated values: <a href="#example2">Example 2</a></li>
							</ul>
						</li>
						<li><h3>by tag</h3>
							<ul>
								<li>The parameter tag returns the faces matching a given tag: <a href="#example3">Example 3</a></li>
							</ul>
						</li>
						<li><h3>by category</h3>
							<ul>
								<li>The parameter cat returns the faces matching a given category: <a href="#example4">Example 4</a><br/><br/>
								    Valid categories are:
										<ul>
										<?php
											foreach( $_CONFIG['category'] as $c => $cDesc ) {
												echo '<li>&nbsp;→ '.$c.'</li>';
											}
										?>
										</ul>
								</li>
							</ul>
						</li>
						<li><h3>all</h3>
							<ul>
								<li>The parameter all returns a list of all tags or categories.</li>
								<li>It accepts only two values, "cats" and "tags"</li>
								<li>Get all categories: <a href="#example5">Example 5</a></li>
								<li>Get all tags: <a href="#example6">Example 6</a></li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
	</li>
	<li>
		<h2><a name="response"></a>API Response</h2>
			<ul>
				<li>
					<h3>Typical response</h3>
					<ul>
						<li>By default, the API returns JSON-encoded data, but you can also retrieve JSONP data or XML.</li>
						<li>Compare these API-calls:</li>
						<li>
							<ul>
								<li><b><?=$_CONFIG['baseurl']?>/api/id/1</b>&nbsp;(will output <b>JSON</b>)&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/id/1" target="_blank">see result</a></li>
								<li><b><?=$_CONFIG['baseurl']?>/api/id/1&callback=myJSONPcallback</b>&nbsp;(will output <b>JSONP</b>)&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/id/1&callback=myJSONPcallback" target="_blank">see result</a></li>
								<li><b><?=$_CONFIG['baseurl']?>/api/id/1&out=xml</b>&nbsp;(will output <b>XML</b>)&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/id/1&out=xml" target="_blank">see result</a></li>
							</ul>
						</li>
					</ul>
					All listed examples here are plain JSON, but you'll find links for the JSONP and XML versions along with each example. Comparing the output to JSON should be pretty self-explanatory.<br/><br/>
					A typical JSON-response looks like this:
					<pre>{
  "unix_date":1311461814,
  "total_faces":"50",
  "total_views":"1234",
  "items":[
    {
      "face_id":"4",
      "face_views":"123",
      "face_hidden":0,
      "face_category":"twilight sparkle",
      "face_filename":"573f9ec2",
      "face_url":"http://ponyfac.es/faces/573f9ec2.png",
      "face_tags":"twilight sparkle, happy",
      "face_thumbnail":"http://ponyfac.es/thumbs/thumb_120_573f9ec2.png"
    }
  ]
}</pre>
					<p>
						Explained JSON-response:
						<ul>
							<li><label>unix_date</label>unix timestamp of the response</li>

							<li><label>total_faces</label>total amount of stored faces on <?=t('site-name')?></li>
							<li><label>total_views</label>total amount of views on all single faces</li>
							<li><label>items</label>array of faces</li>

							<li><label>&nbsp;→ face_id</label>ID of the single face</li>
							<li><label>&nbsp;→ face_views</label>page-views of the face</li>

							<li><label>&nbsp;→ face_hidden</label>shows if face is enabled or disabled</li>
							<li><label>&nbsp;→ face_category</label>the category of the face</li>
							<li><label>&nbsp;→ face_filename</label>the base-filename of the single face</li>

							<li><label>&nbsp;→ face_url</label>the absolute path to the fullsized face</li>
							<li><label>&nbsp;→ face_tags</label>the tags associated with the single face</li>
							<li><label>&nbsp;→ face_thumbnail</label>the absolute path to the faces thumbnail image</li>
						</ul>
					</p>
				</li>
			</ul>
	</li>
</ul>
-->