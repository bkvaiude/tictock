<form class="form-inline">
    <input type="text" class="form-control" name="last_x_days" placeholder="Search for last X days" value="<?php echo $_GET['last_x_days']; ?>">
    <input type="hidden" name="landing_page" value="profile">
    <input type="hidden" name="username" value="<?php echo $_GET['username']; ?>">
    <button type="submit" class="btn btn-primary">Search</button>
</form>

<table class="table table-hover">
<tbody>
  <tr>
    <td>Name</td><td><?php echo $profileData['fullname']; ?></td>
  </tr>
  <tr>
    <td>Department</td><td><a href="admin.php?landing_page=department&department=<?php echo $profileData['department']; ?>"><?php echo $profileData['department']; ?></a></td>
  </tr>
  <tr>
    <td>AVG IN Time (For the selected time period)</td><td><?php echo $profileData['avg_time']; ?></td>
  </tr>
</tbody>
</table>
