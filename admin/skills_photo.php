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

if( isset( $_FILES['logo'] ) )
{
  
  if( isset( $_FILES['logo'] ) )
  {
  
    if( $_FILES['logo']['error'] == 0 )
    {

      switch( $_FILES['logo']['type'] )
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
        logo = "data:image/'.$type.';base64,'.base64_encode( file_get_contents( $_FILES['logo']['tmp_name'] ) ).'"
        WHERE id = '.$_GET['id'].'
        LIMIT 1';
      mysqli_query( $connect, $query );

    }
    
  }
  
  set_message( 'Skill photo has been updated' );

  header( 'Location: projects.php' );
  die();
  
}


if( isset( $_GET['id'] ) )
{
  
  if( isset( $_GET['delete'] ) )
  {
    
    $query = 'UPDATE skills SET
      logo = ""
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

<?php if( $record['logo'] ): ?>

  <?php

  $data = base64_decode( explode( ',', $record['logo'] )[1] );
  $img = WideImage::loadFromString( $data );
  $data = $img->resize( 200, 200, 'outside' )->crop( 'center', 'center', 200, 200 )->asString( 'jpg', 70 );

  ?>
  <p><img src="data:image/jpg;base64,<?php echo base64_encode( $data ); ?>" width="200" height="200"></p>
  <p><a href="skills_photo.php?id=<?php echo $_GET['id']; ?>&delete"><i class="fas fa-trash-alt"></i> Delete this Photo</a></p>

<?php endif; ?>

<form method="post" enctype="multipart/form-data">
  
  <label for="logo">Logo:</label>
  <input type="file" name="logo" id="logo">
  
  <br>
  
  <input type="submit" value="Save Logo">
  
</form>

<p><a href="skills.php"><i class="fas fa-arrow-circle-left"></i> Return to Skill List</a></p>


<?php

include( 'includes/footer.php' );

?>