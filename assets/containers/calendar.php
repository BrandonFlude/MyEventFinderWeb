<?php
$monthNames = Array("January", "February", "March", "April", "May", "June", "July",
"August", "September", "October", "November", "December");

if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");

$cMonth = $_REQUEST["month"];
$cYear = $_REQUEST["year"];

$prev_year = $cYear;
$next_year = $cYear;
$prev_month = $cMonth-1;
$next_month = $cMonth+1;

if ($prev_month == 0 ) {
    $prev_month = 12;
    $prev_year = $cYear - 1;
}
if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $cYear + 1;
}
?>

<header>
  <div class="container">
    <div class="row">
      <div class="col-md-12 visible-sm visible-xs clear-fix align-center">
        <h3>Sorry! :(</h3>
        <p>
          We are working hard to get mobile support working for your calendar, you can however download our Android app.
        </p>
        <a class="badge-link" href="https://play.google.com/store/apps/details?id=xyz.brandonflude.developement.myeventfinderv2" target="_blank">
          <img src="/assets/img/google-play.png" alt="Google Play Store" class="img-responsive" height="50%" width="50%">
        </a>
      </div>
      <div class="col-md-8 col-md-offset-2 hidden-sm hidden-xs">
        <table width="750" style="margin-top: 50px;">
          <tr align="center">
            <td class="calendar-cell">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="100%" align="left"><a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>" style="color:#FFFFFF"><span class="fa fa-chevron-left fa-fw"></span></a></td>
                  <td width="100%" align="right"><a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>" style="color:#FFFFFF"><span class="fa fa-chevron-right fa-fw"></span></a></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="center">
              <table width="100%" border="0" cellpadding="2" cellspacing="2">
                <tr align="center">
                  <td colspan="7" class="calendar-cell"><strong><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></strong></td>
                </tr>
                <tr>
                  <td class="calendar-cell"><strong><h2>S</h2></strong></td>
                  <td class="calendar-cell"><strong><h2>M</h2></strong></td>
                  <td class="calendar-cell"><strong><h2>T</h2></strong></td>
                  <td class="calendar-cell"><strong><h2>W</h2></strong></td>
                  <td class="calendar-cell"><strong><h2>T</h2></strong></td>
                  <td class="calendar-cell"><strong><h2>F</h2></strong></td>
                  <td class="calendar-cell"><strong><h2>S</h2></strong></td>
                </tr>
                <?php
                #-- Collect all the variables we need for manipulating a table to show a calendar layout
                $timestamp = mktime(0,0,0,$cMonth,1,$cYear);
                $maxday = date("t",$timestamp);
                $thismonth = getdate($timestamp);
                $startday = $thismonth['wday'];
                for ($i=0; $i<($maxday+$startday); $i++) {
                  $printDay = $i - $startday + 1;
                  if(($i % 7) == 0)
                  {
                    #-- Start a new row, start of a new week
                    echo "<tr>&nbsp;&nbsp;";
                  }
                  if($i < $startday)
                  {
                    #-- Day is less than start day of the month, show an empty cell
                    echo "<td class='calendar-day-cell'></td>&nbsp;&nbsp;";
                  }
                  else
                  {
                    #-- Format the date to query the database correctly
                    if($cMonth < 10) {$qMonth = "0".$cMonth;}
                    else {$qMonth = $cMonth;}
                    if($printDay < 10) { $qDay = "0".$printDay;}
                    else {$qDay = $printDay;}
                    $dateToQuery = "$cYear-$qMonth-$qDay";
                    #-- Day is in the correct place, query the database to see if the user has any events today
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
                    $whereClause = "WHERE user_id='$user_id' AND fixture_start_dt LIKE '$dateToQuery%'";

                    $query = mysqli_query($con, "SELECT $fieldsRequired FROM user_sports_follows_tb usr $joinSpecify $joinOne $joinTwo $joinThree $whereClause");
                    $count = mysqli_num_rows($query);
                    if($count > 0)
                    {
                      echo "<td class='calendar-day-cell'><h2><a href='/calendar/events/$dateToQuery'>$printDay</a></h2></td>&nbsp;&nbsp;";
                    }
                    else
                    {
                      #-- Not following any sports events at all, so show plain day
                      echo "<td class='calendar-day-cell'><h2>$printDay</h2></td>&nbsp;&nbsp;";
                    }
                  }
                  if(($i % 7) == 6)
                  {
                    #-- End the row, end of the week
                    echo "</tr>&nbsp;&nbsp;";
                  }
                }
                ?>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</header>
