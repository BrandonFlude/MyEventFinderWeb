<?php
if($_COOKIE['MyEventFinder'])
{
  header("Location: /calendar");
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/head.php'); ?>
  <title>My Event Finder | Register</title>
</head>
<body id="page-top">
  <?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/nav.php'); ?>

  <header>
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-4">
          <div class="header-content">
            <div class="header-content-inner">
              <h1>Register Today</h1>
              <h3>It only takes a few seconds to join us...</h3>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="device-container" style="padding-top:75px;">
            <?php include($_SERVER['DOCUMENT_ROOT'].'/assets/forms/index.php'); ?>
            <form method="post">
              <div class="panel panel-default">
                <div class="panel-heading">Join Us</div>
                <div class="panel-body">
                  <div class="form-group">
					          <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $username; ?>">
					        </div>
					        <div class="form-group">
					          <input type="email" class="form-control" placeholder="Email Address" name="email_address" value="<?php echo $email_address; ?>">
					        </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="panel-footer">
                  <input type="submit" class="btn btn-primary btn-block btn-md" value="Confirm Details" name="register_submit">
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
