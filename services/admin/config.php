<h3><?php echo $errors ?></h3>
<form method="post">
    <textarea class="form-control" name="config" rows="30" style="width: 100%"><?php echo $config; ?></textarea><br/>
    <input type="hidden" name="landing_page" value="config">
    <button type="submit" class="btn btn-primary">Save</button>
</form>

