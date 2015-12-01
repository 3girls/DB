
<?session_start()?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  $_SESSION['login'] = 'NO';
  $_SESSION['id'] = 'NO';


  #$myhost = '202.150.213.98';
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

  if($email == "name@domain.com"){
      $email = "";
  }
  if($phone == "12345678"){
      $phone = "";
  }

  $query = "select count(*) from Administrator where ID='$id'";
  $result = mysql_query($query,$con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $r1 = mysql_fetch_row($result);

  $query = "select count(*) from Submitter where ID='$id'";
  $result = mysql_query($query,$con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $r2 = mysql_fetch_row($result);

  $query = "select count(*) from Evaluator where ID='$id'";
  $result = mysql_query($query,$con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $r3 = mysql_fetch_row($result);
  $reg_num = $r1[0] + $r2[0] + $r3[0];
  //echo "$id $pw $pw_check $usertype $name $gender $birth $email $phone";

  if($reg_num>0){
  echo "<script>alert('중복된아이디입니다.');history.back();</script>";
  }
  else{
  $query = "insert into $usertype (ID, PW, Name, Gender, Email, Birth, Phone) ";
  $query.= "values ('$id','$pw','$name','$gender','$email','$birth','$phone')";
  $result = mysql_query($query, $con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  else{
  echo "<script>alert('회원가입 성공!');
  location.replace('login.php');
  </script>";
  }
  }
?>
</body>
</html>
