<?php
// Start the session
session_start();
// connect mysqldb and $id = session id
$id = $_SESSION['id'];
include 'basic.php';
?>
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
        <!-- MetisMenu CSS -->
        <link rel="stylesheet" href="bower_components/metisMenu/dist/metisMenu.min.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="dist/css/sb-admin-2.css">
        <!-- Morris Charts CSS -->
        <link rel="stylesheet" href="bower_components/morrisjs/morris.css">
        <!-- Custom Fonts -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
        <script src="js/sign_validation.js"></script>
        <!--Repond.js for IE 8 or less only-->
        <!--[if (lt IE 9) & (IEMobile)]>
        <script src="js/vendor/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    <?php
      if(!isset($_SESSION["id"])){
       echo "<script>location.replace('login.php');</script>";
      }
      ?>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div id="wrapper">

              <!-- Navigation -->
              <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                  <div class="navbar-header">
                      <a class="navbar-brand" href="index.php">
                        <img src="img/logo.png" alt="DataCollector" width="180">
                      </a>
                  </div>
                  <!-- /.navbar-header -->

                  <ul class="nav navbar-top-links navbar-right">
                      <!-- /.dropdown -->
                      <li class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                              <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                          </a>
                          <ul class="dropdown-menu dropdown-user">
                              <li><a href="evaluator_myinfo.php"><i class="fa fa-gear fa-fw"></i> 회원정보</a>
                              </li>
                              <li class="divider"></li>
                              <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> 로그아웃</a>
                              </li>
                          </ul>
                          <!-- /.dropdown-user -->
                      </li>
                      <!-- /.dropdown -->
                  </ul>
                  <!-- /.navbar-top-links -->

                  <div class="navbar-default sidebar" role="navigation">
                      <div class="sidebar-nav navbar-collapse">
                          <ul class="nav" id="side-menu">
                              <li>
                                  <a href="evaluator_waiting.php"><i class="fa fa-spinner fa-fw"></i> 평가대기 파일</a>
                              </li>
                              <li>
                                  <a href="evaluator_check.php"><i class="fa fa-check fa-fw"></i> 평가완료 파일</a>
                              </li>
                          </ul>
                      </div>
                      <!-- /.sidebar-collapse -->
                  </div>
                  <!-- /.navbar-static-side -->
              </nav>

              <div id="page-wrapper">
                <div class="row">
                  <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-spinner fa-fw"></i> 평가대기 파일</h1>
                  </div>
                  <div class="page-contents col-lg-12">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        평가대기 중인 파싱시퀀스파일
                      </div>
                      <div class="panel-body">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>태스크 이름</th>
                              <th>파싱시퀀스 파일</th>
                              <th>상태</th>
                              <th>평가하기</th>
                              <th></th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          $query = "SELECT * FROM Parsing_Sequence_Data_Type WHERE EID='".$id."' AND Estate='0'";
                          $res = mysql_query($query, $con);
                          $count = mysql_num_rows($res);

                          for($i = 0; $i < $count; $i++) {
                            $arr = mysql_fetch_array($res);
                            echo "<tr>
                              <td>".($i+1)."</td>
                              <td>".$arr['TaskName']."</td>
                              <td><a href=\"/psf_directory/".$arr[ID]."\"download=\"/psf_directory/".$arr[ID]."\">".$arr['ID']."</a></td>
                              <td>대기중</td>
                              <form class=\"form-inline\" method=\"post\" action=\"evaluator_grade.php?fid=".$arr['ID']."\">
                                <td>
                                  <input class=\"form-control\" type=\"number\" name=\"grade\" id=\"grade\">
                                </td>
                                <td>
                                  <div class=\"form-group\">
                                    <label class=\"radio-inline\">
                                      <input type=\"radio\" name=\"PNP\" value=\"1\" checked>P
                                    </label>
                                    <label class=\"radio-inline\">
                                      <input type=\"radio\" name=\"PNP\" value=\"0\">NP
                                    </label>
                                  </div>
                                </td>
                                </td>
                                <td>
                                  <button class=\"btn btn-success btn-sm\" type=\"submit\" name=\"button\">
                                    <i class=\"fa fa-check fa-fw\"></i>
                                  </button>
                                </td>
                              </form>
                            </tr>";
                          }
                           ?>
                            <!-- SAMPLE
                            <tr>
                              <td>1</td>
                              <td>태스크1</td>
                              <td><a href=""download="evaluator.html">파일이름</a></td>
                              <td>대기중</td>
                              <td>
                                <form class="form-inline">
                                  <input class="form-control" type="number">
                                  <button class="btn btn-success btn-sm" type="submit" name="button">
                                    <i class="fa fa-check fa-fw"></i>
                                  </button>
                                </form>
                              </td>
                            </tr>
                          -->
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /#page-wrapper -->

          </div>
          <!-- /#wrapper -->
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
