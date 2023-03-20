<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );
include( 'includes/card.php' );

secure();

if( isset( $_GET['cmd'] ) )
{
  if( $_GET['cmd'] == "delete" )
  {
    
    $query = 'DELETE FROM skills
      WHERE id = '.$_GET['delete'].'
      LIMIT 1';
    mysqli_query( $connect, $query );
      
    set_message( 'Skill has been deleted' );
    
    header( 'Location: skills.php' );
    die();
    
  }
  elseif( $_GET['cmd'] == "remove" and isset( $_GET['skill'] ) and isset( $_GET['user'] ) )
  {
    $query = 'DELETE FROM user_skills
      WHERE user_id = '.$_GET['user'].'
      AND skill_id = '.$_GET['skill'].'
      LIMIT 1';
    mysqli_query( $connect, $query );
      
    set_message( 'Skill has been removed' );
    
    header( 'Location: skills.php' );
    die();
  }
}


include( 'includes/header.php' );

$query = 'SELECT *
  FROM skills
  ORDER BY id';
$result = mysqli_query( $connect, $query );

?>

<h2>Manage Skills</h2>
<p><a href="skills_add.php"><i class="fas fa-plus-square"></i> Add skill</a></p>

<div class="card-container">
<?php while( $record = mysqli_fetch_assoc( $result ) ){
  content_card (

    $record['id'], // item ID

    "skills", // Record type

    $record['name'], // Title

    $record['link'], // Subtitle

    $record['icon'], // Thumbnail

    null, // body content (limi 200 characters)

    "skills_edit.php?id=".$record['id'], // "Edit" button link location

    "skills.php?cmd=delete&delete=".$record['id'], // "Delete" button link location
    "skills_photo.php?id=".$record['id'] // "Photo" button link location

  );

} ?>
</div>


<h2>Assigned Skills</h2>
<?php

  $query = "SELECT * FROM user_skills LEFT JOIN skills ON user_skills.skill_id = skills.id;";
  $res = mysqli_query($connect, $query);

  $user_skills=array();

  
  while($record = mysqli_fetch_assoc($res))
  {

    if(!isset($user_skills[$record['user_id']]))
    {
      $user_skills[$record['user_id']] = array();
    }
    
    array_push($user_skills[$record['user_id']],$record);

  }


  // Sorts the assigned skills based on the user. Each user has their own table, if they have a skill assigned

  $query = "SELECT first,last,id FROM users ORDER BY first, last, id;";
  $users = mysqli_query($connect, $query);
  while($user = mysqli_fetch_assoc($users))
  {
    if(!isset($user_skills[$user['id']])) continue;
    ?>
    <h3><?=$user['first'].' '.$user['last']?></h3>
    <table>
      <tr>
        <th align="left">Skill</th>
        <th align="center">Percent</th>
        <th align="left">Description</th>
        <th></th>
      </tr>
      <?php foreach( $user_skills[$user['id']] as $record ): ?>
        <tr>
          <td align="left">
            <?php echo htmlentities( $record['name'] ); ?>
          </td>
          <td align="center"><?php echo htmlentities( $record['percent'] ); ?>%</td>
          <td align="left">
            <?php echo htmlentities( $record['description'] ); ?>
          </td>
          <td>
          <a href="skills.php?cmd=remove&skill=<?php echo $record['skill_id']; ?>&user=<?php echo $record['user_id']; ?>">Remove</i></a>
          </td>
          </tr>
      <?php endforeach; ?>
    </table>

    <?php

  }
  
?>
<p><a href="skills_assign.php"><i class="fas fa-plus-square"></i> Assign a skill</a></p>


<?php

include( 'includes/footer.php' );

?>