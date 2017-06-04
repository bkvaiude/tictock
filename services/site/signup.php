<?php ?>
		<h3><?php echo $errors ?></h3>
      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">TicKTocK Registration Form</h2>
        <input type="text" class="input-block-level" placeholder="Username" name="username" required>
        <input type="text" class="input-block-level" placeholder="Full Name" name="fullname" required>
        <input type="text" class="input-block-level" placeholder="Department" name="department" required>
        <button class="btn btn-large btn-primary" type="submit">Sign in</button><a class="btn btn-large" href="/?page=attendance"> Go for check-in </a>
      </form>