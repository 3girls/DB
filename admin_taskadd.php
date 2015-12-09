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
        <script src="js/admin_taskadd_validation.js"></script>

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
                              <li class="active">
                                  <a class="active" href="#"><i class="fa fa-tasks fa-fw"></i> 태스크 관리<span class="fa arrow"></span></a>
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
                                      echo "<li><a href=\"admin_download.php?taskname=".$arr['Name']."\">테이블 데이터 다운 받기</a></li>";
                                      $query1 = "SELECT COUNT(*), SUM(Parsing_Sequence_Data_Type.TotalTupleNum) ";
                                      $query1 .= "FROM Task join Parsing_Sequence_Data_Type on Task.Name = Parsing_Sequence_Data_Type.TaskName ";
                                      $query1 .= "WHERE Parsing_Sequence_Data_Type.TaskName = '$arr[0]'";
                                      $result1 = mysql_query($query1, $con);
                                      $arr1 = mysql_fetch_array($result1);
                                      echo "<li style=\"margin-left:53px; margin-top:10px; margin-bottom:15px; font-size:12px; color:gray;\">파싱데이터시퀀스파일 수: ".$arr1[0]."</li>";
                                      echo "<li style=\"margin-left:53px; margin-top:15px; margin-bottom:10px; font-size:12px; color:gray;\">튜플 수: ".$arr1[1]."</li>";
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
                          <h1 class="page-header"><i class="fa fa-tasks fa-fw"></i> 태스크 추가하기</h1>
                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="page-contents col-lg-12">
                          <form class="form" name="form-taskadd" method="post" action="admin_taskadd_validation.php" onsubmit="return CheckTaskAdd()">
                            <div class="form-group">
                              <label for="taskname">태스크 이름</label>
                              <input class="form-control" type="text" name="taskname" id="taskname" placeholder="태스크 이름" maxlength="30">
                            </div>
                            <p style="color:#d9534f;" id="taskname_msg"></p> <!--id_msg-->
                            <div class="form-group">
                              <label for="taskdescription">태스크 설명</label>
                              <input class="form-control" type="text" name="taskdescription" id="taskdescription" placeholder="50자 이내로 입력하세요" maxlength="50">
                            </div>
                            <div class="form-group">
                              <label for="minuploadperiod">최소 업로드 주기(일)</label>
                              <input class="form-control" type="number" name="minuploadperiod" id="minuploadperiod" placeholder="1">
                            </div>
                            <div class="form-group">
                              <label for="tablename">태스크 데이터 테이블 이름</label>
                              <input class="form-control" type="text" name="tablename" id="tablename" placeholder="tablename1">
                            </div>
                            <p style="color:#d9534f;" id="tablename_msg"></p> <!--id_msg-->
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>스키마정보(이름)</th>
                                  <th>데이터타입</th>
                                  <th>LENGTH</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1</td>
                                  <td>
                                    <input class="form-control" type="text" name="name1" id="name1">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type1" id="type1">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length1" id="length1">
                                  </td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>
                                    <input class="form-control" type="text" name="name2" id="name2">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type2" id="type2">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length2" id="length2">
                                  </td>
                                </tr>
                                <tr>
                                  <td>3</td>
                                  <td>
                                    <input class="form-control" type="text" name="name3" id="name3">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type3" id="type3">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length3" id="length3">
                                  </td>
                                </tr>
                                <tr>
                                  <td>4</td>
                                  <td>
                                    <input class="form-control" type="text" name="name4" id="name4">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type4" id="type4">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length4" id="length4">
                                  </td>
                                </tr>
                                <tr>
                                  <td>5</td>
                                  <td>
                                    <input class="form-control" type="text" name="name5" id="name5">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type5" id="type5">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length5" id="length5">
                                  </td>
                                </tr>
                                <tr>
                                  <td>6</td>
                                  <td>
                                    <input class="form-control" type="text" name="name6" id="name6">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type6" id="type6">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length6" id="length6">
                                  </td>
                                </tr>
                                <tr>
                                  <td>7</td>
                                  <td>
                                    <input class="form-control" type="text" name="name7" id="name7">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type7" id="type7">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length7" id="length7">
                                  </td>
                                </tr>
                                <tr>
                                  <td>8</td>
                                  <td>
                                    <input class="form-control" type="text" name="name8" id="name8">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type8" id="type8">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length8" id="length8">
                                  </td>
                                </tr>
                                <tr>
                                  <td>9</td>
                                  <td>
                                    <input class="form-control" type="text" name="name9" id="name9">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type9" id="type9">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length9" id="length9">
                                  </td>
                                </tr>
                                <tr>
                                  <td>10</td>
                                  <td>
                                    <input class="form-control" type="text" name="name10" id="name10">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type10" id="type10">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length10" id="length10">
                                  </td>
                                </tr>
                                <!-- 10 -->
                                <tr>
                                  <td>11</td>
                                  <td>
                                    <input class="form-control" type="text" name="name11" id="name11">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type11" id="type11">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length11" id="length11">
                                  </td>
                                </tr>
                                <tr>
                                  <td>12</td>
                                  <td>
                                    <input class="form-control" type="text" name="name12" id="name12">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type12" id="type12">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length12" id="length12">
                                  </td>
                                </tr>
                                <tr>
                                  <td>13</td>
                                  <td>
                                    <input class="form-control" type="text" name="name13" id="name13">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type13" id="type13">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length13" id="length13">
                                  </td>
                                </tr>
                                <tr>
                                  <td>14</td>
                                  <td>
                                    <input class="form-control" type="text" name="name14" id="name14">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type14" id="type14">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length14" id="length14">
                                  </td>
                                </tr>
                                <tr>
                                  <td>15</td>
                                  <td>
                                    <input class="form-control" type="text" name="name15" id="name15">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type15" id="type15">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length15" id="length15">
                                  </td>
                                </tr>
                                <tr>
                                  <td>16</td>
                                  <td>
                                    <input class="form-control" type="text" name="name16" id="name16">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type16" id="type16">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length16" id="length16">
                                  </td>
                                </tr>
                                <tr>
                                  <td>17</td>
                                  <td>
                                    <input class="form-control" type="text" name="name17" id="name17">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type17" id="type17">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length17" id="length17">
                                  </td>
                                </tr>
                                <tr>
                                  <td>18</td>
                                  <td>
                                    <input class="form-control" type="text" name="name18" id="name18">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type18" id="type18">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length18" id="length18">
                                  </td>
                                </tr>
                                <tr>
                                  <td>19</td>
                                  <td>
                                    <input class="form-control" type="text" name="name19" id="name19">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type19" id="type19">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length19" id="length19">
                                  </td>
                                </tr>
                                <tr>
                                  <td>20</td>
                                  <td>
                                    <input class="form-control" type="text" name="name20" id="name20">
                                  </td>
                                  <td>
                                    <select class="form-control" name="type20" id="type20">
                                      <option value="varchar">varchar</option> <!-- m -->
                                      <option value="char">char</option> <!-- m -->
                                      <option value="int">int</option>
                                      <option value="tinyint">tinyint</option> <!-- m -->
                                      <option value="real">real</option>
                                      <option value="date">date</option>
                                    </select>
                                  </td>
                                  <td>
                                    <input class="form-control" type="number" name="length20" id="length20">
                                  </td>
                                </tr>
                                <!-- 20 -->
                              </tbody>
                            </table>
                            <p style="color:#d9534f;" id="schema_msg"></p> <!--id_msg-->
                            <div class="form-group col-md-2 col-md-offset-10">
                              <button class="btn btn-success btn-block" type="submit">추가하기</button>
                            </div>
                          </form>

                        </div>
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
