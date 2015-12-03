<?php
// Start the session
session_start();
$id = $_SESSION['id'];
include 'basic.php';
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
                              <li><a href="admin_myinfo.php"><i class="fa fa-gear fa-fw"></i> 회원정보</a>
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
                                  <a href="admin_search.php"><i class="fa fa-search fa-fw"></i> 회원검색</a>
                              </li>
                              <li>
                                  <a href="#"><i class="fa fa-tasks fa-fw"></i> 태스크 관리<span class="fa arrow"></span></a>
                                  <ul class="nav nav-second-level">
                                    <?php
                                    $query = "SELECT Name FROM Task";
                                    $res = mysql_query($query, $con);
                                    $count = mysql_num_rows($res);
                                    for($i = 0; $i < $count; $i++) {
                                      $arr = mysql_fetch_array($res);
                                      echo "<li>";
                                      echo "<a href=\"#\">".$arr['Name']." <span class=\"fa arrow\"></span></a>";
                                      echo "<ul class=\"nav nav-third-level\">";
                                      echo "<li><a href=\"admin_tasksubmitter.php\">제출자 관리</a></li>";
                                      echo "<li><a href=\"admin_taskODT.php\">원본데이터 타입 관리</a></li>";
                                      echo "<li><a style=\"font-size:12px; color:gray;\" href=\"#\">파싱데이터시퀀스파일 수: 3</a></li>";
                                      echo "<li><a style=\"font-size:12px; color:gray;\" href=\"#\">튜플 수: 123</a></li>";
                                      echo "</ul>";
                                      echo "</li>";
                                    }
                                     ?>
                                      <li>
                                        <a href="admin_taskadd.php"><i class="fa fa-plus-circle fa-fw"></i> 태스크 추가하기</a>
                                      </li>
                                  </ul>
                                  <!-- /.nav-second-level -->
                              </li>
                              <li>
                                  <a href="#"><i class="fa fa-users fa-fw"></i> 회원 관리<span class="fa arrow"></span></a>
                                  <ul class="nav nav-second-level">
                                      <li>
                                          <a href="admin_submitter.php">제출자</a>
                                      </li>
                                      <li>
                                          <a href='admin_evaluator.php'>평가자</a>
                                      </li>
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
                          <h1 class="page-header"><i class="fa fa-users fa-fw"></i> 회원관리: 평가자</h1>
                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="page-contents col-lg-7">
                        <div class="panel panel-info">
                          <div class="panel-heading">
                            평가자 목록
                          </div>
                          <div class="panel-body">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>아이디</th>
                                  <th>이름</th>
                                  <th>성별</th>
                                  <th>이메일</th>
                                  <th>휴대폰</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                  #제출자
                                 $query1 = "SELECT * FROM Evaluator";
                                 $result1 = mysql_query($query1, $con);
                                 $count1 = mysql_num_rows($result1);


                                for($i = 0; $i < $count1; $i++) {
                                $arr = mysql_fetch_array($result1);
                                echo "<tr>";
                                echo "<td>".($i+1)."</td>"; #index

                                $tempid=$arr[0];
                                $link_address = "admin_evaluator.php";
                                $link_address = $link_address . "?";
                                $link_address = $link_address . "getid=";
                                $link_address = $link_address . $tempid;
                                echo "<td><a href='$link_address'>".$arr[0]."</a></td>"; #id
                               # echo "<p><a href='login.php'>aa</a></p>";
                               # echo "<td>".$arr[0]."</td>"; #id
                                echo "<td>".$arr[2]."</td>"; #name
                                echo "<td>".$arr[3]."</td>"; #gender
                                echo "<td>".$arr[4]."</td>"; #email
                                echo "<td>".$arr[6]."</td>"; #phone
                                }
                              ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <!-- /.col-lg-8 -->
                      <?php
                      if(!empty($_GET['getid']))
                      {
                        $iidd=$_GET['getid'];

                        $query2 = "SELECT P.ID, P.TaskName, S.Name, P.EvaluatorGrade FROM Submitter AS S, Parsing_Sequence_Data_Type AS P WHERE S.ID = P.SID AND P.EID='$iidd' AND P.Estate=1";
                        $result2 = mysql_query($query2, $con);
                        $count2 = mysql_num_rows($result2);

                      echo '<div class="page-contents col-lg-5">
                        <div class="panel panel-defaubklt">
                          <div class="panel-heading">';
                            echo '<strong>'.$iidd.'</strong> 회원이 평가한 파싱데이터시퀀스파일';
                          echo '</div>
                          <div class="panel-body">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>파일 이름</th>
                                  <th>태스크 이름</th>
                                  <th>제출자 이름</th>';
                            #  echo    '<th>정량평가점수</th>';
                           echo       '<th>정성평가점수</th>
                                </tr>
                              </thead>';
                              echo '<tbody>';
                                for($i = 0; $i < $count2; $i++) {
                                  $task = mysql_fetch_array($result2);
                                  echo '<tr>';
                                  echo "<td>".($i+1)."</td>"; #index
                                  echo "<td>".$task[0]."</td>"; #File ID
                                  echo "<td>".$task[1]."</td>"; #Task Name
                                  echo "<td>".$task[2]."</td>"; #Submitter Name
                                  echo "<td>".$task[3]."</td>"; #EvaluatorGrade

                                  }
                              echo '</tbody>';
                              echo '</table>
                                  </div>
                                </div>
                              </div>
                          </div>';
                        }
                        ?>
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
