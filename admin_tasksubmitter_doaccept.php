<?session_start()?>
<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  include 'basic.php';
  $sid = $_GET['sid'];
  $taskname = $_GET['taskname'];
  $accept = $_GET['accept'];
  $query = "INSERT INTO Participate (SID, TaskName, Accept) VALUES ('".$sid."','".$taskname."','".$accept."')";
  mysql_query($query);
  echo "<script>history.back();</script>";
  ?>
</body>
