<!doctype html>
<?php
// Start the session
#session_start();
#$id = $_SESSION['id'];
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
                      <div class="col-lg-12">';
                          echo '<h1 class="page-header"><i class="fa fa-users fa-fw"></i> 참가 중인 태스크: '.$taskname.'</h1>';
                      echo '</div>
                      <!-- /.col-lg-12 -->
                      <div class="page-contents col-lg-12">
                        <form class="form-inline" enctype="multipart/form-data" method="post" action="submitter_taskup_do.php">
                          <div class="form-group">
                            <label for="origintype">원본데이터 타입</label>
                            <select class="form-control" name="original_data_type" id="original_data_type">
                              <?php
                              $sql = "SELECT ID FROM Original_Data_Type WHERE TaskName = \'".$taskname."\'";
                              $res = mysql_query($sql, $con);
                              $count = mysql_num_row($res);

                              for($i = 0; $i < $count; $i++) {
                                $arr = $mysql_fetch_array($res);
                                echo "<option value=\'".$arr[ID]."\'>".$arr['ID']."</option>";
                              }
                              ?>
                              <!-- sample <option value="1">1</option> -->
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="age">기간</label>
                            <input class="form-control" type="date" name="startdate" id="startdate">
                            ~
                            <input class="form-control" type="date" name="enddate" id="enddate">
                          </div>
                          <div class="form-group">
                            <input class="form-control" type="file" name="upload_file[]" id="upload_file">
                          </div>
                          <div class="form-group">
                            <button class="btn btn-info" type="submit" name="button">등록하기</button>
                          </div>
                        </form>
                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="page-contents col-lg-12">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <form class="form-inline" method="post" action="">
                              <div class="form-group">
                                <select class="form-control">
                                  <option value="null">전체</option>
                                  <?php
                                  $sql = "SELECT ID FROM Original_Data_Type WHERE TaskName = \'".$taskname."\'";
                                  $res = mysql_query($sql, $con);
                                  $count = mysql_num_row($res);

                                  for($i = 0; $i < $count; $i++) {
                                    $arr = $mysql_fetch_array($res);
                                    echo "<option value=\'".$arr[ID]."\'>".$arr['ID']."</option>";
                                  }
                                  ?>
                                  <!-- sample
                                  <option value="">옵션1</option>
                                  <option value="">옵션2</option> -->
                                </select>
                                <label for="">원본데이터 타입 제출 파일 현황</label>
                                <div class="form-group">
                                  <button class="btn btn-info btn-sm" type="submit" name="button">
                                    <i class="fa fa-search fa-fw"></i>
                                  </button>
                                </div>
                              </div>
                            </form>
                          </div>
                          <div class="panel-body">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>회차</th>
                                  <th>원본데이터 타입</th>
                                  <th>튜플 수</th>
                                  <th>null 비율(%)</th>
                                  <th>정성평가점수</th>
                                  <th>Pass 여부</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1</td>
                                  <td>option</td>
                                  <td>20</td>
                                  <td>1</td>
                                  <td>null</td>
                                  <td>대기</td>
                                </tr>
                              </tbody>
                            </table>
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
