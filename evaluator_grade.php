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
  $query = "SELECT * FROM Parsing_Sequence_Data_Type WHERE ID='".$fid."'";
  $res = mysql_query($query, $con);
  $result_row = mysql_Fetch_array($res);
  $taskid = $result_row[3];
  $sid = $result_row[4];

  $query = "SELECT * FROM Task WHERE Name='".$taskid."'";
  $res = mysql_query($query, $con);
  if(!$res){
  $message  = 'Invalid query: ' . mysql_error() . "\n";
  $message .= 'Whole query: ' . $query;
  die($message);
  }
  $result_row = mysql_Fetch_array($res);
  $tablename = $result_row[3];
  /*
  $TaskDataTableSchemaInfo = $result_row["TaskDataTableSchemaInfo"];
  $Task_words = explode(" ", $TaskDataTableSchemaInfo);
  $Task_words_count =  count($Task_words);
  $taskattributenum=($Task_words_count-1)/2;
  //echo $taskattributenum." ";
  for($i = 1 ; $i < ($Task_words_count-1) ; $i+=2)
  {
    if($i==0) $writinglist[0][1]=$Task_words[$i];
    else $writinglist[0][($i/2)+1]=$Task_words[$i];
  }*/

  $makingquery="";

  if($_POST['PNP']=='1'){

    $pnp = 1;


    $handle = fopen($fid,'r');
    //$handle is file.

    if ($handle  !== FALSE) {

      if(($head = fgetcsv($handle, ",")) !== FALSE){
        $num = count($head);
        for ($index=0; $index < $num; $index++) {
            //$makingquery .="'";
            $makingquery .= $head[$index];
            //$makingquery .="'";
            if($index!=($num-1)){
              $makingquery .= ",";
            }
        }
        //echo $head[0];
      }

      while (($data = fgetcsv($handle, ",")) !== FALSE) {
          $num = count($data);
          $query = "insert into ".$tablename." (".$makingquery.") values";

          $query .= "(";


          for ($index=0; $index < $num; $index++) {
              $query .= "'";
              $query .= $data[$index];
              //if($data[$index]=="") $query.="NULL";
              $query .= "'";
              if($index!=($num-1)){
                $query .= ",";
              }
          }
          $query .= ")";
          echo $query."<br />\n";



          $res = mysql_query($query, $con);
          if(!$res){
              $message  = 'Invalid query: ' . mysql_error() . "\n";
              $message .= 'Whole query: ' . $query;
              die($message);
          }
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

  #관련 제출자 점수
  $Sgrade = 0.0;
  $query = "SELECT * FROM Parsing_Sequence_Data_Type WHERE SID = '".$sid."' AND Estate = 1";
  $res = mysql_query($query, $con);
  $count = mysql_num_rows($res);

  #((1-중복튜플수/튜플수(작은게 좋음1))*20 + (1-널레이시오(작은게좋음1))*30 + 평가자점수(10)*5) * n 개
  for($i = 0; $i < $count; $i++) {
    $arr = mysql_fetch_array($res);
    $tmp = (1-($arr['DuplicateTupleNum']/$arr['TotalTupleNum']))*20 + (1-$arr['NullRatio'])*30 + $arr['EvaluatorGrade']*5;
    $Sgrade += $tmp;
  }

  $Sgrade /= $count;

  $query = "UPDATE Submitter SET Grade=ROUND(".$Sgrade.") WHERE ID='".$sid."'";
  mysql_query($query, $con);

  echo "<script>location.replace('evaluator_waiting.php');</script>";
  ?>
</body>
