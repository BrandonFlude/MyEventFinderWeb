<?php
include($_SERVER['DOCUMENT_ROOT'].'/assets/connect/index.php');

#-- GET all of data passed to us
$auth = $_GET['auth'];
$username = $_GET['username'];
$email_address = $_GET['email'];
$password = $_GET['password'];

if($auth == "7awee81inro39mzupu8v")
{

  #-- See if they filled in all the fields
  if($username && $email_address && $password)
  {
    #-- First we need to see if the email address is valid
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL) === false)
    {
      #-- Check if the email is taken
      $query = mysqli_query($con, "SELECT user_email FROM users_tb WHERE user_email='$email_address'");
      $count = mysqli_num_rows($query);
      if($count < 1)
      {
        #-- Email Address is valid, proceed
        #-- Check if the username is already in the database
        $query = mysqli_query($con, "SELECT username_nm FROM users_tb WHERE username_nm='$username'");
        $count = mysqli_num_rows($query);
        if($count < 1)
        {
          #-- All data is fine, go ahead and insert into the database
          $insert = mysqli_query($con, "INSERT INTO users_tb VALUES ('', '$username', '$email_address', '$password', '0')");
          echo "true";
        }
        else
        {
          #-- Someone has this username, show an error
          echo "username in use";
        }
      }
      else
      {
        #-- Email Address is already in use, so show an error
        echo "email in use";
      }
    }
    else
    {
      #-- Email Address isn't valid, so show an error
      echo "email is not valid";
    }
  }
  else
  {
    #-- Didn't enter all of the fields
    echo "false";
  }
}
else
{
  #-- No Authorisation key
  echo "false";
}
?>
