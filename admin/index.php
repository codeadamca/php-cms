<?php

include( 'includes/database.php' );
include( 'includes/config.php' );
include( 'includes/functions.php' );

if( isset( $_POST['email'] ) )
{
  
  $query = 'SELECT *
    FROM users
    WHERE email = "'.$_POST['email'].'"
    AND password = "'.md5( $_POST['password'] ).'"
    AND active = "Yes"
    LIMIT 1';
  $result = mysqli_query( $connect, $query );
  
  if( mysqli_num_rows( $result ) )
  {
    
    $record = mysqli_fetch_assoc( $result );
    
    $_SESSION['id'] = $record['id'];
    $_SESSION['email'] = $record['email'];
    
    header( 'Location: dashboard.php' );
    die();
    
  }
  else
  {
    
    set_message( 'Incorrect email and/or password' );
    
    header( 'Location: index.php' );
    die();
    
  } 
  
}

include( 'includes/header.php' );

?>

<div style="max-width: 400px; margin:auto">

  <form method="post">

    <label for="email">Email:</label>
    <input type="text" name="email" id="email">

    <br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password">

    <br>

    <input type="submit" value="Login">

  </form>
  
</div>

<?php

include( 'includes/footer.php' );

?>