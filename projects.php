<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

secure();

include( 'includes/header.php' );

if( isset( $_GET['delete'] ) )
{
  
  $query = 'DELETE FROM articles
    WHERE id = '.$_GET['delete'].'
    LIMIT 1';
  mysqli_query( $connect, $query );
    
  set_message( 'Article has been deleted' );
  
  header( 'Location: articles.php' );
  die();
  
}

$query = 'SELECT *
  FROM articles ';

if(isset($_GET['filter']))
{
  if($_GET['filter'] == 'home') $query .= 'WHERE home = "Yes" ';
  else $query .= 'WHERE type = "'.strtolower($_GET['filter']).'" ';
}

$query .= 'ORDER BY date DESC';
$result = mysqli_query( $connect, $query );

include 'includes/wideimage/WideImage.php';

?>

<h2>Manage Articles<?php echo isset($_GET['filter']) ? ': '.ucfirst($_GET['filter']) : ''; ?></h2>

<p style="padding: 0 1%; text-align: center;">
  <a href="/articles.php?filter=home"><?php echo icon('home'); ?> Home</a> | 
  <a href="/articles.php?filter=industry"><?php echo icon('industry'); ?> Industry Projects</a> | 
  <a href="/articles.php?filter=professional"><?php echo icon('professional'); ?> Professional Development</a> | 
  <a href="/articles.php?filter=research"><?php echo icon('research'); ?> Research and Publishings</a> | 
  <a href="/articles.php?filter=speaking"><?php echo icon('speaking'); ?> Speaking Engagements</a> | 
  <a href="/articles.php?filter=technology"><?php echo icon('technology'); ?> Technology</a> | 
  <a href="/articles.php?filter=tinkering"><?php echo icon('tinkering'); ?> Tinkering</a>
</p>

<table>
  <tr>
    <th></th>
    <th align="center">ID</th>
    <th align="left">Title</th>
    <th align="center">Type</th>
    <th align="center">Date</th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
  <?php while( $record = mysqli_fetch_assoc( $result ) ): ?>
    <tr>
      <td align="center">
        <img src="image.php?type=article&id=<?php echo $record['id']; ?>&width=300&height=300&format=inside">
      </td>
      <td align="center"><?php echo $record['id']; ?></td>
      <td align="left">
        <?php echo htmlentities( $record['title'] ); ?>
        <small><?php echo $record['content']; ?></small>
        <?php echo ($record['home'] == 'Yes') ? icon('home') : ''; ?>
        <?php echo ($record['photo']) ? '<i class="fas fa-camera"></i>' : ''; ?>
        <?php echo ($record['instagramId']) ? '<i class="fab fa-instagram-square"></i>' : ''; ?>
        <?php echo ($record['twitterId']) ? '<i class="fab fa-twitter-square"></i>' : ''; ?>
        <?php echo ($record['soundcloudId']) ? '<i class="fab fa-soundcloud"></i>' : ''; ?>
        <?php echo ($record['url']) ? '<i class="fas fa-link"></i>' : ''; ?>
      </td>
      <td align="center"><?php echo icon($record['type']); ?></td>
      <td align="center" style="white-space: nowrap;"><?php echo htmlentities( $record['date'] ); ?></td>
      <td align="center"><a href="articles_photo.php?id=<?php echo $record['id']; ?>"><i class="fas fa-camera"></i></a></td>
      <td align="center"><a href="articles_edit.php?id=<?php echo $record['id']; ?>"><i class="fas fa-edit"></i></a></td>
      <td align="center">
        <a href="articles.php?delete=<?php echo $record['id']; ?>" onclick="javascript:confirm('Are you sure you want to delete this article?');"><i class="fas fa-trash-alt"></i></a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

<p><a href="articles_add.php"><i class="fas fa-plus-square"></i> Add Article</a></p>


<?php

include( 'includes/footer.php' );

?>