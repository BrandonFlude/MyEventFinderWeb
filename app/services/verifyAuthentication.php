<?php
  include($_SERVER['DOCUMENT_ROOT'].'/assets/connect/index.php');

  #-- GET all of data passed to us
  $auth = $_GET['auth'];
  $key = $_GET['key'];

  if($auth == "7awee81inro39mzupu8v")
  {
    #-- Authorisation Success
    $checkKeyQuery = mysqli_query($con, "SELECT * FROM user_authentications_tb WHERE authentication_key='$key'");
    $numrows = mysqli_num_rows($checkKeyQuery);
    if($numrows > 0)
    {
      $row = mysqli_fetch_assoc($checkKeyQuery);
      $user_id = $row['user_id'];

      $query = mysqli_query($con, "SELECT username_nm FROM users_tb WHERE user_id='$user_id'");
      $count = mysqli_num_rows($query);
      if($count == 1)
      {
        $unr = mysqli_fetch_assoc($query);
        $username = $unr['username_nm'];
        echo "$user_id,$username";
      }
      else
      {
        echo "false";
      }
    }
    else
    {
      echo "false";
    }
  }
  else
  {
    echo "false";
  }
?>
