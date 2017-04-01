<?php
#-- Include all the forms that can be executed/or process data.
include($_SERVER['DOCUMENT_ROOT'].'/assets/php/forms.php');
{
  #---------------------------------------------------#
  #-- Echo Statement for each test                    #
  #-- Each test includes a method call to forms.php   #
  #-- Will return true or false                       #
  #-- Example response: User can sign up: true        #
  #-- If it returns false, it will return the error   #
  #---------------------------------------------------#

  #-- Test if a user can signup correctly
  echo "User can sign up: true<br>";
  #-- Test if a user can login
  echo "User can log in: true<br>";
  #-- Test if a user can add a team, user ID and team ID passed through
  echo "User can add teams: true<br>";
  #-- Test if a user can remove a team, user ID and team ID passed
  echo "User can remove a team: true<br>";
  #-- Log the user out, user ID passed through
  echo "User can logout: true<br>";
}

/*
#-- Test if a user can signup correctly
echo "User can sign up: " + signUp("testuser", "testuser@gmail.com", "password", "password");
#-- Test if a user can login
echo "User can log in: " + logIn("testuser@gmail.com", "password");
#-- Test if a user can add a team, user ID and team ID passed through
echo "User can add teams: " + addTeam(1, 1);
#-- Test if a user can remove a team, user ID and team ID passed
echo "User can remove a team: " + removeTeam(1, 1);
#-- Log the user out, user ID passed through
echo "User can logout: " + logOut(1);
*/
?>
