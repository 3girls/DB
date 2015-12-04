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
  if($_POST['PNP']=='1'){
    $pnp = 1;

  
    $handle = fopen($fid,'r');
    //$handle is file.

    if ($handle  !== FALSE) {

      if(($head = fgetcsv($handle, ",")) !== FALSE){
        $num = count($head);
      }
      while (($data = fgetcsv($handle, ",")) !== FALSE) {
          $num = count($data);
          $query = "UPDATE Parsing_Sequence_Data_Type SET ";
          for ($index=0; $index < $num; $index++) {
            $query .= $head[$index];
            $query .= "=";
            $query .= $data[$index];
            if($indexx!=($num-1)){
              $query .= ",";
            }
          }
          $query .= "WHERE ID='";
          $query .= $fid;
          $query .= "'";
      }
      fclose($handle);
    }



  }
  else if($_POST['PNP']=='0'){
    $pnp = 0;
  }

  $query = "UPDATE Parsing_Sequence_Data_Type SET EvaluatorGrade=".$grade.", Estate=1, P_NP=".$pnp." WHERE ID='".$fid."'";
  mysql_query($query, $con);

  #PASS


  #밑에꺼는 나중에 재활용하삼....

  #총 평가점수를 계산하여 패스 여부를 결정
  #$query = "SELECT * FROM Parsing_Sequence_Data_Type WHERE ID='".$fid."'";
  #$result = mysql_query($query, $con);
  #$arr = mysql_fetch_array($result);
  #$X = ($arr['DuplicateTupleNum']/$arr['TotalTupleNum'] + $arr['NullRatio']*0.01)*50 + $arr['EvaluatorGrade'];
  #PASS
  #if($X >= 100) {
  #  $query = "UPDATE Parsing_Sequence_Data_Type SET P_NP=1 WHERE ID='".$fid."'";
  #  mysql_query($query, $con);
  #}
  #NONPASS
  #else {
  #  $query = "UPDATE Parsing_Sequence_Data_Type SET P_NP=0 WHERE ID='".$fid."'";
  #  mysql_query($query, $con);
  #}

  echo "<script>location.replace('evaluator_waiting.php');</script>";
  ?>
</body>
