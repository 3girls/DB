<!doctype html>
<?php
session_start();
// connect mysqldb and $id = session id
$id = $_SESSION['id'];
?>
<?php
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
      else if($_SESSION["id"]!="admin"){
        echo "<script>alert('사용자 권한이 없습니다.'); history.back();</script>";
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
                                      echo "<li><a href=\"admin_tasksubmitter.php?taskname=".$arr['Name']."\">제출자 관리</a></li>";
                                      echo "<li><a href=\"admin_taskODT.php?taskname=".$arr['Name']."\">원본데이터 타입 관리</a></li>";
                                      $query1 = "SELECT COUNT(*) ";
                                      $query1 .= "FROM Task join Parsing_Sequence_Data_Type on Task.Name = Parsing_Sequence_Data_Type.TaskName ";
                                      $query1 .= "WHERE Parsing_Sequence_Data_Type.TaskName = '$arr[0]'";
                                      $result1 = mysql_query($query1, $con);
                                      $arr1 = mysql_fetch_array($result1);
                                      echo "<li style=\"margin-left:53px; margin-top:10px; margin-bottom:15px; font-size:12px; color:gray;\">파싱데이터시퀀스파일 수: ".$arr1[0]."</li>";
                                      
                                      $query2 = "SELECT SUM(Parsing_Sequence_Data_Type.TotalTupleNum) ";
                                      $query2 .= "FROM Task join Parsing_Sequence_Data_Type on Task.Name = Parsing_Sequence_Data_Type.TaskName ";
                                      $query2 .= "WHERE Parsing_Sequence_Data_Type.TaskName = '$arr[0]' AND Parsing_Sequence_Data_Type.P_NP = 1";
                                      $result2 = mysql_query($query2, $con);
                                      $arr2 = mysql_fetch_array($result2);
                                      echo "<li style=\"margin-left:53px; margin-top:15px; margin-bottom:10px; font-size:12px; color:gray;\">튜플 수: ".$arr2[0]."</li>";
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
                          <h1 class="page-header"><i class="fa fa-search fa-fw"></i> 회원검색</h1>
                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="page-contents col-lg-12">
                        <form class="form-inline" method="post" action="admin_search_do.php">
                          <div class="form-group">
                            <label for="usertype">회원유형</label>
                            <select class="form-control" style="width:80px;" name="usertype" id="usertype">
                              <option value="none">전체</option>
                              <option value="submitter">제출자</option>
                              <option value="evaluator">평가자</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="age">나이</label>
                            <input class="form-control" style="width:80px;" type="number" name="ageStart" id="ageStart" placeholder="1" required>
                            ~
                            <input class="form-control" style="width:80px;" type="number" name="ageEnd" id="ageEnd" placeholder="99" required>
                          </div>
                          <div class="form-group">
                            <label for="usertype">성별</label>
                            <select class="form-control" style="width:80px;" name="gender" id="gender">
                              <option value="none">전체</option>
                              <option value="M">남자</option>
                              <option value="F">여자</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="usertype">참여 태스크</label>
                            <select class="form-control" style="width:160px;" naem="task" id="task">
                              <option value="none">전체</option>
                              <?php
                               $query = "SELECT Name FROM Task";
                               $res = mysql_query($query, $con);
                               $count = mysql_num_rows($res);
                               for($i = 0; $i < $count; $i++) {
                                 $arr = mysql_fetch_array($res);
                                 echo "<option value='".$arr['Name']."'>".$arr['Name']."</option>";
                               }
                               ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="ID">아이디</label>
                            <input class="form-control" style="width:160px;" type="text" name="ID" id="ID">
                          </div>
                          <div class="form-group">
                            <button class="btn btn-info" type="submit" name="button">Search</button>
                          </div>
                        </form>
                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="page-contents col-lg-12">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>아이디</th>
                              <th>회원유형</th>
                              <th>이름</th>
                              <th>나이</th>
                              <th>성별</th>
                              <th>이메일</th>
                              <th>휴대폰</th>
                              <th>평가점수</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            #전체

                            #제출자
                            $query1 = "SELECT * FROM Submitter";
                            $result1 = mysql_query($query1, $con);
                            $count1 = mysql_num_rows($result1);
                            #평가자
                            $query2 = "SELECT * FROM Evaluator";
                            $result2 = mysql_query($query2, $con);
                            $count2 = mysql_num_rows($result2);

                            #제출자
                            for($i = 0; $i < $count1; $i++) {
                              $arr = mysql_fetch_array($result1);
                              echo "<tr>";
                              echo "<td>".($i+1)."</td>"; #index
                              echo "<td>".$arr['ID']."</td>"; #id
                              echo "<td>"."제출자"."</td>"; #usertype
                              echo "<td>".$arr['Name']."</td>"; #name
                              echo "<td>";
                              echo date('Y') - substr($arr['Birth'], 0, 4);
                              echo "</td>"; #age
                              echo "<td>".$arr['Gender']."</td>"; #gender
                              echo "<td>".$arr['Email']."</td>"; #email
                              echo "<td>".$arr['Phone']."</td>"; #phone
                              echo "<td>".$arr['Grade']."</td>"; #grade
                            }
                            #평가자
                            for($i = 0; $i < $count2; $i++) {
                              $arr = mysql_fetch_array($result2);
                              echo "<tr>";
                              echo "<td>".($i+1)."</td>"; #index
                              echo "<td>".$arr['ID']."</td>"; #id
                              echo "<td>"."평가자"."</td>"; #usertype
                              echo "<td>".$arr['Name']."</td>"; #name
                              echo "<td>";
                              echo date('Y') - substr($arr['Birth'], 0, 4);
                              echo "</td>"; #age
                              echo "<td>".$arr['Gender']."</td>"; #gender
                              echo "<td>".$arr['Email']."</td>"; #email
                              echo "<td>".$arr['Phone']."</td>"; #phone
                              echo "<td>-</td>"; #grade
                            }
                             ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.col-lg-12 -->
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
