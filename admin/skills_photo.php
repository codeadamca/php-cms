<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( !isset( $_GET['id'] ) )
{
  
  header( 'Location: skills.php' );
  die();
  
}

if( isset( $_FILES['icon'] ) )
{
 

  if( isset( $_FILES['icon'] ) )
  {
  
    if( $_FILES['icon']['error'] == 0 )
    {

      switch( $_FILES['icon']['type'] )
      {
        case 'image/png': 
          $type = 'png'; 
          break;
        case 'image/jpg':
        case 'image/jpeg':
          $type = 'jpeg'; 
          break;
        case 'image/gif': 
          $type = 'gif'; 
          break;      
      }

      $query = 'UPDATE skills SET
        icon = "data:image/'.$type.';base64,'.base64_encode( file_get_contents( $_FILES['icon']['tmp_name'] ) ).'"
        WHERE id = '.$_GET['id'].'
        LIMIT 1';


      mysqli_query( $connect, $query );



    }
    
  }
  
  set_message( 'Skill photo has been updated' );

  header( 'Location: skills.php' );
  die();
  
}


if( isset( $_GET['id'] ) )
{
  
  if( isset( $_GET['delete'] ) )
  {
    
    $query = 'UPDATE skills SET
      icon = ""
      WHERE id = '.$_GET['id'].'
      LIMIT 1';
    $result = mysqli_query( $connect, $query );
    
    set_message( 'Skill photo has been deleted' );
    
    header( 'Location: skills.php' );
    die();
    
  }
  
  $query = 'SELECT *
    FROM skills
    WHERE id = '.$_GET['id'].'
    LIMIT 1';
  $result = mysqli_query( $connect, $query );
  
  if( !mysqli_num_rows( $result ) )
  {
    
    header( 'Location: skills.php' );
    die();
    
  }
  
  $record = mysqli_fetch_assoc( $result );
  
}

include( 'includes/header.php' );

include 'includes/wideimage/WideImage.php';

?>

<h2>Edit Skill</h2>

<p>
  Note: For best results, photos should be approximately 800 x 800 pixels.
</p>

<?php if( $record['icon'] ): ?>

  <p><img src="<?=$record['icon'];?>" width="200" height="200"></p>
  <p><a href="skills_photo.php?id=<?php echo $_GET['id']; ?>&delete"><i class="fas fa-trash-alt"></i> Delete this Photo</a></p>

<?php endif; ?>

<form method="post" enctype="multipart/form-data">
  
  <label for="icon">Icon:</label>
  <input type="file" name="icon" id="icon">
  
  <br>
  
  <input type="submit" value="Save Icon">
  
</form>

<p><a href="skills.php"><i class="fas fa-arrow-circle-left"></i> Return to Skill List</a></p>


<?php

include( 'includes/footer.php' );

?>