<?session_start()?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php

  include 'basic.php';


  $pw = $_POST['PW'];
  $pw_check = $_POST['PW_check'];
  $email = $_POST['Email'];
  $phone = $_POST['Phone'];
  
  $query = "update Administrator set PW = '$pw', Email = '$email', Phone = '$phone'";
  $query.= "where ID = 'admin'";
  $result = mysql_query($query, $con);

  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  else{
  echo "<script>alert('회원정보가 수정되었습니다.');
  location.replace('admin_search.php');
  </script>";
  }
  
?>
</body>
</html>
