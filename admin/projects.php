<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( isset( $_GET['delete'] ) )
{
  
  $query = 'DELETE FROM projects
    WHERE id = '.$_GET['delete'].'
    LIMIT 1';
  mysqli_query( $connect, $query );
    
  set_message( 'Project has been deleted' );
  
  header( 'Location: projects.php' );
  die();
  
}

include( 'includes/header.php' );

$query = 'SELECT *
  FROM projects
  ORDER BY date DESC';
$result = mysqli_query( $connect, $query );

?>

<h2>Manage Projects</h2>

<table>
  <tr>
    <th></th>
    <th align="center">ID</th>
    <th align="left">Title</th>
    <th align="center">Type</th>
    <th align="center">Date</th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
  <?php while( $record = mysqli_fetch_assoc( $result ) ): ?>
    <tr>
      <td align="center">
        <img src="image.php?type=project&id=<?php echo $record['id']; ?>&width=300&height=300&format=inside">
      </td>
      <td align="center"><?php echo $record['id']; ?></td>
      <td align="left">
        <?php echo htmlentities( $record['title'] ); ?>
        <small><?php echo $record['content']; ?></small>
      </td>
      <td align="center"><?php echo $record['type']; ?></td>
      <td align="center" style="white-space: nowrap;"><?php echo htmlentities( $record['date'] ); ?></td>
      <td align="center"><a href="projects_photo.php?id=<?php echo $record['id']; ?>">Photo</i></a></td>
      <td align="center"><a href="projects_edit.php?id=<?php echo $record['id']; ?>">Edit</i></a></td>
      <td>
        <button class="delete-button" data-id="<?php echo $record['id'];?>" data-title="<?php echo $record['title'];?>">Delete</button>
      </td>
      </tr>
  <?php endwhile; ?>
</table>

<p><a href="projects_add.php"><i class="fas fa-plus-square"></i> Add Project</a></p>


<?php

include( 'includes/footer.php' );

?>

<script type="text/JavaScript">
let deleteButtons = document.getElementsByClassName("delete-button")
if (deleteButtons && deleteButtons.length > 0) {
  for (let button of deleteButtons) {
    button.onclick = () => {
      let confirmedDelete = confirm(`Are you sure you want to delete ${button.dataset.title}?`);
      if (!confirmedDelete) return;
      window.location.href = `projects.php?delete=${button.dataset.id}`;
    }
  }
};
</script>