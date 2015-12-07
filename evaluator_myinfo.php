<?php
// Start the session
session_start();
?>
<?php
  $id = $_SESSION['id'];
  include 'basic.php';

  $query = "select * from Evaluator where ID = '$id'";
  $result = mysql_query($query,$con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $row = mysql_fetch_row($result);
  if($result) {
    $id = $row[0];
    $name = $row[2];
    $gender = $row[3];
    $birth = $row[5];
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
        <script src="js/admin_myinfo_validation.js"></script>
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
                          <h1 class="page-header"><i class="fa fa-gear fa-fw"></i> 회원정보</h1>
                      </div>
                      <!-- /.col-lg-12 -->
                      <div class="page-contents col-lg-3">
                      </div>
                      <div class="page-contents col-lg-6">
                        <div class="panel panel-default">
                          <!--
                          <div class="panel-heading">
                            회원정보
                          </div>
                        -->
                          <div class="panel-body">
                            <form class="form-inline" action="evaluator_myinfo_validation.php" method="post" onsubmit="return CheckSignupForm()">
                              <table class="table table-bordered">
                                <tbody>
                                  <tr>
                                    <th>아이디</th>
                                    <td><?=$id?></td>
                                  </tr>
                                  <tr>
                                    <th>비밀번호</th>
                                    <td>
                                      <input class="form-control" type="password" name="PW" id="PW" required maxlength="15"
                                       placeholder="수정할 비밀번호">
                                       <p style="color:#d9534f;" id="pw_msg"></p> <!--pw_msg-->
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>비밀번호 확인</th>
                                    <td>
                                      <input class="form-control" type="password" name="PW_check" id="PW_check" required maxlength="15"
                                       placeholder="비밀번호 확인">
                                       <p style="color:#d9534f;" id="pwrecheck_msg"></p> <!--pwrecheck_msg-->
                                    </td>
                                  </tr>
                                  <tr>
                                    <th>회원유형</th>
                                    <td>평가자</td>
                                  </tr>
                                  <tr>
                                    <th>이름</th>
                                    <td><?=$name?></td>
                                  </tr>
                                  <tr>
                                    <th>성별</th>
                                    <td><?=$gender?></td>
                                  </tr>
                                  <tr>
                                    <th>생년월일</th>
                                    <td><?=$birth?></td>
                                  </tr>
                                  <tr>
                                    <th>이메일</th>
                                    <td><input class="form-control" type="email" name="Email" id="Email" maxlength="35"
                                       placeholder="이메일 수정"></td>
                                  </tr>
                                  <tr>
                                    <th>휴대폰</th>
                                    <td><input class="form-control" type="number" name="Phone" id="Phone" maxlength="11"
                                       placeholder="휴대폰 번호 수정"></td>
                                  </tr>
                                </tbody>
                              </table>
                              <div style="text-align: center;">
                                <button class="btn btn-info" type="submit" name="button">수정하기</button>
                              </div>
                            </form>
                          </div>
                        </div>
                         <div style="text-align:center; padding-top:14px; padding-bottom:0; margin-bottom:0;">
                          <p><a href="evaluator_deleteID.php">회원탈퇴 하시겠습니까?</a></p>
                         </div>

                      </div>
                      <!-- /.col-lg-6 -->
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
