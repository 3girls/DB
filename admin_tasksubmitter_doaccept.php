<?php
session_start();
// connect mysqldb and $id = session id
?>
<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  include 'basic.php';
  $sid = $_GET['sid'];
  $taskname = $_GET['taskname'];
  $accept = $_GET['accept'];
  $query = "UPDATE Participate SET Accept = '".$accept."' WHERE SID = '".$sid."' AND TaskName = '".$taskname."'";
  mysql_query($query);
  #echo "<script>history.back();</script>";
  echo "<script>location.replace('admin_tasksubmitter.php?taskname=".$taskname."');</script>";

  ?>
</body>
