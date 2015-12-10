<?php
// Start the session
session_start();
// connect mysqldb and $id = session id
$id = $_SESSION['id'];

include 'basic.php';
$taskiidd=$_GET['taskname'];
$taskname=$taskiidd;

if(!empty($taskiidd))
{/*
  //원본데이터타입
  $query = "SELECT * FROM Task AS T, Original_Data_Type AS O Where T.Name = O.TaskName AND O.TaskName='$taskiidd'";
  $ODT_result = mysql_query($query, $con);
  $ODT_count = mysql_num_rows($ODT_result);
  if(!$ODT_result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  //원본데이터타입*/


  //태스크테이블스키마 가져오기
  $query = "SELECT * FROM Task Where Name ='$taskiidd'";
  $TS_result = mysql_query($query, $con);
  if(!$TS_result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $temp = mysql_fetch_array($TS_result);
  $db_task_table_schema = $temp["TaskDataTableSchemaInfo"];
  $words = explode(" ", $db_task_table_schema);
  $words_count =  count($words);
  //schema in $db_task_table_schema
  //words_count in $words_count
  //태스크테이블스키마 가져오기
}

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
        <script src="js/admin_taskODT_validation.js"></script>
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

                                      $query3 = "SELECT COUNT(*), SUM(Parsing_Sequence_Data_Type.TotalTupleNum) ";
                                      $query3 .= "FROM Task join Parsing_Sequence_Data_Type on Task.Name = Parsing_Sequence_Data_Type.TaskName ";
                                      $query3 .= "WHERE Parsing_Sequence_Data_Type.TaskName = '$arr[0]' and Parsing_Sequence_Data_Type.P_NP = '1'";
                                      $result3 = mysql_query($query3, $con);
                                      $arr3 = mysql_fetch_array($result3);
                                      
                                      echo "<li style=\"margin-left:53px; margin-top:10px; margin-bottom:15px; font-size:12px; color:gray;\">파싱데이터시퀀스파일 수: ".$arr1[0]."</li>";
                                      echo "<li style=\"margin-left:53px; margin-top:15px; margin-bottom:10px; font-size:12px; color:gray;\">튜플 수: ".$arr3[1]."</li>";
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
                          <h1 class="page-header"><i class="fa fa-tasks fa-fw"></i> <?php echo $taskname; ?> : 원본데이터 타입 관리</h1>
                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="page-contents col-lg-12">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#list" data-toggle="tab">원본데이터 타입 목록</a></li>
                          <li><a href="#add" data-toggle="tab">원본데이터 타입 추가</a></li>
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane fade in active" id="list">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>원본데이터 타입 이름</th>
                                  <th>스키마정보</th>
                                  <th>매핑정보</th>
                                  <th>-</th>
                                </tr>
                              </thead>
                              <tbody>
                                    <?php
                                    $query3 = "SELECT * FROM Original_Data_Type WHERE TaskName ='$taskiidd'";
                                    $resu = mysql_query($query3, $con);
                                    $count = mysql_num_rows($resu);
                                    for($i = 0; $i < $count; $i++) {
                                      $arr = mysql_fetch_array($resu);

                                      echo "<tr>
                                        <td>".($i+1)."</td>
                                        <td>".$arr['ID']."</td>";
                                      echo "<td>{";


                                        $ODT_schema = $arr["SchemaInfo"];
                                        $ODT_words = explode(" ", $ODT_schema);
                                        $ODT_words_count =  count($ODT_words);
                                        for($ii = 0 ; $ii < ($ODT_words_count-1) ; $ii+=2)
                                        {
                                            $tempattribute=$ODT_words[$ii];
                                            echo $tempattribute;
                                            if($ii!=($ODT_words_count-3)){
                                              echo ", ";
                                            }
                                        }
                                        echo "}</td>
                                        <td>{";

                                        $Mapping_schema = $arr["MappingInfo"];
                                        $Mapping_words = explode(" ", $Mapping_schema);
                                        $Mapping_count =  count($Mapping_words);
                                        for($ii = 0 ; $ii < $Mapping_count-1 ; $ii++)
                                        {
                                            $tempattribute=$Mapping_words[$ii];
                                            echo $tempattribute;
                                            if($ii!=($Mapping_count-2)){
                                              echo ", ";
                                            }
                                        }


                                        echo"}</td>";

                                      $dropODTurl = "admin_taskODT_drop.php";
                                      $dropODTurl = $dropODTurl . "?";
                                      $dropODTurl = $dropODTurl . "ODTid=";
                                      $dropODTurl = $dropODTurl . $arr['ID'];// 안되면 '' 지워보기.
                                      $dropODTurl = $dropODTurl . "&";
                                      $dropODTurl = $dropODTurl . "taskid=";
                                      $dropODTurl = $dropODTurl . $taskiidd;// 안되면 '' 지워보기.
                                        echo "
                                        <td>
                                          <button onclick=\"location.href='".$dropODTurl."' \" class=\"btn btn-sm btn-danger btn-outline\" type=\"button\" name=\"button\">삭제하기</button>
                                        </td>
                                      </tr>";
                                    }
                                  ?>
                              </tbody>
                            </table>
                          </div>
                          <!-- second tab -->
                          <div class="tab-pane fade" id="add">
                                      <?php
                                      $taskiidd=$_GET['taskname'];
                                      $addODTurl = "admin_taskODT_validation.php";
                                      $addODTurl = $addODTurl . "?";
                                      $addODTurl = $addODTurl . "taskid=";
                                      $addODTurl = $addODTurl . $taskiidd;// 안되면 '' 지워보기.
                      echo "<form class=\"form\" name=\"form-taskODT\" method=\"post\" action=".$addODTurl." onsubmit=\"return CheckODTAdd()\">";
                                       ?>
                              <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>스키마정보(이름)</th>
                                    <th>매핑정보</th>
                                    <th>데이터타입</th>
                                    <th>LENGTH</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php

                                  $query = "SELECT * FROM Task Where Name ='$taskiidd'";
                                  $TS_result = mysql_query($query, $con);
                                  if(!$TS_result){
                                    $message  = 'Invalid query: ' . mysql_error() . "\n";
                                    $message .= 'Whole query: ' . $query;
                                    die($message);
                                  }
                                  $temp = mysql_fetch_array($TS_result);
                                  $db_task_table_schema = $temp["TaskDataTableSchemaInfo"];
                                  $words = explode(" ", $db_task_table_schema);
                                  $words_count =  count($words);

                                for($j=1;$j<=20;$j++)
                                {
                                  $nameid ='name';
                                  $nameid .= $j;

                                  $mappingid ='mapping';
                                  $mappingid .= $j;

                                  $typeid ='type';
                                  $typeid .= $j;

                                  $lengthid ='length';
                                  $lengthid .= $j;


                                   echo "<tr>
                                    <td>".$j."</td>
                                    <td>
                                      <input class=\"form-control\" type=\"text\" name=".$nameid." id=".$nameid.">
                                    </td>
                                    <td>
                                      <select class=\"form-control\" name=".$mappingid." id=".$mappingid.">
                                            <option>NULL</option>";
                                           for($i = 0 ; $i < ($words_count-1) ; $i+=2)
                                           {
                                            $tempattribute=$words[$i];
                                            echo "<option value=".$tempattribute.">".$tempattribute."</option>";
                                           }
                                      echo "</select>
                                    </td>
                                    <td>
                                      <select class=\"form-control\" name=".$typeid." id=".$typeid.">
                                        <option value=\"char\">char</option> <!-- m -->
                                        <option value=\"varchar\">varchar</option> <!-- m -->
                                        <option value=\"int\">int</option>
                                        <option value=\"tinyint\">tinyint</option> <!-- m -->
                                        <option value=\"real\">real</option>
                                        <option value=\"date\">date</option>
                                      </select>
                                    </td>
                                    <td>
                                      <input class=\"form-control\" type=\"number\" name=".$lengthid." id=".$lengthid.">
                                    </td>
                                  </tr>";
                                }
                                ?>
                                </tbody>
                              </table>
                              <p style="color:#d9534f;" id="schema_msg"></p> <!--id_msg-->
                              <div class="form-group col-md-5 col-md-offset-5">
                              <input class="form-control" type="text" name="ODTname" id="ODTname" placeholder="원본 데이터 타입 이름" maxlength="30">
                              </div>
                              <p style="color:#d9534f;" id="ODTname_msg"></p> <!--id_msg-->
                              <div class="form-group col-md-2">
                                <button class="btn btn-success btn-block" type="submit">추가하기</button>
                              </div>

                            </form>
                          </div>
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
