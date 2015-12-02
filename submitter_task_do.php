<?session_start()?>
<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  include 'basic.php';
  $sid = $_GET['sid'];
  $taskname = $_GET['taskname'];
  $query = "INSERT INTO Participate (SID, TaskName, Accept) ";
  $query .= "VALUES ('$sid','$taskname','2')";
  mysql_query($query);
  echo "<script>alert('참여 신청되었습니다.');
  location.replace('submitter_task.php');
  </script>";
  ?>
</body>