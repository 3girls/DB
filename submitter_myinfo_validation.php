<?session_start()?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php

  #$myhost = '202.150.213.98';
  $myhost = 'mysql.hostinger.kr';
  $myid = 'u729743068_37';
  $mypw = '123456';
  $con = mysql_connect($myhost, $myid, $mypw);

  $db = mysql_select_db("u729743068_37");
  mysql_query("SET NAMES utf8"); //한글처리

  $pw = $_POST['PW'];
  $pw_check = $_POST['PW_check'];
  $email = $_POST['Email'];
  $phone = $_POST['Phone'];
  
  $query = "update Submitter set PW = '$pw', Email = '$email', Phone = '$phone'";
  $qudry.= "where ID = '$id'";
  $result = mysql_query($query, $con);

  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  else{
  echo "<script>alert('회원정보가 수정되었습니다.');
  location.replace('submitter_task.php');
  </script>";
  }
  
?>
</body>
</html>
