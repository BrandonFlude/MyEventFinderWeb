<?php
// THIS FETCHES ALL THE FIXTURES ON A DATE

// Create connection
$con = mysqli_connect("localhost","teamproject_tb","password","teamproject_db");

// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Fetch User ID
$team_id = $_GET['team-id'];

// Build Query
// This SQL statement selects all we need
$query = mysqli_query($con, "SELECT description_detail FROM team_descriptions_tb WHERE team_id='$team_id'");
$numrows = mysqli_num_rows($query);
if($numrows > 0)
{
  $row = mysqli_fetch_assoc($query);
  $detail = $row['description_detail'];
  echo $detail;
}
else
{
  echo "false";
}

// Close connections
mysqli_close($con);
?>
