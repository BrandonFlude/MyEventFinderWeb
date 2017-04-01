<?php
$con = mysqli_connect("localhost","teamproject_tb","password","teamproject_db");
if (mysqli_connect_errno()) {
  header("Location: /errors/sql");
}
?>
