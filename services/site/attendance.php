<?php ?>
	  <h3><?php echo $errors ?></h3>
      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">TicKTocK Attendace Form</h2>
	    <select class="js-data-example-ajax input-block-level form-control" name="username" placeholder="Username" required>
	      <option value="0" selected="selected">Username</option>
	    </select>
	    <hr/>
        <input type="hidden" class="input-block-level" value="IN" required>
        <button class="btn btn-large btn-primary" type="submit">Check-in</button>
        <button class="btn btn-large btn-primary" type="submit" onclick="alert('Feature is coming soon!'); return false;">Check-out</button>
      </form>
