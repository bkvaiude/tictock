<form class="form-inline">
    <input type="text" class="form-control" name="last_x_days" placeholder="Search for last X days" value="<?php echo $_GET['last_x_days']; ?>">
    <input type="hidden" name="landing_page" value="department">
    <input type="hidden" name="department" value="<?php echo $_GET['department']; ?>">
    <button type="submit" class="btn btn-primary">Search</button>
</form>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Full Name</th>
        <th>Department</th>
        <th>AVG IN Time</th>
      </tr>
    </thead>
    <tbody>

<?php
		foreach ($profileData as $item) {
			$warningClass = $item['status']== LATE ? 'alert-danger' : 'success';
?>
      <tr class="<?php echo $warningClass; ?>">
        <td><a href="admin.php?landing_page=profile&username=<?php echo $item['username']; ?>"><?php echo $item['fullname']; ?></a></td>
        <td><?php echo $item['department']; ?></td>
        <td><?php echo $item['avg_time']; ?></td>
      </tr>

<?php
		}
?>


    </tbody>
  </table>
