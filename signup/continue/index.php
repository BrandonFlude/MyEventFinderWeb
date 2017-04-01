<?php
#-- Connect to the database
include($_SERVER['DOCUMENT_ROOT'].'/assets/connect/index.php');

#-- Only allow access if they have a cookie
if(!$_COOKIE['MyEventFinder'])
{
  header("Location: /login");
}
else
{
  $cookie = $_COOKIE['MyEventFinder'];
  $encryptedCookie = md5($cookie);
  $query = mysqli_query($con, "SELECT user_id FROM user_authentications_tb WHERE authentication_key='$encryptedCookie'");
  $count = mysqli_num_rows($query);
  if($count == 1)
  {
    #-- Cookie exists, user is legitimate
    #-- Start to pull all of their information
    $row = mysqli_fetch_assoc($query);
    $user_id = $row['user_id'];

    #-- If they have a cookie, see if they've already completed setup.
    $query = mysqli_query($con, "SELECT * FROM users_sports_follows_tb WHERE user_id='$user_id'");
    $count = mysqli_num_rows($query);
    if($count > 0)
    {
      #-- They've completed it already, directed to settings
      header("Location: /settings");
    }
    else
    {
      #-- Do nothing
    }
  }
}
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/head.php'); ?>
  <title>My Event Finder | Complete Registration</title>
</head>
<body id="page-top">
  <?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/nav.php'); ?>

  <header>
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-4">
          <div class="header-content">
            <div class="header-content-inner">
              <h2>Please give us some more information...</h2>
              <h3>Select Sports Teams you follow, leave them blank if you're not sure.</h3>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="device-container" style="padding-top:75px;">
            <?php include($_SERVER['DOCUMENT_ROOT'].'/assets/forms/index.php'); ?>
            <form method="post">
              <div class="panel panel-default">
                <div class="panel-heading">Select a Football Team</div>
                <div class="panel-body">
                  <div class="form-group">
					          <select name="football_team" class="form-control">
                      <option value="NULL">Don't Follow</option>
                      <?php
                        $query = mysqli_query($con, "SELECT team_id, team_nm FROM teams_tb WHERE league_id='1' ORDER BY team_nm ASC");
                        while($row = mysqli_fetch_assoc($query))
                        {
                          $team_id = $row['team_id'];
                          $team_nm = $row['team_nm'];
                          echo '<option value="' . $team_id .'">' . $team_nm . '</option>';
                        }
                      ?>
                    </select>
					        </div>
                </div>
                <div class="panel-heading">Select an NFL Team</div>
                <div class="panel-body">
                  <div class="form-group">
					          <select name="nfl_team" class="form-control">
                      <option value="NULL">Don't Follow</option>
                      <?php
                        $query = mysqli_query($con, "SELECT team_id, team_nm FROM teams_tb WHERE league_id='2' ORDER BY team_nm ASC");
                        while($row = mysqli_fetch_assoc($query))
                        {
                          $team_id = $row['team_id'];
                          $team_nm = $row['team_nm'];
                          echo '<option value="' . $team_id .'">' . $team_nm . '</option>';
                        }
                      ?>
                    </select>
					        </div>
                </div>
                <div class="panel-heading">Select a Hockey Team</div>
                <div class="panel-body">
                  <div class="form-group">
					          <select name="hockey_team" class="form-control">
                      <option value="NULL">Don't Follow</option>
                      <?php
                        $query = mysqli_query($con, "SELECT team_id, team_nm FROM teams_tb WHERE league_id='3' ORDER BY team_nm ASC");
                        while($row = mysqli_fetch_assoc($query))
                        {
                          $team_id = $row['team_id'];
                          $team_nm = $row['team_nm'];
                          echo '<option value="' . $team_id .'">' . $team_nm . '</option>';
                        }
                      ?>
                    </select>
					        </div>
                </div>
                <div class="panel-heading">Select a Basketball Team</div>
                <div class="panel-body">
                  <div class="form-group">
					          <select name="basketball_team" class="form-control">
                      <option value="NULL">Don't Follow</option>
                      <?php
                        $query = mysqli_query($con, "SELECT team_id, team_nm FROM teams_tb WHERE league_id='4' ORDER BY team_nm ASC");
                        while($row = mysqli_fetch_assoc($query))
                        {
                          $team_id = $row['team_id'];
                          $team_nm = $row['team_nm'];
                          echo '<option value="' . $team_id .'">' . $team_nm . '</option>';
                        }
                      ?>
                    </select>
					        </div>
                </div>
                <div class="panel-footer">
                  <input type="submit" class="btn btn-primary btn-block btn-md" value="Confirm Selections" name="register_continue_submit">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </header>

  <?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/footer.php'); ?>
</body>
</html>
