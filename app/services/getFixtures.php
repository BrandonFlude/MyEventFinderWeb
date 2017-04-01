
<?php
#-- Get the user and date from the URL
$user_id = $_GET['user-id'];
$date = $_GET['date'];

#-- Connect to the database
$con = mysqli_connect("localhost","teamproject_tb","password","teamproject_db");

#–- Build Query
$fieldsRequired = "usr.user_id, fixt.home_team_id, hm.home_team_name, hm.home_team_logo_url, hm.home_team_colour_hex, fixt.away_team_id, aw.away_team_name, aw.away_team_logo_url, aw.away_team_colour_hex, fixt.fixture_start_dt, fixt.fixture_end_dt, fixt.venue_nm, lgs.league_nm, fixt.ticket_url";
$joinSpecify = "JOIN teams_tb tm ON usr.team_id = tm.team_id JOIN sports_fixtures_tb fixt ON usr.team_id = fixt.home_team_id OR usr.team_id = fixt.away_team_id";
$joinOne = "LEFT OUTER JOIN (SELECT team_id,
                        team_nm         AS home_team_name,
                        team_logo_url   AS home_team_logo_url,
                        team_colour_hex AS home_team_colour_hex
                 FROM   teams_tb) hm
             ON fixt.home_team_id = hm.team_id";
$joinTwo = "LEFT OUTER JOIN (SELECT team_id,
                        team_nm         AS away_team_name,
                        team_logo_url   AS away_team_logo_url,
                        team_colour_hex AS away_team_colour_hex
                 FROM   teams_tb) aw
             ON fixt.away_team_id = aw.team_id";
$joinThree = "LEFT OUTER JOIN (SELECT league_id,
                        league_nm
                FROM leagues_tb) lgs
              ON tm.league_id = lgs.league_id";

#-- Start SQL Statement
$query = "SELECT DISTINCT $fieldsRequired FROM user_sports_follows_tb usr $joinSpecify $joinOne $joinTwo $joinThree WHERE user_id='$user_id' AND fixture_start_dt LIKE '$date%'";

#-- Check if there are results
$result = mysqli_query($con, $query);

#-- Count results
$numrows = mysqli_num_rows($result);

if ($numrows > 0)
{
	#–- If so, then create a results array and a temporary one to hold the data
	$resultArray = array();
	$tempArray = array();

	#–- Loop through each row in the result set
	while($row = $result->fetch_object())
	{
		#–- Add each row into our results array
		$tempArray = $row;
    array_push($resultArray, $tempArray);
	}

	#–- Finally, encode the array to JSON and output the results
	echo json_encode($resultArray);
}
else
{
  echo "false";
}

#–- Close connections
mysqli_close($con);
?>
