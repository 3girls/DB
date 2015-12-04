<?php
session_start();
// connect mysqldb and $id = session id
$eid = $_SESSION['id'];
?>
<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  include 'basic.php';
  $grade = $_POST['grade'];
  $fid = $_GET['fid'];

  $query = "UPDATE Parsing_Sequence_Data_Type SET EvaluatorGrade=".$grade.", Estate=1 WHERE ID='".$fid."';
  mysql_query($query, $con);

  #총 평가점수를 계산하여 패스 여부를 결정
  $query = "SELECT * FROM Parsing_Sequence_Data_Type WHERE ID='".$fid."'";
  $result = mysql_query($query, $con);
  $arr = mysql_fetch_array($result);

  $X = ($arr['DuplicateTupleNum']/$arr['TotalTupleNum'] + $arr['NullRatio']*0.01)*50 + $arr['EvaluatorGrade'];
  #PASS
  if($X >= 100) {
    $query = "UPDATE Parsing_Sequence_Data_Type SET P_NP=1 WHERE ID='".$fid."'";
    mysql_query($query, $con);
  }
  #NONPASS
  else {
    $query = "UPDATE Parsing_Sequence_Data_Type SET P_NP=0 WHERE ID='".$fid."'";
    mysql_query($query, $con);
  }

  echo "<script>location.replace('evaluator_waiting.php');</script>";
  ?>
</body>
