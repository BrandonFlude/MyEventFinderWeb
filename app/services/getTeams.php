<?php
#-- Get the team from the URL
$team = $_GET['team'];

#-- Connect to the database
$con = mysqli_connect("localhost","teamproject_tb","password","teamproject_db");

#-- Start SQL Statement
$query = "SELECT team_id, team_nm, team_logo_url, league_nm FROM teams_tb, leagues_tb WHERE team_nm LIKE '%$team%' AND teams_tb.league_id = leagues_tb.league_id ORDER BY team_nm ASC";

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
