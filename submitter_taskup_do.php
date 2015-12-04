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
  $uploaddir = "psf_directory/";


  $sid=$_GET['sid'];
  $taskname = $_GET['taskname'];
  $duplicatetuplenum=0;
  $nullratio=0;
  $nullcount=0;
  $entirecount=0;
  #echo $sid;
  #echo $taskname;
  $original_data_type = $_POST['original_data_type'];
  $startdate = $_POST['startdate'];
  $enddate = $_POST['enddate'];
  $times = $_POST['times'];
  $temp_file_name = $_FILES['upload_file']['name'];
  $file_name = $temp_file_name[0];
  #echo $original_data_type."<br />\n";
  #echo $startdate."<br />\n";
  #echo $enddate."<br />\n";
  #echo $times."<br />\n";
  #echo $file_name."<br />\n";
  $taskattributenum=0;
  $writinglist;
  $mappingattribute;
  # 파일 확장자 구하기
  $file_type = substr(strrchr($file_name,"."),1);
  #echo $file_type."<br />\n";
  # 파일 확장자가 .csv가 아니면 제출 거절
  if($file_type != 'csv') {
    echo "<script>alert('csv파일만 업로드하실 수 있습니다.'); history.back();</script>";
  }

  #type1
  #EID, NUM, NULLRATE, PNP(2), Grade(NULL) : php 에서 정해줌
  #-------------------------------------
  #type2
  #taskname, side : $_GET
  #type3
  #id="original_data_type", id="startdate", id="enddate", id="times", id="upload_file"
  #Original_Data_Type, Start/End_DATE, FILE : $_POST
  #type4
  #PID : 자동 증가 in DB
  #-------------------------------------
  #USING ODT mappingInfo, mapping to parsing sequence file
  #download to webserver
  #정량평가 계산
  #평가자 랜덤 배정
  #-------------------------------------
    $query = "SELECT * FROM Task Where Name='$taskname' ";
    $result = mysql_query($query, $con);
    if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
    }
    $temp = mysql_fetch_array($result);
    $TaskDataTableSchemaInfo = $temp["TaskDataTableSchemaInfo"];
    $Task_words = explode(" ", $TaskDataTableSchemaInfo);
    $Task_words_count =  count($Task_words);
    $taskattributenum=($Task_words_count-1)/2;
    //echo $taskattributenum." ";
    for($i = 0 ; $i < ($Task_words_count-1) ; $i+=2)
    {
      if($i==0) $writinglist[0][0]=$Task_words[$i];
      else $writinglist[0][$i/2]=$Task_words[$i];
    }


    $query = "SELECT * FROM Original_Data_Type Where ID ='$original_data_type' and TaskName='$taskname' ";
    $result = mysql_query($query, $con);
    if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
    }
    $temp = mysql_fetch_array($result);
    $MappingInfo = $temp["MappingInfo"];
    $words = explode(" ", $MappingInfo);
    $mapping_words_count =  count($words);
    for($ii = 0 ; $ii < ($mapping_words_count-1) ; $ii++)
    {
        $mappingattribute[$ii]=$words[$ii];
    }
    #-------------------------------------
    ###########schema가 다른 csv파일 일 때##################처리#########
    ###########CSV_한글 파일일 때 처리__#################처리#########
    
    setlocale(LC_CTYPE, 'ko_KR.eucKR'); ##CSV파일 추출시 한글 깨짐 방지.

    $tmpName = $_FILES['upload_file']['tmp_name'];
    move_uploaded_file($_FILES["file"], $tmpName[0]);
    $handle = fopen($tmpName[0],'r');
    //$handle is file.

    if ($handle  !== FALSE) {

      if(($head = fgetcsv($handle, ",")) !== FALSE){
        $num = count($head);
       
      }
      $row=1;
      $nullcount=0;
      while (($data = fgetcsv($handle, ",")) !== FALSE) {
          $num = count($data);
          //echo "<p> $num fields in line $row: <br /></p>\n";
          for ($index=0; $index < $num; $index++) {
            if($mappingattribute[$index]!="NULL"){
                //echo $mappingattribute[$index]." ";
                $key=array_search($mappingattribute[$index], $writinglist[0]);
                $writinglist[$row][$key] = $data[$index];
                if($data[$index]==""){
                  $nullcount++;
                }
            }
          }
/*
          for ($c=0;$c<$taskattributenum;$c++){
            echo $writinglist[$row][$c]." ";
          }
          echo "<br />\n";*/
          $row++;
      }

      fclose($handle);
    }
    $row--;

    $entirecount=$row*$taskattributenum;
    
    if($entirecount!=0){
      $nullratio=$nullcount/$entirecount;
    }

    $writefilename = $uploaddir.$sid."_".$original_data_type."_".$times.".csv";

    
    ########select random evaluator###############
    $query = "SELECT * FROM Evaluator";
    $result = mysql_query($query, $con);
    if(!$result){
      $message  = 'Invalid query: ' . mysql_error() . "\n";
      $message .= 'Whole query: ' . $query;
      die($message);
    }
    $random_eid=" ";
    $ecount = mysql_num_rows($result);
    $random_n=rand()%$ecount;

    for($index=0;$index<$random_n;$index++){
      $row_result=mysql_fetch_row($result);
      $random_eid=$row_result[0];
    }

    $duplicatetuplenum=0;
    $check;
    for($index=1;$index<$row;$index++){
      for($j=$index+1;$j<=$row;$j++){
        $tf = false;
        for($co=0;$co<$taskattributenum;$co++){
          if($writinglist[$index][$co]!=$writinglist[$j][$co]){
            $tf = true;
            break;
          }
        }
        if($tf==false && ($check[$index]==0 && $check[$j]==0)){
          $duplicatetuplenum+=2;
          $check[$index]=1;
          $check[$j]=1;
        }
        else if($tf==false && ($check[$index]==0 && $check[$j]==1)){
          $duplicatetuplenum++;
          $check[$index]=1;
          $check[$j]=1;
        }
        else if($tf==false && ($check[$index]==1 && $check[$j]==0)){
          $duplicatetuplenum++;
          $check[$index]=1;
          $check[$j]=1;
        }
      }
    }

    ########select random evaluator###############
    
    $query = "insert into Parsing_Sequence_Data_Type (TotalTupleNum, DuplicateTupleNum, NullRatio, TaskName, SID, Times, Startdate, Finishdate, OriginalDataTypeID, EID, Estate, P_NP, ID) ";
    $query.= "values ($row, $duplicatetuplenum, $nullratio, '$taskname','$sid','$times','$startdate','$enddate','$original_data_type','$random_eid', 0, 2,'$writefilename')";
    $result = mysql_query($query, $con);
    if(!$result)
    {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
    }
    else
    {
      $addODTurl = "submitter_taskup.php";
      $addODTurl = $addODTurl . "?";
      $addODTurl = $addODTurl . "sid=";
      $addODTurl = $addODTurl . $sid;// 안되면 '' 지워보기.
      $addODTurl = $addODTurl . "&";
      $addODTurl = $addODTurl . "taskname=";
      $addODTurl = $addODTurl . $taskname;// 안되면 '' 지워보기.
              
      echo "<script>alert('제출 성공!');
              location.replace('".$addODTurl."');
              </script>";
    }

    $fp = fopen($writefilename, 'w');

    foreach ($writinglist as $fields) {
        fputcsv($fp, $fields);
    }
    fwrite ($csv_handler,$csv);
    fclose($fp);



  ?>
</body>
