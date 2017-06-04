<h3><?php echo $errors ?></h3>
<?php
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"),true);
?>
<pre>
	<?php print_r($details); ?>
</pre>
<form method="post">
    <textarea class="form-control" name="config" rows="30" style="width: 100%"><?php echo $config; ?></textarea><br/>
    <input type="hidden" name="landing_page" value="config">
    <button type="submit" class="btn btn-primary">Save</button>
</form>

