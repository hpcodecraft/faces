<ul>
	<li><h1><?=$_CONFIG['app']['domain']?> - API Reference</h1></li>
	<li>
		<h2>Before you read on</h2>
		<ul>
			<li>
				If you already have the number/id of a face and only want to display the image in your client, you don't need to use the API at all.
				Just add <b>/full</b> (for the full-sized image) or /<b>thumb</b> (for the thumbnail) to its URL to get it.
			</li>
			<li>Example:</li>
			<li><a target="_blank" href="<?=$_CONFIG['baseurl']?>/1/full"><?=$_CONFIG['baseurl']?>/1/full</a></li>
			<li><a target="_blank" href="<?=$_CONFIG['baseurl']?>/1/thumb"><?=$_CONFIG['baseurl']?>/1/thumb</a></li>
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
				<?php if( $_CONFIG['app']['face'] != 'pony' ): ?>
				<li>
					<h3>Note: All code samples listed here are taken from <a href="http://ponyfac.es" target="_blank">ponyfac.es</a>.</h3>
					So don't be confused about the values, the API itself is identical on both sites.
				</li>
				<?php endif; ?>
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

							<li><label>total_faces</label>total amount of stored faces on <?=$_CONFIG['app']['domain']?></li>
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

	<li>
		<h2><a name="examples"></a>Examples</h2>
			<ul>
				<li>
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
				</li>

				<li>
					<h3 id="example2">Example 2</h3>
					Requested URL: <b><a href="<?=$_CONFIG['baseurl']?>/api/id/23,42"><?=$_CONFIG['baseurl']?>/api/id/23,42</a></b>
					&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/id/23,42&callback=myJSONPcallback" target="_blank">JSONP</a>
					&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/id/23,42&out=xml" target="_blank">XML</a><br/>
					JSON-response:
					<pre>{
  "unix_date":1311462567,
  "total_faces":"50",
  "total_views":"1234",
  "items":[
    {
      "face_id":"23",
      "face_views":"10",
      "face_hidden":0,
      "face_category":"twilight sparkle",
      "face_filename":"88ef730a",
      "face_url":"http://ponyfac.es/faces/88ef730a.jpg",
      "face_tags":"twilight sparkle",
      "face_thumbnail":"http://ponyfac.es/thumbs/thumb_120_88ef730a.png"
    },
    {
      "face_id":"42",
      "face_views":"20",
      "face_hidden":0,
      "face_category":"fluttershy",
      "face_filename":"182465be",
      "face_url":"http://ponyfac.es/faces/182465be.jpg",
      "face_tags":"fluttershy",
      "face_thumbnail":"http://ponyfac.es/thumbs/thumb_120_182465be.png"
    }
  ]
}</pre>
				</li>

				<li>
					<h3 id="example3">Example 3</h3>
					Requested URL: <b><a href="<?=$_CONFIG['baseurl']?>/api/tag/happy"><?=$_CONFIG['baseurl']?>/api/tag/happy</a></b>
					&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/tag/happy&callback=myJSONPcallback" target="_blank">JSONP</a>
					&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/tag/happy&out=xml" target="_blank">XML</a><br/>
					JSON-response:
					<pre>{
  "unix_date":1311463199,
  "total_faces":"50",
  "total_views":"1234",
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
    },
    {
      "face_id":"3",
      "face_views":"16",
      "face_hidden":0,
      "face_category":"rainbow dash",
      "face_filename":"80b6d653",
      "face_url":"http://ponyfac.es/faces/80b6d653.gif",
      "face_tags":"rainbow dash, happy, lol",
      "face_thumbnail":"http://ponyfac.es/thumbs/thumb_120_80b6d653.png"
    },
    {
      "face_id":"12",
      "face_views":"4",
      "face_hidden":0,
      "face_category":"fluttershy",
      "face_filename":"a476808d",
      "face_url":"http://ponyfac.es/faces/a476808d.png",
      "face_tags":"fluttershy, happy",
      "face_thumbnail":"http://ponyfac.es/thumbs/thumb_120_a476808d.png"
    }
  ]
}</pre>
				</li>

				<li>
					<h3 id="example4">Example 4</h3>
					Requested URL: <b><a href="<?=$_CONFIG['baseurl']?>/api/cat/fluttershy"><?=$_CONFIG['baseurl']?>/api/cat/fluttershy</a></b>
					&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/cat/fluttershy&callback=myJSONPcallback" target="_blank">JSONP</a>
					&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/cat/fluttershy&out=xml" target="_blank">XML</a><br/>
					JSON-response:
					<pre>{
  "unix_date":1311464018,
  "total_faces":"50",
  "total_views":"1234",
  "items":[
    {
      "face_id":"12",
      "face_views":"4",
      "face_hidden":0,
      "face_category":"fluttershy",
      "face_filename":"a476808d",
      "face_url":"http://ponyfac.es/faces/a476808d.png",
      "face_tags":"fluttershy, happy",
      "face_thumbnail":"http://ponyfac.es/thumbs/thumb_120_a476808d.png"
    },
    {
      "face_id":"14",
      "face_views":"27",
      "face_hidden":0,
      "face_category":"fluttershy",
      "face_filename":"2612bf13",
      "face_url":"http://ponyfac.es/faces/2612bf13.jpg",
      "face_tags":"fluttershy",
      "face_thumbnail":"http://ponyfac.es/thumbs/thumb_120_a476808d.png"
    }
  ]
}</pre>
	</li>

	<li>
		<h3 id="example5">Example 5</h3>
		Requested URL: <b><a href="<?=$_CONFIG['baseurl']?>/api/all/cats"><?=$_CONFIG['baseurl']?>/api/all/cats</a></b>
		&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/all/cats&callback=myJSONPcallback" target="_blank">JSONP</a>
		&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/all/cats&out=xml" target="_blank">XML</a><br/>
		JSON-response:
		<pre>{
  "unix_date":1311612197,
  "items":[
    {
      "cat_id":1,
      "cat_name":"all",
      "cat_displayname":"All Ponies"
    },
    {
      "cat_id":2,
      "cat_name":"rainbowdash",
      "cat_displayname":"Rainbow Dash"
    },
    <b>[...]</b>
    {
      "cat_id":8,
      "cat_name":"other",
      "cat_displayname":"Other Ponies"
    }
  ]
}</pre>
		Explained JSON-response:
		<ul>
			<li><label>unix_date</label>unix timestamp of the response</li>
			<li><label>items</label>array holding all categories</li>
			<li><label>&nbsp;→ cat_id</label>unique ID of the category</li>
			<li><label>&nbsp;→ cat_name</label>lowercase category name without spaces.</li>
			<li><label>&nbsp;→ cat_displayname</label>full name of the category with spaces and other special characters</li>
		</ul>
	</li>

	<li>
		<h3 id="example6">Example 6</h3>
		Requested URL: <b><a href="<?=$_CONFIG['baseurl']?>/api/all/tags"><?=$_CONFIG['baseurl']?>/api/all/tags</a></b>
		&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/all/tags&callback=myJSONPcallback" target="_blank">JSONP</a>
		&nbsp;<a href="<?=$_CONFIG['baseurl']?>/api/all/tags&out=xml" target="_blank">XML</a><br/>
		JSON-response:
		<pre>{
  "unix_date":1311612476,
  "items":[
    {"tag_name":"pinkie pie"},
    {"tag_name":"happy"},
    {"tag_name":"clap"},
    {"tag_name":"sweetie belle"},
    {"tag_name":"tongue"},
    {"tag_name":"taunt"},
    {"tag_name":"tease"},
    {"tag_name":"rainbow dash"},
    {"tag_name":"lol"}
  ]
}</pre>
		Explained JSON-response:
		<ul>
			<li><label>unix_date</label>unix timestamp of the response</li>
			<li><label>items</label>array holding all tags</li>
			<li><label>&nbsp;→ tag_name</label>lowercase tag name.</li>
		</ul>
	</li>
</ul>