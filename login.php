<?php
session_start();
// connect mysqldb and $id = session id
$id = $_SESSION['id'];
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1">
        <title>DataCollector</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <!--Repond.js for IE 8 or less only-->
        <!--[if (lt IE 9) & (IEMobile)]>
        <script src="js/vendor/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <main role="main">
          <div class="page-contents container">
            <div class="row">
              <div class="col-md-4 col-md-offset-4">
                <div style="text-align:center; margin-top:50px; margin-bottom:30px;">
                  <a href="login.html"><img src="img/logo.png" alt="Data_Collector" width="300"></a>
                </div>
                <div class="login-panel panel panel-default" style="padding-top:10px;margin-top:10px;">
                  <div class="panel-body">
                    <form role="form" action="login_validation.php" method="post">
                      <fieldset>
                        <div class="form-group">
                          <input class="form-control" placeholder="아이디" name="ID" id="ID" type="text" autofocus>
                        </div>
                        <div class="form-group">
                          <input class="form-control" placeholder="비밀번호" name="PW" id="PW"vtype="password">
                        </div>
                        <div style="text-align:center">
                          <button class="btn btn-lg btn-info btn-block" type="submit" name="button">로그인</button>
                        </div>
                      </fieldset>
                    </form>
                    <div style="text-align:center; padding-top:14px; padding-bottom:0; margin-bottom:0;">
                      <p><a href="signup.html">회원가입</a></p>
                    </div>
                  </div>
                </div>
              </div>
            </div><!--/.row-->
          </div><!--/.container-->
        </main>
        <footer role="contentinfo">
          <p><small>Copyright &copy; 3girls</small></p>
        </footer>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>
