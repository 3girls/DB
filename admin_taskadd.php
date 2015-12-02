<?php
// Start the session
session_start();
// connect mysqldb and $id = session id
$id = $_SESSION['id'];
#$myhost = '202.150.213.98';
$myhost = 'mysql.hostinger.kr';
$myid = 'u729743068_37';
$mypw = '123456';
$con = @mysql_connect($myhost, $myid, $mypw);

$db = mysql_select_db("u729743068_37");
mysql_query("SET NAMES utf8"); //한글처리
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
                              <li><a href="admin_myinfo.php"><i class="fa fa-gear fa-fw"></i> 회원정보</a>
                              </li>
                              <li class="divider"></li>
                              <li><a href="_login.html"><i class="fa fa-sign-out fa-fw"></i> 로그아웃</a>
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
                                  <a href="#"><i class="fa fa-search fa-fw"></i> 회원검색</a>
                              </li>
                              <li>
                                  <a href="#"><i class="fa fa-tasks fa-fw"></i> 태스크 관리<span class="fa arrow"></span></a>
                                  <ul class="nav nav-second-level">
                                      <li>
                                        <a href="#">태스크1 <span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="#">제출자 관리</a>
                                            </li>
                                            <li>
                                                <a href="#">원본데이터 타입 관리</a>
                                            </li>
                                            <li>
                                                <a style="font-size:12px; color:gray;" href="#">파싱데이터시퀀스파일 수: 3</a>
                                            </li>
                                            <li>
                                                <a style="font-size:12px; color:gray;" href="#">튜플 수: 123</a>
                                            </li>
                                        </ul>
                                      </li>
                                      <li>
                                        <a href="#"><i class="fa fa-plus-circle fa-fw"></i> 태스크 추가하기</a>
                                      </li>
                                  </ul>
                                  <!-- /.nav-second-level -->
                              </li>
                              <li>
                                  <a href="#"><i class="fa fa-users fa-fw"></i> 회원 관리<span class="fa arrow"></span></a>
                                  <ul class="nav nav-second-level">
                                      <li>
                                          <a href="#">제출자</a>
                                      </li>
                                      <li>
                                          <a href="#">평가자</a>
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
