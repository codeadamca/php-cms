<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

if( isset( $_POST['skill_id'] ) )
{
  
  // checks for minimum content
  if( $_POST['skill_id'] and $_POST['user_id'] )
  {
    
    $query = 'INSERT INTO user_skills (
        user_id,
        skill_id,
        percent,
        description
      ) VALUES (
         "'.mysqli_real_escape_string( $connect, $_POST['user_id'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['skill_id'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['percent'] ).'",
         "'.mysqli_real_escape_string( $connect, $_POST['description'] ).'"
      )';
    mysqli_query( $connect, $query );
    
    set_message( 'Skill has been assigned' );
    
  }
  
  header( 'Location: skills.php' );
  die();
  
}

include( 'includes/header.php' );

?>

<h2>Add Skill</h2>

<form method="post">
  
<label for="user_id">User:</label>
  <select id="user_id" name="user_id">
    <option selected disabled>Select a username...</option>
    <?php
      $q = "SELECT id, first, last FROM users";
      $res = mysqli_query($connect, $q);
      while($user = mysqli_fetch_assoc($res))
      {
      ?>
      <option value="<?=$user['id']?>"><?=$user['first']?> <?=$user['last']?></option>
      <?php
      }
    ?>
  </select>
  <br>

  <label for="skill_id">Skill:</label>
  <select id="skill_id" name="skill_id">
    <option selected disabled>Select a skill...</option>
    <?php
      $q = "SELECT name,id FROM skills";
      $res = mysqli_query($connect, $q);
      while($skill = mysqli_fetch_assoc($res))
      {
      ?>
      <option value="<?=$skill['id']?>"><?=$skill['name']?></option>
      <?php
      }
    ?>
  </select>
  <br>

  <label for="description">Description:</label>
  <input type="text" name="description" id="description">
    
  <br>

  <label for="percent">Percent:</label>
  <input type="number" name="percent" id="percent">
    
  <br>

  
  <input type="submit" value="Assign Skill">
  
</form>

<p><a href="skills.php"><i class="fas fa-arrow-circle-left"></i> Return to Skill List</a></p>


<?php

include( 'includes/footer.php' );

?>