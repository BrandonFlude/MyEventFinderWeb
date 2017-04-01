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

// Get current date
//$date = date();
$date = date('Y-m-d G:i:s', strtotime("+1 day"));

// Build Query
// This SQL statement selects all we need
$query = mysqli_query($con, "SELECT * FROM sports_fixtures_tb WHERE (home_team_id='$team_id' AND fixture_start_dt > '$date') OR (away_team_id='$team_id' AND fixture_start_dt > '$date') LIMIT 5");
$numrows = mysqli_num_rows($query);
if($numrows > 0)
{
  $toEcho = "";
  while($row = mysqli_fetch_assoc($query))
  {
    $fixture_id = $row['fixture_id'];
    $home_team_id = $row['home_team_id'];
    $away_team_id = $row['away_team_id'];
    $fixture_start_dt = $row['fixture_start_dt'];
    $fixture_end_dt = $row['fixture_end_dt'];
    $venue = $row['venue_nm'];
    $league_id = $row['league_id'];

    // Get all of the team names
    $getHomeTeamName = mysqli_query($con, "SELECT team_nm FROM teams_tb WHERE team_id='$home_team_id'");
    $htnr = mysqli_fetch_assoc($getHomeTeamName);
    $getAwayTeamName = mysqli_query($con, "SELECT team_nm FROM teams_tb WHERE team_id='$away_team_id'");
    $atnr = mysqli_fetch_assoc($getAwayTeamName);
    $homeTeamName = $htnr['team_nm'];
    $awayTeamName = $atnr['team_nm'];

    // Get league name
    $getLeagueName = mysqli_query($con, "SELECT league_nm FROM leagues_tb WHERE league_id='$league_id'");
    $lnr = mysqli_fetch_assoc($getLeagueName);
    $leagueName = $lnr['league_nm'];

    $toEcho .= "$homeTeamName,$awayTeamName,$fixture_start_dt,$fixture_end_dt,$venue,$leagueName|";
  }

  $toEcho = substr_replace($toEcho, "", -1);

  echo $toEcho;
}
else
{
  echo "false";
}

// Close connections
mysqli_close($con);
?>
