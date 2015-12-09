<?php
session_start();
// connect mysqldb and $id = session id
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="0;url=login.php">
<title>DataCollector</title>
<script language="javascript">
    window.location.href = "login.php"
</script>
</head>
<body>
  <?php
  if($_SESSSION['login'] == 'YES'){
    if($_SESSION['usertype'] == 1){ //administrator
      echo "<script>location.replace('admin_search.php');</script>";
    }
    else if($_SESSION['usertype'] == 2){
      echo "<script>location.replace('submitter_task.php');</script>";
    }
    else if($_SESSION['usertype'] == 3){
      echo "<script>location.replace('evaluator_waiting.php');</script>";
    }
  }
  ?>
Go to <a href="login.php">login page</a>
</body>
</html>
