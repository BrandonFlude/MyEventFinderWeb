<?php
#-- Connect to the backend
include($_SERVER['DOCUMENT_ROOT'].'/assets/connect/index.php');

#-- Error Messages
$ERROR_emailInvalid = "That email address is not valid, please try again.";
$ERROR_emailTaken = "That email address is already in use, please try again.";
$ERROR_usernameTaken = "That username is already in use, please try again.";
$ERROR_passwordsDontMatch = "Your passwords didn't match, please try again.";
$ERROR_didNotFillOut = "You did not fill out all of the required fields, please try again.";
$ERROR_userNotFound = "Your email address and password did not match, please try again.";
$ERROR_noSelections = "You need to select at least <strong>ONE</strong> sports team.";

#-- Registration Page Signup Form
if($_POST['register_submit'])
{
  #-- Hit Submit, collect all the info they sent through the form
  $username = $_POST['username'];
  $email_address = $_POST['email_address'];
  $password = md5($_POST['password']);
  $confirm_password = md5($_POST['confirm_password']);

  #-- See if they filled in all the fields
  if($username && $email_address && $password && $confirm_password)
  {
    #-- First we need to see if the email address is valid
    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL) === false)
    {
      #-- Check if the email is taken
      $query = mysqli_query($con, "SELECT user_email FROM users_tb WHERE user_email='$email_address'");
      $count = mysqli_num_rows($query);
      if($count < 1)
      {
        #-- Email Address is valid, proceed
        #-- Check if the username is already in the database
        $query = mysqli_query($con, "SELECT username_nm FROM users_tb WHERE username_nm='$username'");
        $count = mysqli_num_rows($query);
        if($count < 1)
        {
          #-- Username is available, check if passwords match
          if($password == $confirm_password)
          {
            #-- All data is fine, go ahead and insert into the database
            $insert = mysqli_query($con, "INSERT INTO users_tb VALUES ('', '$username', '$email_address', '$password', '0')");
            #-- Forward them to the login screen
            header("Location: /login");
          }
          else
          {
            #-- Passwords don't match
            echo '
            <div class="alert alert-warning alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              ' . $ERROR_passwordsDontMatch . '
            </div>';
          }
        }
        else
        {
          #-- Someone has this username, show an error
          echo '
          <div class="alert alert-warning alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            ' . $ERROR_usernameTaken . '
          </div>';
        }
      }
      else
      {
        #-- Email Address is already in use, so show an error
        echo '
        <div class="alert alert-warning alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          ' . $ERROR_emailTaken . '
        </div>';
      }
    }
    else
    {
      #-- Email Address isn't valid, so show an error
      echo '
      <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        ' . $ERROR_emailInvalid . '
      </div>';
    }
  }
  else
  {
    #-- Didn't enter all of the fields
    echo '
    <div class="alert alert-danger alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      ' . $ERROR_didNotFillOut . '
    </div>';
  }
}

#-- Registration Page Continue Signup Form
if($_POST['register_continue_submit'])
{
  $football_team = $_POST['football_team'];
  $nfl_team = $_POST['nfl_team'];
  $hockey_team = $_POST['hockey_team'];
  $basketball_team = $_POST['basketball_team'];

  if($football_team != "NULL" || $nfl_team != "NULL" || $hockey_team != "NULL")
  {
    #-- Didn't select no team for all, add to the database
    if($football_team != "NULL")
    {
      $insertFootball = mysqli_query($con, "INSERT INTO user_sports_follows_tb VALUES ('', '$user_id', '$football_team')");
    }
    if($nfl_team != "NULL")
    {
      $insertNFL = mysqli_query($con, "INSERT INTO user_sports_follows_tb VALUES ('', '$user_id', '$nfl_team')");
    }
    if($hockey_team != "NULL")
    {
      $insertHockey = mysqli_query($con, "INSERT INTO user_sports_follows_tb VALUES ('', '$user_id', '$hockey_team')");
    }
    if($basketball_team != "NULL")
    {
      $insertBasketball = mysqli_query($con, "INSERT INTO user_sports_follows_tb VALUES ('', '$user_id', '$basketball_team')");
    }
    #-- Inserted all the data we needed to, forward them to their calendar
    header("Location: /calendar");
  }
  else
  {
    #-- Selected null for all teams, show an error
    echo '
    <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      ' . $ERROR_noSelections . '
    </div>';
  }

}

