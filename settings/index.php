<?php
if($_COOKIE['MyEventFinder'])
{
  #-- Connect to the backend
  include($_SERVER['DOCUMENT_ROOT'].'/assets/connect/index.php');

  $cookie = $_COOKIE['MyEventFinder'];
  #-- Check legitimacy of cookie
  $encryptedCookie = md5($cookie);
  $query = mysqli_query($con, "SELECT * FROM user_authentications_tb, users_tb WHERE authentication_key='$encryptedCookie' AND user_authentications_tb.user_id = users_tb.user_id");
  $count = mysqli_num_rows($query);
  if($count == 1)
  {
    #-- Cookie exists, user is legitimate
    #-- Start to pull all of their information
    $row = mysqli_fetch_assoc($query);
    $user_id = $row['user_id'];
    $user_email = $row['user_email'];
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
  <title>My Event Finder | Calendar</title>
</head>
<body>
  <?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/nav.php'); ?>
  <header>
    <br><br><br><br>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <?php include($_SERVER['DOCUMENT_ROOT'].'/assets/forms/index.php'); ?>
          <div class="panel panel-default">
            <div class="panel-heading">Update Email Address & Password</div>
            <form method="post">
              <div class="panel-body">
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12">
                      <input type="email" class="form-control" placeholder="MyEventFinder@gmail.com" name="email" value="<?php echo $user_email; ?>">
                    </div>
                  </div>
                </div>
                <hr>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12">
                      <input type="password" class="form-control" placeholder="Current Password" name="current_password">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12">
                      <input type="password" class="form-control" placeholder="New Password" name="new_password">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12">
                      <input type="password" class="form-control" placeholder="Confirm New Password" name="confirm_new_password">
                    </div>
                  </div>
                </div>
              </div>
              <div class="panel-footer">
                <input type="submit" class="btn btn-primary btn-block" value="Update" name="updateemailpassword">
              </div>
            </form>
          </div>
          <!--[END OF EMAIL, START OF TEAMS]-->
          <div class="panel panel-default">
            <div class="panel-heading">Edit Premier League Teams</div>
            <form method="post">
              <div class="panel-body">
                <?php
                  $query = mysqli_query($con, "SELECT * FROM teams_tb WHERE league_id='1' ORDER BY team_nm ASC");
                  $count = mysqli_num_rows($query);
                  while($row = mysqli_fetch_assoc($query))
                  {
                    $team_id = $row['team_id'];
                    $team_nm = $row['team_nm'];

                    $checkifMyTeam = mysqli_query($con, "SELECT * FROM user_sports_follows_tb WHERE user_id='$user_id' AND team_id='$team_id'");
                    $MyTradeCount = mysqli_num_rows($checkifMyTeam);
                    if($MyTradeCount == 1)
                    {
                      $checked = " checked";
                    }
                    else
                    {
                      $checked = "";
                    }
                    echo '<div class="col-md-4">
                      <div class="checkbox">
                        <label><input name="' . $team_id . '" type="checkbox" value="' . $team_id . '"'. $checked .'>' . $team_nm . '</label>
                      </div>
                    </div>';
                  }
                ?>
              </div>
              <div class="panel-footer panel-heading-alt">Edit NFL Teams</div>
              <div class="panel-body">
                <?php
                  $query = mysqli_query($con, "SELECT * FROM teams_tb WHERE league_id='2' ORDER BY team_nm ASC");
                  $count = mysqli_num_rows($query);
                  while($row = mysqli_fetch_assoc($query))
                  {
                    $team_id = $row['team_id'];
                    $team_nm = $row['team_nm'];

                    $checkifMyTeam = mysqli_query($con, "SELECT * FROM user_sports_follows_tb WHERE user_id='$user_id' AND team_id='$team_id'");
                    $MyTradeCount = mysqli_num_rows($checkifMyTeam);
                    if($MyTradeCount == 1)
                    {
                      $checked = " checked";
                    }
                    else
                    {
                      $checked = "";
                    }
                    echo '<div class="col-md-4">
                      <div class="checkbox">
                        <label><input name="' . $team_id . '" type="checkbox" value="' . $team_id . '"'. $checked .'>' . $team_nm . '</label>
                      </div>
                    </div>';
                  }
                ?>
              </div>
              <div class="panel-footer panel-heading-alt">Edit NHL Teams</div>
              <div class="panel-body">
                <?php
                  $query = mysqli_query($con, "SELECT * FROM teams_tb WHERE league_id='3' ORDER BY team_nm ASC");
                  $count = mysqli_num_rows($query);
                  while($row = mysqli_fetch_assoc($query))
                  {
                    $team_id = $row['team_id'];
                    $team_nm = $row['team_nm'];

                    $checkifMyTeam = mysqli_query($con, "SELECT * FROM user_sports_follows_tb WHERE user_id='$user_id' AND team_id='$team_id'");
                    $MyTradeCount = mysqli_num_rows($checkifMyTeam);
                    if($MyTradeCount == 1)
                    {
                      $checked = " checked";
                    }
                    else
                    {
                      $checked = "";
                    }
                    echo '<div class="col-md-4">
                      <div class="checkbox">
                        <label><input name="' . $team_id . '" type="checkbox" value="' . $team_id . '"'. $checked .'>' . $team_nm . '</label>
                      </div>
                    </div>';
                  }
                ?>
              </div>
              <div class="panel-footer panel-heading-alt">Edit NBA Teams</div>
              <div class="panel-body">
                <?php
                  $query = mysqli_query($con, "SELECT * FROM teams_tb WHERE league_id='4' ORDER BY team_nm ASC");
                  $count = mysqli_num_rows($query);
                  while($row = mysqli_fetch_assoc($query))
                  {
                    $team_id = $row['team_id'];
                    $team_nm = $row['team_nm'];

                    $checkifMyTeam = mysqli_query($con, "SELECT * FROM user_sports_follows_tb WHERE user_id='$user_id' AND team_id='$team_id'");
                    $MyTradeCount = mysqli_num_rows($checkifMyTeam);
                    if($MyTradeCount == 1)
                    {
                      $checked = " checked";
                    }
                    else
                    {
                      $checked = "";
                    }
                    echo '<div class="col-md-4">
                      <div class="checkbox">
                        <label><input name="' . $team_id . '" type="checkbox" value="' . $team_id . '"'. $checked .'>' . $team_nm . '</label>
                      </div>
                    </div>';
                  }
                ?>
              </div>
              <div class="panel-footer panel-heading-alt">Edit MLB Teams</div>
              <div class="panel-body">
                <?php
                  $query = mysqli_query($con, "SELECT * FROM teams_tb WHERE league_id='6' ORDER BY team_nm ASC");
                  $count = mysqli_num_rows($query);
                  while($row = mysqli_fetch_assoc($query))
                  {
                    $team_id = $row['team_id'];
                    $team_nm = $row['team_nm'];

                    $checkifMyTeam = mysqli_query($con, "SELECT * FROM user_sports_follows_tb WHERE user_id='$user_id' AND team_id='$team_id'");
                    $MyTradeCount = mysqli_num_rows($checkifMyTeam);
                    if($MyTradeCount == 1)
                    {
                      $checked = " checked";
                    }
                    else
                    {
                      $checked = "";
                    }
                    echo '<div class="col-md-4">
                      <div class="checkbox">
                        <label><input name="' . $team_id . '" type="checkbox" value="' . $team_id . '"'. $checked .'>' . $team_nm . '</label>
                      </div>
                    </div>';
                  }
                ?>
              </div>
              <div class="panel-footer">
                <input type="submit" class="btn btn-primary btn-block" value="Update" name="updateteams">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>
</body>
<?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/footer.php'); ?>
