<?php if( $conf->submissions != 1 ) : ?>
<h3>
	Sorry, submissions are disabled at the moment.<br/>
	Please come back later and try again.
</h3>

<?php else : ?>
<h1>Submit a <?=$_CONFIG['app']['face']?></h1>

<p>
		Here you can upload a new <?=$_CONFIG['app']['face']?>face.<br/>
		It will be reviewed and (most likely) be published on the site as soon as possible.
		You can help making the review easier (thus having your image published faster) if you consider these three rules of thumb:
</p>

<h3>1. It's hip to be square</h3>
<p>
	Whenever possible, make your image square. Square images fit into the page layout perfectly, and not having to download, crop and re-upload the submitted image saves me a lot of time.
</p>

<h3>2. Size DOES matter</h3>
<p>
	Please scale down huge images before uploading them. 500x500 pixels is about the size your image should be (in fact, square images bigger than this are scaled down during review).
</p>

<h3>3. Thou shalt not upload images of Jimmy Wales.</h3>
<p>
  Really, you shouldn't.
</p>

<form method="POST" action="submit" enctype="multipart/form-data">
	<ul>
		<li>
			<label for="submit_file">Choose a file (<?=implode(', ', $allowed)?> allowed)</label>
			<input type="file" id="submit_file" name="submit_file" class="bglight dark bordermedium" />
		</li>
		<li>
			<label for="submit_tags">Your tag suggestions (comma-seperated, e.g. "angry, rage")</label>
			<input type="text" id="submit_tags" name="submit_tags" class="bglight dark bordermedium" />
		</li>
		<li>
			<button type="submit" name="submit" class="bglight dark shadow">submit</button>
		</li>
		<?php if( $msg != null ): ?>
		<li class="dark">
			<?=$msg?>
		</li>
		<?php endif; ?>
	</ul>
</form>
<?php endif; ?>