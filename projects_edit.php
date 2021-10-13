<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

include( 'includes/header.php' );

if( !isset( $_GET['id'] ) )
{
  
  header( 'Location: projects.php' );
  die();
  
}

if( isset( $_POST['title'] ) )
{
  
  if( $_POST['title'] and $_POST['content'] )
  {
    
    $query = 'UPDATE projects SET
      title = "'.mysqli_real_escape_string( $connect, $_POST['title'] ).'",
      content = "'.mysqli_real_escape_string( $connect, $_POST['content'] ).'",
      date = "'.mysqli_real_escape_string( $connect, $_POST['date'] ).'",
      type = "'.mysqli_real_escape_string( $connect, $_POST['type'] ).'",
      url = "'.mysqli_real_escape_string( $connect, $_POST['url'] ).'"
      WHERE id = '.$_GET['id'].'
      LIMIT 1';
    mysqli_query( $connect, $query );
    
    set_message( 'Project has been updated' );
    
  }

  header( 'Location: projects.php' );
  die();
  
}


if( isset( $_GET['id'] ) )
{
  
  $query = 'SELECT *
    FROM projects
    WHERE id = '.$_GET['id'].'
    LIMIT 1';
  $result = mysqli_query( $connect, $query );
  
  if( !mysqli_num_rows( $result ) )
  {
    
    header( 'Location: projects.php' );
    die();
    
  }
  
  $record = mysqli_fetch_assoc( $result );
  
}

?>

<h2>Edit Project</h2>

<form method="post">
  
  <label for="title">Title:</label>
  <input type="text" name="title" id="title" value="<?php echo htmlentities( $record['title'] ); ?>">
    
  <br>
  
  <label for="content">Content:</label>
  <textarea type="text" name="content" id="content" rows="5"><?php echo htmlentities( $record['content'] ); ?></textarea>
  
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
  
  <label for="url">URL:</label>
  <input type="text" name="url" id="url" value="<?php echo htmlentities( $record['url'] ); ?>">
    
  <br>
  
  <label for="date">Date:</label>
  <input type="date" name="date" id="date" value="<?php echo htmlentities( $record['date'] ); ?>">
    
  <br>
  
  <label for="type">Type:</label>
  <?php
  
  $values = array( 'Website', 'Graphic Design' );
  
  echo '<select name="type" id="type">';
  foreach( $values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    if( $value == $record['type'] ) echo ' selected="selected"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  
  ?>
  
  <br>
  
  <input type="submit" value="Edit Project">
  
</form>

<p><a href="projects.php"><i class="fas fa-arrow-circle-left"></i> Return to Project List</a></p>


<?php

include( 'includes/footer.php' );

?>