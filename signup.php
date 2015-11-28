<?session_start()?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  $_SESSION['login'] = 'NO';
  $_SESSION['id'] = 'NO';

  $myhost = 'mysql.hostinger.kr';
  $myid = 'u729743068_37';
  $mypw = '123456';
  $con = mysql_connect($myhost, $myid, $mypw);

  $db = mysql_select_db("u729743068_37");
  mysql_query("SET NAMES utf8"); //한글처리

  $id = $_POST['ID'];
  $pw = $_POST['PW'];
  $pw_check = $_POST['PW_check'];
  $usertype = $_POST['usertype'];
  $name = $_POST['Name'];
  $gender = $_POST['Gender'];
  $birth = $_POST['Birth'];
  $email = $_POST['Email'];
  $phone = $_POST['Phone'];

  $query = "select count(*) from Administrator where ID='$id'";
  $result = mysql_query($query,$con);
  $r1 = mysql_fetch_row($result);

  $query = "select count(*) from Administrator where ID='$id'";
  $result = mysql_query($query,$con);
  $r2 = mysql_fetch_row($result);

  $query = "select count(*) from Administrator where ID='$id'";
  $result = mysql_query($query,$con);
  $r3 = mysql_fetch_row($result);
  echo $r1[0].$r2[0].$r3[0];
  $reg_num = $r1[0] + $r2[0] + $r3[0];

  if($reg_num>0){
  echo "<script>
  alert('[중복된 아이디]\r\n\r\n 다른 아이디를 선택하세요.');
  history.back();
  </script>";
  die;
  }

  $query = "insert into '$usertype' (ID, PW, Name, Gender, Email, Birth, Phone) ";
  $query.= "values ('$id','$pw','$name','$gender','$email','$birth','$phone')";
  $result = mysql_query($query, $con);

  echo "<script>alert('회원가입 성공!');
  location.replace('login.php');
  </script>";
?>
</body>
</html>
