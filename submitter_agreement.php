<!doctype html>
<?php
// Start the session
session_start();
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
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div id="wrapper">

              <!-- Navigation -->
              <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                  <div class="navbar-header">
                      <a class="navbar-brand" href="_index.html">
                        <img src="img/logo.png" alt="DataCollector" width="180">
                      </a>
                  </div>
                  <!-- /.navbar-header -->

                  <ul class="nav navbar-top-links navbar-right">
                      <!-- /.dropdown -->
                      <li class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            MY GRADE
                          </a>
                          <ul class="dropdown-menu dropdown-grade" style="text-align:center;">
                              <li>
                                <?php
                                $query ="SELECT Grade FROM Submitter WHERE ID='$id'";
                                $res = mysql_query($query, $con);
                                $arr = mysql_fetch_array($res);
                                echo $arr['Grade'];
                                 ?>
                                Points
                              </li>
                          </ul>
                      </li>
                      <li class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                              <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                          </a>
                          <ul class="dropdown-menu dropdown-user">
                              <li><a href="submitter_myinfo.php"><i class="fa fa-gear fa-fw"></i> 회원정보</a>
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
                                  <a href="submitter_task.php"><i class="fa fa-tasks fa-fw"></i> 태스크 참가 관리</a>
                              </li>
                              <li>
                                  <a href="#"><i class="fa fa-tasks fa-fw"></i> 참가 중인 태스크<span class="fa arrow"></span></a>
                                  <ul class="nav nav-second-level">
                                      <?php
                                     if (!empty($_GET['sid']))
                                    { $sid=$_GET['sid'];
                                      $query = "SELECT Name FROM Participate, Task ";
                                      $query .= "WHERE Participate.SID='$sid' AND Participate.TaskName = Task.Name AND Participate.Accept=1";
                                      $res = mysql_query($query, $con);
                                      $count = mysql_num_rows($res);
                                      for($i = 0; $i < $count; $i++) {
                                        $arr = mysql_fetch_array($res);
                                        echo "<li>";
                                        echo "<a href='submitter_taskup.php?sid=".$sid."&taskname=".$arr['Name']."'>".$arr['Name']." <span class=\"fa arrow\"></span></a>";
                                        echo "</li>";
                                      }
                                    }
                                     ?>
                                  </ul>
                                  <!-- /.nav-second-level -->
                              </li>
                          </ul>
                      </div>
                      <!-- /.sidebar-collapse -->
                  </div>
                  <!-- /.navbar-static-side -->
              </nav>
              <?php
              if(!empty($_GET['sid']))
              {
                $sid=$_GET['sid'];
                $taskname = $_GET['taskname'];

             echo '<div id="page-wrapper">
                  <div class="row">
                      <div class="col-lg-11">
                          <h1 class="page-header" style="text-align: center;"> 개인 정보 이용 동의</h1>
                      </div>
                      <div class="page-contents col-lg-2">
                      </div>
                      <div class="page-contents col-lg-7">
                        <div class="panel panel-default">';
                        echo '<div class="panel-body">
                            <table class="table table-bordered">
                                <tbody>
                                  <tr>
                                    <td> 저희 DataCollector는 태스크에 참여하고자 하는 제출자의 개인정보를 수집하고 있습니다.<br />
                                         개인정보 수집에 동의하셔야 태스크 참여 신청이 가능합니다.<br />
                                         이에 동의하십니까?<br />
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <div style="text-align: center;">';
                             echo "<td><button class=\"btn btn-sm btn-success\" onclick=\"location.href='submitter_task_do.php?sid=".$sid."&taskname=".$taskname."'\" type=\"button\" name=\"button\">동의합니다.</button></td>";
                             echo "&nbsp;";
                             echo "&nbsp;";
                             echo "&nbsp;";
                             echo "&nbsp;";
                             echo "&nbsp;";
                             echo "&nbsp;";
                             echo "&nbsp;";
                             echo "&nbsp;";
                             echo "<td><button class=\"btn btn-sm btn-danger\" onclick=\"location.href='submitter_task.php'\" type=\"button\" name=\"button\">동의하지 않습니다.</button></td>";
                         echo  '</div>
                          </div>
                       </div>
                      </div>
                      </div>
                  </div>';
                }
                ?>

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
