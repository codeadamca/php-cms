<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( isset( $_POST['user_id'] ) )
{
  
  if( $_POST['user_id'] and $_POST['school_name'] )
  {
    
    $query = 'INSERT INTO educations (
        user_id,
        school_name,
        location,
        level_of_education,
        field,
        start_date,
        end_date,
        content
      ) VALUES (
         "'.mysqli_real_escape_string( $connect, $_POST['user_id'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['school_name'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['location'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['level_of_education'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['field'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['start_date'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['end_date'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['content'] ).'"
      )';
    mysqli_query( $connect, $query );
    
    set_message( 'Education has been added' );
    
  }
  
  header( 'Location: educations.php' );
  die();
  
}

include( 'includes/header.php' );

?>

<h2>Add Education</h2>

<form method="post">
  
  <label for="user_id">User ID:</label>
  <input type="number" name="user_id" id="user_id">
    
  <br>

  <label for="school_name">School Name:</label>
  <input type="text" name="school_name" id="school_name">
    
  <br>

  <label for="location">Location:</label>
  <input type="text" name="location" id="location">
  
  <br>

  <label for="level_of_education">Level of Education:</label>
  <input type="text" name="level_of_education" id="level_of_education">

  <br>

  <label for="field">Field:</label>
  <input type="text" name="field" id="field">
    
  <br>
  
  <label for="start_date">Start Date:</label>
  <input type="date" name="start_date" id="start_date">
    
  <br>

  <label for="end_date">End Date:</label>
  <input type="date" name="end_date" id="end_date">
  
  <br>

  <label for="content">Content:</label>
  <textarea type="text" name="content" id="content" rows="10"></textarea>

  <br>

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
  
  <input type="submit" value="Add Education">
  
</form>

<p><a href="educations.php"><i class="fas fa-arrow-circle-left"></i> Return to Education List</a></p>


<?php

include( 'includes/footer.php' );

?>