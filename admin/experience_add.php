<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( isset( $_POST['title'] ) )
{
  
  if( $_POST['title'] and $_POST['content'] )
  {
    
    $query = 'INSERT INTO experience (
        user_id,
        title,
        content,
        start_date,
        end_date
      ) VALUES (
         "'.mysqli_real_escape_string( $connect, $_POST['user_id'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['title'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['content'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['start_date'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['end_date'] ).'"
      )';
    mysqli_query( $connect, $query );
    
    set_message( 'Experience has been added' );
    
  }
  
  header( 'Location: experience.php' );
  die();
  
}

$selected_user_id;

if( isset($_GET['user_id']) )  
{
  $selected_user_id = htmlentities($_GET['user_id']);
}

include( 'includes/header.php' );

?>

<h2>Add Experience</h2>

<form method="post">

  <label for="user">User:</label>
  <select id="user_id" name="user_id">
    <option selected disabled value="0">Select a username...</option>
    <?php
      $q = "SELECT id, first, last FROM users";
      $res = mysqli_query($connect, $q);
      while($user = mysqli_fetch_assoc($res))
      {
      ?>
      <option value="<?=$user['id']?>"  <?= $user['id'] == $selected_user_id ? "selected": null; ?> ><?=$user['first']?> <?=$user['last']?></option>
      <?php
      }
    ?>
  </select>
  <br>

  <label for="title">Title:</label>
  <input type="text" name="title" id="title">
    
  <br>
  
  <label for="content">Content:</label>
  <textarea type="text" name="content" id="content" rows="10"></textarea>
      
  <script>

  ClassicEditor
    .create( document.querySelector( '#content' ) )
    .then( editor => {
        console.log( editor );
    } )
    .catch( error => {
        console.error( error );
    } );
    
  </script>
  
  <br>
  
  <label for="start_date">Start Date:</label>
  <input type="date" name="start_date" id="start_date">
  
  <br>

  <label for="end_date">End Date:</label>
  <input type="date" name="end_date" id="end_date">
  
  <br>
  
  <input type="submit" value="Add Experience">
  
</form>

<p><a href="experience.php"><i class="fas fa-arrow-circle-left"></i> Return to Experience List</a></p>


<?php

include( 'includes/footer.php' );

?>