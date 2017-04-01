<?php
if($_COOKIE['MyEventFinder'])
{
  header("Location: /calendar");
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/head.php'); ?>
  <title>My Event Finder | Log In</title>
</head>
<body id="page-top">
  <?php include($_SERVER['DOCUMENT_ROOT'].'/assets/containers/nav.php'); ?>

  <header>
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-12">
          <div class="device-container" style="padding-top:75px;">
            <?php include($_SERVER['DOCUMENT_ROOT'].'/assets/forms/index.php'); ?>
            <form method="post">
              <div class="panel panel-default">
                <div class="panel-heading">Log In</div>
                <div class="panel-body">
					        <div class="form-group">
					          <input type="email" class="form-control" placeholder="Email Address" name="email_address">
					        </div>
                  <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                  </div>
                </div>
                <div class="panel-footer">
                  <input type="submit" class="btn btn-primary btn-block btn-md" value="Log In" name="login_submit">
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
