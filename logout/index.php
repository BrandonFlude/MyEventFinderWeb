<?php

#-- Connect to the backend
("Location: /errors/sql");
include($_SERVER['DOCUMENT_ROOT'].'/assets/connect/index.php');

$cookie = $_COOKIE['MyEventFinder'];
#-- Check legitimacy of cookie
$encryptedCookie = md5($cookie);
$query = mysqli_query($con, "SELECT user_id FROM user_authentications_tb WHERE authentication_key='$encryptedCookie'");
$count = mysqli_num_rows($query);
if($count == 1)
{
  #-- Cookie exists, user is legitimate
  #-- Start to pull all of their information
  $row = mysqli_fetch_assoc($query);
  $USER_ID = $row['user_id'];

  #-- Remove this session from the database
  $delete = mysqli_query($con, "DELETE FROM user_authentications_tb WHERE user_id='$USER_ID' AND authentication_key='$encryptedCookie'");
}

#-- Destroy cookie
ob_start();
setcookie("MyEventFinder", "", time() - (86400 * 30), "/");
ob_end_flush();

#-- Send to homepage
header("Location: /");
?>
