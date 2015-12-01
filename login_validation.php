<?php
// Start the session
session_start();
?>
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

  $id = $_POST["ID"];
  $pw = $_POST["PW"];

  // id, pw가 db에 있는지 확인
  $query = "select * from Administrator where ID='$id' and PW='$pw'";
  $result = mysql_query($query, $con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $count1 = mysql_num_rows($result);

  $query = "select * from Submitter where ID='$id' and PW='$pw'";
  $result = mysql_query($query, $con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $count2 = mysql_num_rows($result);

  $query = "select * from Evaluator where ID='$id' and PW='$pw'";
  $result = mysql_query($query, $con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $count3 = mysql_num_rows($result);

  if($count1 == 1 || $count2==1 || $count3==1) {
    $_SESSION['login'] = 'YES';
    $_SESSION['id'] = $id;
    //echo "<script>alert('로그인성공!!');</script>";

    if($count1==1){ //administrator
        echo "<script>location.replace('admin_search.php');</script>";

    }
    else if($count2==1){
      echo "<script>location.replace('submitter_task.php');</script>";

    }
    else if($count3==1){
      echo "evaluator";

    }
  }
  else {
    echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.'); history.back();</script>";
  }
  mysql_close($con);
  
?>
</body>
</html>