#-- Login Form
if($_POST['login_submit']){
  #-- Collect Information they passed through the form
  $email_address = $_POST['email_address'];
  $password = md5($_POST['password']);

  if($email_address && $password)
  {
    #-- Both fields entered, see if we have a match
    $query = mysqli_query($con, "SELECT user_id FROM users_tb WHERE user_email='$email_address' AND user_password_enc='$password'");
    $count = mysqli_num_rows($query);
    if($count > 0)
    {
      #-- User exists
      #-- Grab User ID
      $row = mysqli_fetch_assoc($query);
      $user_id = $row['user_id'];

      #-- Create a cookie to keep them logged in
      $length = 30;
      $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
      $encryptedCookie = md5($randomString);

      #-- Insert authentication key into database
      $date = date('Y-m-d | H:i:s');
      $insert = mysqli_query($con, "INSERT INTO user_authentications_tb VALUES ('', '$user_id', '$encryptedCookie', '$date')");

      #-- Create Cookie
      ob_start();
      setcookie("MyEventFinder", $randomString, time() + (86400 * 30), "/");
      ob_end_flush();

      #-- See if they need to continue signing up
      $query = mysqli_query($con, "SELECT * FROM user_sports_follows_tb WHERE user_id='$user_id'");
      $count = mysqli_num_rows($query);
      if($count == 0)
      {
        #-- Forward them to continue the set up of their profile
        header("Location: /signup/continue");
      }
      else
      {
        #-- Forward to their calendar
        header("Location: /calendar");
      }
    }
    else
    {
      #-- Incorrect information
      echo '
      <div class="alert alert-danger alert-dismissable">
        <a href="#" class="cloe" data-dismiss="alert" aria-label="close">&times;</a>
        ' . $ERROR_userNotFound . '
      </div>';
    }
  }
  else
  {
    #-- Didn't enter all of the fields
    echo '
    <div class="alert alert-danger alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      ' . $ERROR_didNotFillOut . '
    </div>';
  }
}

if($_POST['updateteams'])
{
  #-- Delete all records of users team follows in the database
  $delete = mysqli_query($con, "DELETE FROM user_sports_follows_tb WHERE user_id='$user_id'");

  #-- Loop through all of the optional teams in the database
  $query = mysqli_query($con, "SELECT * FROM teams_tb");
  while($row = mysqli_fetch_assoc($query))
  {
    $team_id = $row['team_id'];
    if(isset($_POST[$team_id]))
    {
      $add = mysqli_query($con, "INSERT INTO user_sports_follows_tb VALUES ('', '$user_id', '$team_id')");
    }
  }
  echo '
  <div class="alert alert-success" role="alert">
    <center>Your teams have been updated successfully, your calendar has been updated accordingly.</center>
  </div>';
}


if($_POST['updateemailpassword'])
{
  $curEmail = $user_email;
  $newEmail = $_POST['email'];
  $defValue = $curPassword;
  $curPassword = md5($_POST['current_password']);
  $newPassword = md5($_POST['new_password']);
  $confirmNewPassword = md5($_POST['confirm_new_password']);

  if($curEmail == $newEmail)
  {
    #–- Email hasn't been changed, just update password
    $query = mysqli_query($con, "SELECT * FROM users_tb WHERE user_id='$user_id' AND user_password_enc='$curPassword'");
    $numrows = mysqli_num_rows($query);
    if($numrows == 1)
    {
      #-- Password is a match, check if new passwords are identical
      if($newPassword == $confirmNewPassword)
      {
        #-- Identical, update password
        $update = mysqli_query($con, "UPDATE users_tb SET user_password_enc='$newPassword' WHERE user_id='$user_id'");
        header("Location: /logout");
      }
      else
      {
        #-- Passwords did not match
        echo '
        <div class="alert alert-warning alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          ' . $ERROR_passwordsDontMatch . '
        </div>';
      }
    }
    else
    {
      #-- Password was incorrect
      echo '
      <div class="alert alert-warning alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        The password you entered was incorrect.
      </div>';
    }
  }
  else
  {
    #–- Email has changed
    if($defValue != "")
    {
      #-- Passwords changed too
      $query = mysqli_query($con, "SELECT * FROM users_tb WHERE user_id='$user_id' AND user_password_enc='$curPassword'");
      $numrows = mysqli_num_rows($query);
      if($numrows == 1)
      {
        #-- Password is a match, check if new passwords are identical
        if($newPassword == $confirmNewPassword)
        {
          #-- Identical, update password
          $update = mysqli_query($con, "UPDATE users_tb SET user_password_enc='$newPassword' WHERE user_id='$user_id'");
          header("Location: /logout");
        }
        else
        {
          #-- Passwords did not match
          echo '
          <div class="alert alert-warning alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            ' . $ERROR_passwordsDontMatch . '
          </div>';
        }
      }
      else
      {
        #-- Password was incorrect
        echo '
        <div class="alert alert-warning alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          The password you entered was incorrect.
        </div>';
      }
    }
    else
    {
      #–- Just the email
      $query = mysqli_query($con, "SELECT * FROM users_tb WHERE user_id='$user_id' AND user_email='$curEmail'");
      $numrows = mysqli_num_rows($query);
      if($numrows == 1)
      {
        #-- Match, update email
        $update = mysqli_query($con, "UPDATE users_tb SET user_email='$newEmail' WHERE user_id='$user_id'");
        header("Location: /logout");
      }
      else
      {
        #-- Email isn't in the database
        echo '
        <div class="alert alert-warning alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          The email address you entered is not registered to you.
        </div>';
      }
    }
  }
}
?>
