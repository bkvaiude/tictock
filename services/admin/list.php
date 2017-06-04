<form class="form-inline">
    <input type="text" class="form-control" name="last_x_days" placeholder="Search for last X days" value="<?php echo $_GET['last_x_days']; ?>">
    <input type="text" class="form-control" name="search_key" placeholder="Search Keyword" value="<?php echo $_GET['search_key']; ?>">
    <input type="hidden" name="page" value="1">
    <input type="hidden" name="landing_page" value="list">
    <button type="submit" class="btn btn-primary">Search</button>
</form>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Full Name</th>
        <th>Department</th>
        <th>Date</th>
        <th>In Time</th>
      </tr>
    </thead>
    <tbody>

<?php
		foreach ($pagination->getItems() as $item) {
			$warningClass = $item['status']== LATE ? 'alert-danger' : 'success';
?>
      <tr class="<?php echo $warningClass; ?>">
        <td><a href="admin.php?landing_page=profile&username=<?php echo $item['username']; ?>"><?php echo $item['fullname']; ?></a></td>
        <td><a href="admin.php?landing_page=department&department=<?php echo $item['department']; ?>"><?php echo $item['department']; ?></a></td>
        <td><?php echo $item['logging_date']; ?></td>
        <td><?php echo $item['time_info']; ?></td>
      </tr>

<?php
		}
?>


    </tbody>
  </table>
<nav aria-label="Page navigation" class="pagination">
 <ul>
<?php	
	// Let's build a basic page navigation structure
		foreach ($pagination->getPages() as $page) {
			$activeClass = $page == $_GET['page'] ? "active" : "";
		    echo '<li class="'.$activeClass.'"><a  href="admin.php?landing_page=list&page=' . $page . '&search_key=' . $_GET['search_key'] . '&last_x_days=' . $_GET['last_x_days'] . '">' . $page . '</a></li>';
		}
?>
</ul>
</nav>