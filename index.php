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
  $host = "165.132.121.29";
  $user = "team37";
  $password = "3737";

  $con = mysql_connect($host, $user, $password);
  if($con) {
    $db = mysql_select_db("team3737");
  }

?>
Go to <a href="login.php">login page</a>
</body>
</html>
