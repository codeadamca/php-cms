<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );
include ( 'includes/card.php' );
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
    <p><a href="experience_add.php?user_id=<?=$user['id']?>"><i class="fas fa-plus-square"></i> Add Experience for <?=$user['first'].' '.$user['last']?></a></p>

    <div class="card-container">

    <?php foreach( $experiences[$user['id']] as $record ) {
        content_card (

          $record['id'], // item ID

          "experience", // Record type

          $record['title'], // Title

          common_date($record['start_date']).' - '.common_date($record['end_date']), // Subtitle

          null, // Thumbnail Link

          $record['content'], // body content (limi 200 characters)

          "experience_edit.php?id=".$record['id'], // "Edit" button link location

          "experiences.php?cmd=delete&delete=".$record['id'] // "Delete" button link location

        );

    } 
    ?>
    </div>

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