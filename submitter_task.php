<?php
session_start();
// connect mysqldb and $id = session id
$id = $_SESSION['id'];
?>
<?php
// Start the session
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
                                      $query = "SELECT Name FROM Participate, Task ";
                                      $query .= "WHERE Participate.SID='$id' AND Participate.TaskName = Task.Name AND Participate.Accept=1";
                                      $res = mysql_query($query, $con);
                                      $count = mysql_num_rows($res);
                                      for($i = 0; $i < $count; $i++) {
                                        $arr = mysql_fetch_array($res);
                                        echo "<li>";
                                        echo "<a href='submitter_taskup.php?sid=".$id."&taskname=".$arr['Name']."'>".$arr['Name']." <span class=\"fa arrow\"></span></a>";
                                        echo "</li>";

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

              <div id="page-wrapper">
                  <div class="row">
                      <div class="col-lg-12">
                          <h1 class="page-header"><i class="fa fa-users fa-fw"></i> 태스크 참가 관리</h1>
                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="page-contents col-lg-7">
                        <div class="panel panel-info">
                          <div class="panel-heading">
                            참여신청 가능 태스크
                          </div>
                          <div class="panel-body">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>태스크 이름</th>
                                  <th>-</th>
                                </tr>
                              </thead>
                              <tbody>
                         <!--       <tr>
                                  <td>1</td>
                                  <td>태스크1</td>
                                  <td><button class="btn btn-sm btn-success" type="button" name="button">참여신청</button></td>
                                </tr>
                          -->
                                <?php
                                #일단 해당 제출자의 모든 태스크 목록과 상태를 보여주자
                                $query2 = "SELECT Task.Name FROM Task WHERE not exists (SELECT * FROM Participate WHERE Participate.SID = '$id' AND Participate.TaskName = Task.Name)";
                                $result2 = mysql_query($query2, $con);
                                $count2 = mysql_num_rows($result2);

                                for($i = 0; $i < $count2; $i++) {
                                  $arr = mysql_fetch_array($result2);
                                  echo "<tr>";
                                  echo "<td>".($i+1)."</td>"; #index
                                  echo "<td>".$arr[0]."</td>"; #Task Name
                                  echo "<td><button class=\"btn btn-sm btn-success\" onclick=\"location.href='submitter_agreement.php?sid=".$id."&taskname=".$arr[0]."'\" type=\"button\" name=\"button\">참여 신청하기</button></td>";
                                  echo "</tr>";
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-lg-8 -->
                      <div class="page-contents col-lg-5">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <strong><?=$id?></strong> 님의 참여신청 대기 태스크
                          </div>
                          <div class="panel-body">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>태스크 이름</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  #참여신청 대기 태스크 목록
                                  #Participate.Accept = 2
                                 $query1 = "SELECT Name FROM Task, Participate ";
                                 $query1 .= "WHERE Participate.SID = '$id' AND Participate.TaskName = Task.Name AND Participate.Accept=2";
                                 $result1 = mysql_query($query1, $con);
                                 $count1 = mysql_num_rows($result1);


                                for($i = 0; $i < $count1; $i++) {
                                $arr = mysql_fetch_array($result1);
                                echo "<tr>";
                                echo "<td>".($i+1)."</td>"; #index
                                echo "<td>".$arr[0]."</td>"; #Task Name
                                echo "</tr>";
                                }
                              ?>
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
