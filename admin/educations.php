<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( isset( $_GET['delete'] ) )
{
  
  $query = 'DELETE FROM educations
    WHERE id = '.$_GET['delete'].'
    LIMIT 1';
  mysqli_query( $connect, $query );
    
  set_message( 'Education has been deleted' );
  
  header( 'Location: educations.php' );
  die();
  
}

include( 'includes/header.php' );

$query = 'SELECT *
  FROM educations ORDER BY id';
$result = mysqli_query( $connect, $query );

?>

<h2>Manage Educations</h2>

<table>
  <tr>
    <th align="center">ID</th>
    <th align="center">User ID</th>
    <th align="center">School Name</th>
    <th align="center">Location</th>
    <th align="center">Study</th>
    <th align="center">Date</th>
    <th align="center">Content</th>
    <th></th>
    <th></th>
  </tr>
  <?php while( $record = mysqli_fetch_assoc( $result ) ): ?>
    <tr>
      <td align="center"><?php echo $record['id']; ?></td>
      <td align="center"><?php echo $record['user_id']; ?></td>
      <td align="center"><?php echo $record['school_name']; ?></td>
      <td align="center"><?php echo $record['location']; ?></td>
      <td align="center"><?php echo $record['level_of_education']; ?> in <?php echo $record['field']; ?></td>
      <td align="center"><?php echo $record['start_date']; ?> - <?php echo $record['end_date']; ?></td>
      <td align="center">
        <small><?php echo $record['content']; ?></small>
      </td>
      <td align="center"><a href="educations_edit.php?id=<?php echo $record['id']; ?>">Edit</i></a></td>
      <td align="center">
        <button class="delete-button" data-id="<?php echo $record['id'];?>" data-education="<?php echo $record['school_name'];?>">Delete</button>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

<p><a href="educations_add.php"><i class="fas fa-plus-square"></i> Add Education</a></p>


<?php

include( 'includes/footer.php' );

?>

<script type="text/JavaScript">
let deleteButtons = document.getElementsByClassName("delete-button")
if (deleteButtons && deleteButtons.length > 0) {
  for (let button of deleteButtons) {
    button.onclick = () => {
      let confirmedDelete = confirm(`Are you sure you want to delete ${button.dataset.education}?`);
      if (!confirmedDelete) return;
      window.location.href = `educations.php?delete=${button.dataset.id}`;
    }
  }
};
</script>
