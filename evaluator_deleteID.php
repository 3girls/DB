<?session_start()?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  $id = $_SESSION['id'];

  include 'basic.php';
  
  $query = "delete from Evaluator where ID = '$id'";
  $result = mysql_query($query, $con);

  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  else{
  echo "<script>alert('탈퇴되었습니다.');
  location.replace('logout.php');
  </script>";
  }
  
?>
</body>
</html>
