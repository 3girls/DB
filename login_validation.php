<?php
session_start();
// connect mysqldb and $id = session id
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  #$_SESSION['login'] = 'NO';
  #$_SESSION['id'] = 'NO';

  #빈칸일 때 다시 redirect
  if(empty($_POST["ID"]) || empty($_POST["PW"])) {
    echo "<meta http-equiv='refresh' content='0;url=login.php'>";
    exit;
  }

  include 'basic.php';

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
      echo "<script>location.replace('evaulator_waiting.php');</script>";
    }
  }
  else {
    echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.'); history.back();</script>";
  }
  mysql_close($con);

?>
</body>
</html>
