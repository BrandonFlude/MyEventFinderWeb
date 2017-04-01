<?php
// This removes a team from the database

// Create connection
$con = mysqli_connect("localhost","teamproject_tb","password","teamproject_db");

// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Fetch User ID and Team ID
$user_id = $_GET['user-id'];
$team_id = $_GET['team-id'];

$query = mysqli_query($con, "SELECT * FROM user_sports_follows_tb WHERE user_id='$user_id' AND team_id='$team_id'");
$count = mysqli_num_rows($query);
if($count > 0)
{
  // It exists, so just remove it
  $query = mysqli_query($con, "DELETE FROM user_sports_follows_tb WHERE user_id='$user_id' AND team_id='$team_id'");
  echo "true";
}
else
{
  // The follow doesn't exist to be removed
  echo "false";
}
?>
