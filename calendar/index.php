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
  <?php
    include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/calendar.php');
  ?>
</body>
<?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/footer.php'); ?>
