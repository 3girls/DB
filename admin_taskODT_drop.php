<?session_start()?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  $id = $_SESSION['id'];
  include 'basic.php';


  $ODTid=$_GET['ODTid'];
  $taskiidd=$_GET['taskid'];
  $taskname=$taskiidd;

  $query = "delete from Original_Data_Type where ID = '$ODTid'";
  $result = mysql_query($query, $con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  else{
  $addODTurl = "admin_taskODT.php";
  $addODTurl = $addODTurl . "?";
  $addODTurl = $addODTurl . "taskname=";
  $addODTurl = $addODTurl . $taskiidd;// 안되면 '' 지워보기.
  echo "<script>alert('삭제되었습니다.');
  location.replace('".$addODTurl."');
  </script>";

  }

?>
</body>
</html>