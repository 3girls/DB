<?php
session_start();
// connect mysqldb and $id = session id
$id = $_SESSION['id'];
?>
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
                      <a class="navbar-brand" href="index.php">
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
                              <li class="active">
                                  <a class="active" href="#"><i class="fa fa-tasks fa-fw"></i> 참가 중인 태스크<span class="fa arrow"></span></a>
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
                      <div class="page-contents col-lg-12">';

                        $taskupDOurl = "submitter_taskup_do.php";
                        $taskupDOurl = $taskupDOurl . "?";
                        $taskupDOurl = $taskupDOurl . "taskname=";
                        $taskupDOurl = $taskupDOurl . $_GET['taskname'];// 안되면 '' 지워보기.
                        $taskupDOurl = $taskupDOurl . "&";
                        $taskupDOurl = $taskupDOurl . "sid=";
                        $taskupDOurl = $taskupDOurl . $_GET['sid'];;// 안되면 '' 지워보기.

                        echo '
                        <form class="form-inline" enctype="multipart/form-data" method="post" onsubmit=\"return CheckTaskUp()\" action='.$taskupDOurl.'>';
                          echo '
                          <div class="form-group" style="margin-bottom:5px;">
                            <label for="origintype">원본데이터 타입</label>
                            <select class="form-control input-sm" name="original_data_type" id="original_data_type">';
                              $query1 ="SELECT Original_Data_Type.ID FROM Participate INNER JOIN Original_Data_Type ON Original_Data_Type.TaskName = Participate.TaskName ";
                              $query1 .= "WHERE Participate.SID = '$sid' AND Participate.TaskName = '$taskname' AND Participate.Accept=1";
                              $result1 = mysql_query($query1, $con);
                              $count1 = mysql_num_rows($result1);
                                      for($i = 0; $i < $count1; $i++) {
                                        $arr = mysql_fetch_array($result1);
                                       echo '<option value="'.$arr[0].'">'.$arr[0].'</option>';
                                        }
                              #option select한거 넘기는거 저렇게 써도 되나용??? 네 되어오
                              #<option value="1">1</option>
                          echo '</select>

                            <label>회차</label>
                            <input class="form-control input-sm" type="number" min="1" max="999" name="times" id="times" required>

                            <label for="date">기간</label>
                            <input class="form-control input-sm" type="date" name="startdate" id="startdate" required>
                            ~
                            <input class="form-control input-sm" type="date" name="enddate" id="enddate" required>
                          </div>
                          <div class="form-group">
                            <input class="form-control input-sm" type="file" name="upload_file[]" id="upload_file" required>

                            <button class="btn btn-info btn-sm" type="submit" name="button">등록하기</button>
                          </div>
                        </form>
                      </div>

                      <!-- /.col-lg-12 -->
                      <div class="page-contents col-lg-12">';

                      $query = "SELECT * FROM Parsing_Sequence_Data_Type WHERE SID='".$id."' and TaskName='".$taskname."'";
                      $res = mysql_query($query, $con);
                      $count = mysql_num_rows($res);

                      echo '<div style="text-align:right; color:gray;">';
                      echo '<p>'.$taskname.'의 총 제출 파일 수: '.$count.'<p>';

                      $query2 = "SELECT SUM(Parsing_Sequence_Data_Type.TotalTupleNum) ";
                      $query2 .= "FROM Task join Parsing_Sequence_Data_Type on Task.Name = Parsing_Sequence_Data_Type.TaskName ";
                      $query2 .= "WHERE Parsing_Sequence_Data_Type.TaskName = '$taskname' AND Parsing_Sequence_Data_Type.P_NP = 1 AND Parsing_Sequence_Data_Type.SID='$id'";
                      $result2 = mysql_query($query2, $con);
                      $arr2 = mysql_fetch_array($result2);
                      echo '<p>태스크 테이블 내 총 튜플 수:'.$arr2[0].'</p></div>';

                      echo '
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <form class="form-inline" method="post" action="">
                              <div class="form-group">
                                <select class="form-control">
                                  <option value="null">전체</option>';
                                  $query1 ="SELECT Original_Data_Type.ID FROM Participate INNER JOIN Original_Data_Type ON Original_Data_Type.TaskName = Participate.TaskName ";
                                  $query1 .= "WHERE Participate.SID = '$sid' AND Participate.TaskName = '$taskname' AND Participate.Accept=1";
                                  $result1 = mysql_query($query1, $con);
                                  $count1 = mysql_num_rows($result1);
                                          for($i = 0; $i < $count1; $i++) {
                                            $arr = mysql_fetch_array($result1);
                                           echo '<option value="'.$arr[0].'">'.$arr[0].'</option>';
                                            }
                                echo '</select>
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
                              <tbody>';
                              $query = "SELECT * FROM Parsing_Sequence_Data_Type WHERE SID='".$sid."' AND TaskName='".$taskname."'";
                              $res = mysql_query($query, $con);
                              $count = mysql_num_rows($res);
                              for($i = 0; $i < $count; $i++) {
                                  $arr = mysql_fetch_array($res);
                                  echo '<tr>
                                    <td>'.$arr['Times'].'</td>
                                    <td>'.$arr['OriginalDataTypeID'].'</td>
                                    <td>'.$arr['TotalTupleNum'].'</td>
                                    <td>'.$arr['NullRatio'].'</td>
                                    <td>'.$arr['EvaluatorGrade'].'</td>
                                    <td>';
                                  if($arr['P_NP']==0) {
                                      echo 'NonPass';
                                  }
                                  else if($arr['P_NP']==1) {
                                      echo 'Pass';
                                  }
                                  else if($arr['P_NP']==2) {
                                      echo '대기';
                                  }
                                  echo'</td>
                                  </tr>';
                              }
                              echo'
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

        <!-- jQuery -->
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>

    </body>
</html>
