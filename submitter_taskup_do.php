<?php
session_start();
// connect mysqldb and $id = session id
$id = $_SESSION['id'];
?>
<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  include 'basic.php';

  $uploaddir = "/sampledata/";

  # 파일 이름 가져오기
  $file_name = $_FILES['upload_file']['name'];

  # 파일 확장자 구하기
  $file_type = substr(strrchr($file_name[0],"."),1);
  echo "<script>alert('".$file_type."');</script>";
  # 파일 확장자가 .csv가 아니면 제출 거절
  if($file_type != '.csv') {
    echo "<script>alert('csv파일만 업로드하실 수 있습니다.'); history.back();</script>";
  }

  # 파일 복사하기
  if(move_uploaded_file($_FILES['upload_file']['tmp_name'], $file_name)) {
    echo "파일이 성공적으로 업로드 되었습니다.";
  }
  print_r($_FILES);
  ?>
</body>
