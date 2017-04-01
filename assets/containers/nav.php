<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
      </button>
      <a class="navbar-brand page-scroll" href="/">My Event Finder</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a class="page-scroll" href="/download">Download</a></li>
        <?php
        $homepage = "/";
        $currentpage = $_SERVER['REQUEST_URI'];
        if($homepage == $currentpage) {
          echo '<li><a class="page-scroll" href="#features">Features</a></li>';
        }
        else
        {
          echo '<li><a class="page-scroll" href="/#features">Features</a></li>';
        }

        if($_COOKIE['MyEventFinder'])
        {
          #-- Connect to the backend
          $con = mysqli_connect("localhost","teamproject_tb","password","teamproject_db");
          if (mysqli_connect_errno()) {
            header("Location: /errors/sql");
          }

          $cookie = $_COOKIE['MyEventFinder'];
          #-- Check legitimacy of cookie
          $encryptedCookie = md5($cookie);
          $query = mysqli_query($con, "SELECT user_id FROM user_authentications_tb WHERE authentication_key='$encryptedCookie'");
          $count = mysqli_num_rows($query);
          if($count == 1)
          {
            echo '
            <li><a class="page-scroll" href="/calendar">Calendar</a></li>
            <li><a class="page-scroll" href="/settings">Settings</a></li>
            <li><a class="page-scroll" href="/logout">Logout</a></li>
            ';
          }
          else
          {
            echo '
            <li><a class="page-scroll" href="/login">Login</a></li>
            <li><a class="page-scroll" href="/signup">Register</a></li>
            ';
          }
        }
        else
        {
          #-- Destroy cookie
          ob_start();
          setcookie("MyEventFinder", "", time() - (86400 * 30), "/");
          ob_end_flush();

          echo '
          <li><a class="page-scroll" href="/login">Login</a></li>
          <li><a class="page-scroll" href="/signup">Register</a></li>
          ';
        }
        ?>
      </ul>
    </div>
  </div>
</nav>
