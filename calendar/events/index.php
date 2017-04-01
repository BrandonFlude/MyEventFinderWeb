<?php
if($_COOKIE['MyEventFinder'])
{
  #-- Connect to the backend
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
    $user_id = $row['user_id'];

    #-- Fetch date from URL, passed in using a URL rewrite
    $fetchedDate = $_GET['date'];
    if($fetchedDate == "")
    {
      header("Location: /calendar");
    }
  }
  else
  {
    header("Location: /login");
  }
}
else
{
  #-- Destroy cookie
  ob_start();
  setcookie("MyEventFinder", "", time() - (86400 * 30), "/");
  ob_end_flush();

  header("Location: /login");
}
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/head.php'); ?>
  <title>My Event Finder | Events</title>
</head>
<body>
  <?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/nav.php'); ?>
  <header>
    <div class="container">
      <div class="row">
        <div class="col-md-12" style="margin-top: 50px;">
          <?php
          $fieldsRequired = "usr.user_id, fixt.home_team_id, hm.home_team_name, hm.home_team_log_url, hm.home_team_colour_hex, fixt.away_team_id, aw.away_team_name, aw.away_team_log_url, aw.away_team_colour_hex, fixt.fixture_start_dt, fixt.fixture_end_dt, fixt.venue_nm, lgs.league_nm, fixt.ticket_url";
          $joinSpecify = "JOIN teams_tb tm ON usr.team_id = tm.team_id JOIN sports_fixtures_tb fixt ON usr.team_id = fixt.home_team_id OR usr.team_id = fixt.away_team_id";
          $joinOne = "LEFT OUTER JOIN (SELECT team_id,
                                  team_nm         AS home_team_name,
                                  team_logo_url   AS home_team_log_url,
                                  team_colour_hex AS home_team_colour_hex
                           FROM   teams_tb) hm
                       ON fixt.home_team_id = hm.team_id";
          $joinTwo = "LEFT OUTER JOIN (SELECT team_id,
                                  team_nm         AS away_team_name,
                                  team_logo_url   AS away_team_log_url,
                                  team_colour_hex AS away_team_colour_hex
                           FROM   teams_tb) aw
                       ON fixt.away_team_id = aw.team_id";
          $joinThree = "LEFT OUTER JOIN (SELECT league_id,
                                  league_nm
                          FROM leagues_tb) lgs
                        ON tm.league_id = lgs.league_id";
          $whereClause = "WHERE user_id='$user_id' AND fixture_start_dt LIKE '$fetchedDate%'";

          $query = mysqli_query($con, "SELECT DISTINCT $fieldsRequired FROM user_sports_follows_tb usr $joinSpecify $joinOne $joinTwo $joinThree $whereClause");

          #-- Iterate through every event this user has on this date
          while($row = mysqli_fetch_assoc($query))
          {
            $home_team_id = $row['home_team_id'];
            $home_team_name = $row['home_team_name'];
            $home_team_log_url = $row['home_team_log_url'];
            $home_team_colour_hex = $row['home_team_colour_hex'];
            $away_team_id = $row['away_team_id'];
            $away_team_name = $row['away_team_name'];
            $away_team_log_url = $row['away_team_log_url'];
            $away_team_colour_hex = $row['away_team_colour_hex'];
            $fixture_start_dt = $row['fixture_start_dt'];
            $fixture_end_dt = $row['fixture_end_dt'];
            $venue_nm = $row['venue_nm'];
            $league_nm = $row['league_nm'];
            $ticket_url = $row['ticket_url'];

            #-- Convert the dates for display
            $newStartDate = date('D jS F \a\t H:i', strtotime($fixture_start_dt));
            $newEndDate = date('D jS F \a\t H:i', strtotime($fixture_end_dt));

            echo "
            <div class='panel panel-default'>
              <div class='panel-body'>
                <div class='row'>
                  <div class='col-md-3'>
                    <center>
                      <img src='$home_team_log_url' height='50px' width='50px' />
                      <h4 style='color: #$home_team_colour_hex;'>$home_team_name</h4>
                    </center>
                  </div>
                  <div class='col-md-6'>
                    <center>
                      <h4 style='color: #333;'>$venue_nm</h4>
                      <h4 style='color: #333;'>$league_nm</h4>
                      <h4 style='color: #333;'>$newStartDate</h4>
                    </center>
                  </div>
                  <div class='col-md-3'>
                    <center>
                      <img src='$away_team_log_url' height='50px' width='50px' />
                      <h4 style='color: #$away_team_colour_hex;'>$away_team_name</h4>
                    </center>
                  </div>
                </div>
              </div>
              <div class='panel-footer'>
                <a href='$ticket_url' class='btn btn-block btn-success' target='_blank'>Buy Tickets</a>
              </div>
            </div>
            ";
          }
          ?>
        </div>
      </div>
    </div>
  </header>
</body>
<?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/footer.php'); ?>
