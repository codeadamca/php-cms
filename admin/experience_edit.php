<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( !isset( $_GET['id'] ) )
{
  
  header( 'Location: experience.php' );
  die();
  
}

if( isset( $_POST['title'] ) )
{
  
  if( $_POST['title'] and $_POST['content'] )
  {
    
    $query = 'UPDATE experience SET
      user_id= "'.mysqli_real_escape_string( $connect, $_POST['user_id']).'",
      title = "'.mysqli_real_escape_string( $connect, $_POST['title'] ).'",
      content = "'.mysqli_real_escape_string( $connect, $_POST['content'] ).'",
      start_date = "'.mysqli_real_escape_string( $connect, $_POST['start_date'] ).'",
      end_date = "'.mysqli_real_escape_string( $connect, $_POST['end_date'] ).'"
      WHERE id = '.$_GET['id'].'
      LIMIT 1';
    mysqli_query( $connect, $query );
    
    set_message( 'Experience has been updated' );
    
  }

  header( 'Location: experience.php' );
  die();
  
}


if( isset( $_GET['id'] ) )
{
  
  $query = 'SELECT *
    FROM experience
    WHERE id = '.$_GET['id'].'
    LIMIT 1';
  $result = mysqli_query( $connect, $query );
  
  if( !mysqli_num_rows( $result ) )
  {
    
    header( 'Location: experience.php' );
    die();
    
  }
  
  $record = mysqli_fetch_assoc( $result );
  
}

include( 'includes/header.php' );

?>

<h2>Edit Experience</h2>

<form method="post">

  <label for="user">User:</label>
  <select id="user_id" name="user_id">
    <option disabled>Select a username...</option>
    <?php
      $q = "SELECT id, first, last FROM users";
      $res = mysqli_query($connect, $q);
      while($user = mysqli_fetch_assoc($res))
      {
      ?>
      <option <?=$user['id']==htmlentities( $record['user_id'] ) ? "selected" : null?> value="<?=$user['id']?>"><?=$user['first']?> <?=$user['last']?></option>
      <?php
      }
    ?>
  </select>
  <br>
  
  <label for="title">Title:</label>
  <input required type="text" name="title" id="title" value="<?php echo htmlentities( $record['title'] ); ?>">
    
  <br>
  
  <label for="content">Content:</label>
  <textarea required type="text" name="content" id="content" rows="5"><?php echo htmlentities( $record['content'] ); ?></textarea>
  
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
  <input required type="date" name="start_date" id="start_date" value="<?=$record['start_date']?>">
  
  <br>

  <label for="end_date">End Date:</label>
  <input type="date" name="end_date" id="end_date" value="<?=$record['end_date']?>">
  
  <br>
  
  <input type="submit" value="Edit Experience">
  
</form>

<p><a href="experience.php"><i class="fas fa-arrow-circle-left"></i> Return to Experience List</a></p>


<?php

include( 'includes/footer.php' );

?>