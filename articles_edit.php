<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

include( 'includes/header.php' );

if( !isset( $_GET['id'] ) )
{
  
  header( 'Location: articles.php' );
  die();
  
}

if( isset( $_POST['title'] ) )
{
  
  if( $_POST['title'] and $_POST['content'] )
  {
    
    $query = 'UPDATE articles SET
      title = "'.mysqli_real_escape_string( $connect, $_POST['title'] ).'",
      instagramId = "'.mysqli_real_escape_string( $connect, $_POST['instagramId'] ).'",
      twitterId = "'.mysqli_real_escape_string( $connect, $_POST['twitterId'] ).'",
      soundcloudId = "'.mysqli_real_escape_string( $connect, $_POST['soundcloudId'] ).'",
      resources = "'.mysqli_real_escape_string( $connect, $_POST['resources'] ).'",
      content = "'.mysqli_real_escape_string( $connect, $_POST['content'] ).'",
      date = "'.mysqli_real_escape_string( $connect, $_POST['date'] ).'",
      type = "'.mysqli_real_escape_string( $connect, $_POST['type'] ).'",
      home = "'.mysqli_real_escape_string( $connect, $_POST['home'] ).'",
      url = "'.mysqli_real_escape_string( $connect, $_POST['url'] ).'"
      WHERE id = '.$_GET['id'].'
      LIMIT 1';
    mysqli_query( $connect, $query );
    
    set_message( 'Article has been updated' );
    
  }

  header( 'Location: articles.php' );
  die();
  
}


if( isset( $_GET['id'] ) )
{
  
  $query = 'SELECT *
    FROM articles
    WHERE id = '.$_GET['id'].'
    LIMIT 1';
  $result = mysqli_query( $connect, $query );
  
  if( !mysqli_num_rows( $result ) )
  {
    
    header( 'Location: articles.php' );
    die();
    
  }
  
  $record = mysqli_fetch_assoc( $result );
  
}

?>

<h2>Edit Article</h2>

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
  
  <label for="instagramId">Instagram ID:</label>
  <input type="text" name="instagramId" id="instagramId" value="<?php echo htmlentities( $record['instagramId'] ); ?>">
    
  <br>
  
  <label for="twitterId">Twitter ID:</label>
  <input type="text" name="twitterId" id="twitterId" value="<?php echo htmlentities( $record['twitterId'] ); ?>">
    
  <br>
  
  <label for="soundcloudId">SoundCloud ID:</label>
  <input type="text" name="soundcloudId" id="soundcloudId" value="<?php echo htmlentities( $record['soundcloudId'] ); ?>">
    
  <br>
  
  <label for="url">URL:</label>
  <input type="text" name="url" id="url" value="<?php echo htmlentities( $record['url'] ); ?>">
    
  <br>
  
  <label for="date">Date:</label>
  <input type="date" name="date" id="date" value="<?php echo htmlentities( $record['date'] ); ?>">
    
  <br>
  
  <label for="resources">Resources:</label>
  <textarea name="resources" id="resources" rows="5"><?php echo htmlentities( $record['resources'] ); ?></textarea>
  
  <br>
  
  <label for="type">Type:</label>
  <?php
  
  $values = array( 'Industry', 'Professional', 'Research', 'Speaking', 'Technology', 'Tinkering' );
  
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
  
  <label for="home">Home:</label>
  <?php
  
  $values = array( 'Yes', 'No' );
  
  echo '<select name="home" id="home">';
  foreach( $values as $key => $value )
  {
    echo '<option value="'.$value.'"';
    if( $value == $record['home'] ) echo ' selected="selected"';
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  
  ?>
  
  <br>
  
  <input type="submit" value="Edit Article">
  
</form>

<p><a href="articles.php"><i class="fas fa-arrow-circle-left"></i> Return to Article List</a></p>


<?php

include( 'includes/footer.php' );

?>