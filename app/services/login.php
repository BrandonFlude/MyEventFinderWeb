<?php
  include($_SERVER['DOCUMENT_ROOT'].'/assets/connect/index.php');

  #-- GET all of data passed to us
  $auth = $_GET['auth'];
  $email = $_GET['email'];
  $password_enc = $_GET['password'];
  $debug = $_GET['debug'];

  if($auth == "7awee81inro39mzupu8v")
  {
    #-- Authorisation Success
    $query = mysqli_query($con, "SELECT user_id, username_nm FROM users_tb WHERE user_email='$email' AND user_password_enc='$password_enc'");
    $count = mysqli_num_rows($query);
    if($count == 1)
    {
      $row = mysqli_fetch_assoc($query);
      $user_id = $row['user_id'];
      $username = $row['username_nm'];

      #-- Create a authentication key to keep them logged in
      $length = 30;
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
      $encryptedKey = md5($randomString);

      #-- Insert authentication key into database
      $date = date('Y-m-d | H:i:s');
      $insert = mysqli_query($con, "INSERT INTO user_authentications_tb VALUES ('', '$user_id', '$encryptedKey', '$date')");

      echo "$user_id,$username,$encryptedKey";

    }
    else
    {
      if($debug == "true")
      {
        echo "No match found in the database";
      }
      else
      {
        echo "false";
      }
    }
  }
  else
  {
    if($debug == "true")
    {
      echo "Authorisation code wasn't found";
    }
    else
    {
      echo "false";
    }
  }
?>
