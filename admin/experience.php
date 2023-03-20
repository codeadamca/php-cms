<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( isset( $_GET['delete'] ) )
{
  
  $query = 'DELETE FROM experience
    WHERE id = '.$_GET['delete'].'
    LIMIT 1';
  mysqli_query( $connect, $query );
    
  set_message( 'Experience has been deleted' );
  
  header( 'Location: experience.php' );
  die();
  
}

include( 'includes/header.php' );

$query = 'SELECT * FROM experience';
$result = mysqli_query( $connect, $query );
$experiences = array();

// gets a list of experiences, and sorts them into an array based on who the experience belongs to

while($exp = mysqli_fetch_assoc($result))
{
  if(!isset($experiences[$exp['user_id']]))
  {
    $experiences[$exp['user_id']] = array();
  }
  
  array_push($experiences[$exp['user_id']],$exp);

}

?>



<h2>Manage Experiences</h2>
<p><a href="experience_add.php"><i class="fas fa-plus-square"></i> Add Experience</a></p>


<?php 

  // Organizes experiences based on which user they belong to

  $query = "SELECT first,last,id FROM users ORDER BY first, last, id;";
  $users = mysqli_query($connect, $query);
  while($user = mysqli_fetch_assoc($users))
  {
    if(!isset($experiences[$user['id']])) continue;
    ?>
    <h2><?=$user['first'].' '.$user['last']?></h2>
    <table>
      <tr>
        <th align="center">ID</th>
        <th align="left">Title</th>
        <th align="center">Duration</th>
        <th></th>
        <th></th>
      </tr>
      <?php foreach( $experiences[$user['id']] as $record ): ?>
        <tr>
          <td align="center"><?php echo $record['id']; ?></td>
          <td align="left">
            <?php echo htmlentities( $record['title'] ); ?>
            <small><?php echo $record['content']; ?></small>
          </td>
          <td align="center"><?php echo date_format(date_create($record['start_date']),'M d, Y'); ?> - <?php echo date_format(date_create($record['end_date']),'M d, Y'); ?></td>
          <td align="center"><a href="experience_edit.php?id=<?php echo $record['id']; ?>">Edit</i></a></td>
          <td>
            <button class="delete-button" data-id="<?php echo $record['id'];?>" data-title="<?php echo $record['title'];?>">Delete</button>
          </td>
          </tr>
      <?php endforeach; ?>
    </table>
    <?php
  }

?>





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
      window.location.href = `experience.php?delete=${button.dataset.id}`;
    }
  }
};
</script>