<?php ?>
	  <h3><?php echo $errors ?></h3>
      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">TicKTocK Attendace Form</h2>
        <input type="text" class="input-block-level" placeholder="Username" name="username" required>
        <input type="hidden" class="input-block-level" placeholder="Username" name="type" value="IN" required>
        <button class="btn btn-large btn-primary" type="submit">Check-in</button>
        <button class="btn btn-large btn-primary" type="submit" onclick="alert('Feature is coming soon!'); return false;">Check-out</button>
      </form>