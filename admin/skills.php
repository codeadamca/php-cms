<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

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
  ORDER BY name DESC';
$result = mysqli_query( $connect, $query );

?>

<h2>Manage Skills</h2>

<table>
  <tr>
    <th></th>
    <th align="center">ID</th>
    <th align="left">Name</th>
    <th align="center">Link</th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
  <?php while( $record = mysqli_fetch_assoc( $result ) ): ?>
    <tr>
      <td align="center">
        <img src="image.php?type=skill&id=<?php echo $record['id']; ?>&width=125&height=125&format=inside">
      </td>
      <td align="center"><?php echo $record['id']; ?></td>
      <td align="left">
        <?php echo htmlentities( $record['name'] ); ?>
        <small><?php echo $record['content']; ?></small>
      </td>
      <td align="center">
        <a target="_blank" href="<?php echo $record['link']; ?>"><?php echo $record['link']; ?></a>
      </td>
      <td align="center"><a href="skills_photo.php?id=<?php echo $record['id']; ?>">Photo</i></a></td>
      <td align="center"><a href="skills_edit.php?id=<?php echo $record['id']; ?>">Edit</i></a></td>
      <td align="center">
        <a href="skills.php?cmd=delete&delete=<?php echo $record['id']; ?>" onclick="javascript:confirm('Are you sure you want to delete this skill?');">Delete</i></a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

<p><a href="skills_add.php"><i class="fas fa-plus-square"></i> Add skill</a></p>

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