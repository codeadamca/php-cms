<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

include( 'includes/header.php' );

if( isset( $_POST['title'] ) )
{
  
  if( $_POST['title'] and $_POST['content'] )
  {
    
    $query = 'INSERT INTO articles (
        title,
        instagramId,
        twitterId,
        soundcloudId,
        resources,
        content,
        date,
        type,
        home,
        url
      ) VALUES (
         "'.mysqli_real_escape_string( $connect, $_POST['title'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['instagramId'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['twitterId'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['soundcloudId'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['resources'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['content'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['date'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['type'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['home'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['url'] ).'"
      )';
    mysqli_query( $connect, $query );
    
    set_message( 'Article has been added' );
    
  }
  
  header( 'Location: articles.php' );
  die();
  
}

?>

<h2>Add Article</h2>

<form method="post">
  
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
  
  <label for="instagramId">Instagram ID:</label>
  <input type="text" name="instagramId" id="instagramId">
    
  <br>
  
  <label for="twitterId">Twitter ID:</label>
  <input type="text" name="twitterId" id="twitterId">
  
  <br>
  
  <label for="soundcloudId">SoundCloud ID:</label>
  <input type="text" name="soundcloudId" id="soundcloudId">
  
  <br>
  
  <label for="url">URL:</label>
  <input type="text" name="url" id="url">
  
  <br>
  
  <label for="date">Date:</label>
  <input type="date" name="date" id="date">
  
  <br>
  
  <label for="resources">Resources:</label>
  <textarea name="resources" id="resources" rows="5"></textarea>
  
  <br>
  
  <label for="type">Type:</label>
  <?php
  
  $values = array( 'Industry', 'Professional', 'Research', 'Speaking', 'Technology', 'Tinkering' );
  
  echo '<select name="type" id="type">';
  foreach( $values as $key => $value )
  {
    echo '<option value="'.$value.'"';
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
    echo '>'.$value.'</option>';
  }
  echo '</select>';
  
  ?>
  
  <br>
  
  <input type="submit" value="Add Article">
  
</form>

<p><a href="articles.php"><i class="fas fa-arrow-circle-left"></i> Return to Article List</a></p>


<?php

include( 'includes/footer.php' );

?>