<?session_start()?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  $id = $_SESSION['id'];

  include 'basic.php';
  $taskiidd=$_GET['taskid'];
  $taskname=$taskiidd;

  $query = "SELECT * FROM Task Where Name ='$taskiidd'";
  $TS_result = mysql_query($query, $con);
  if(!$TS_result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $temp = mysql_fetch_array($TS_result);
  $db_task_table_schema = $temp["TaskDataTableSchemaInfo"];
  $words = explode(" ", $db_task_table_schema);
  $words_count =  count($words);
  //$key = array_search("나이1", array_values($words));
  //기타 추가.. : attribute갯수 정할 수 있게 하기
  //원본스키마 1개 이상이므로, 태스크 등록하자마자 바로 등록할 수 있게하기 
  // $taskname

  $ODTname = $_POST['ODTname'];
  $query = "select count(*) from Original_Data_Type where ID='$ODTname'";
  $result = mysql_query($query,$con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $r1 = mysql_fetch_row($result);
  if($r1[0]>0){
  echo "<script>alert('중복된 원본 데이터 타입 이름입니다.');history.back();</script>";
  }
  

  $tasktableschema ="";
  $mappinginfo ="";

  for($i = 1 ; $i <=10 ; $i++){
    $tempname = 'name';
    $tempname .= $i;
    $realname = $_POST[$tempname];

    $temptype = 'type';
    $temptype .= $i;
    $realtype = $_POST[$temptype];

    $templength = 'length';
    $templength .= $i;
    $reallength = $_POST[$templength];

    $tempmapping = 'mapping';
    $tempmapping .= $i;
    $realmapping = $_POST[$tempmapping];

    if(!empty($realname)){
      if($realmapping=='NULL'){
        $mappinginfo .= "NULL";
        $tasktableschema .= $realname;
        $tasktableschema .= " ";
        $tasktableschema .= $realtype;

        if($realtype=='char'){
          if($reallength==""){
            $reallength="1";
          }
        }
        if($realtype=='int'){
          if($reallength==""){
            $reallength="11";
          }
        }
        if($realtype=='tinyint'){
          if($reallength==""){
            $reallength="4";
          }
        }
        if($realtype=='varchar' || $realtype=='char' || $realtype=='int' || $realtype=='tinyint'){
          $tasktableschema .= "(";
          $tasktableschema .= $reallength;
          $tasktableschema .= ")";
        }
      }
      else{ //not null
        $mappinginfo .= $realmapping;
        $tasktableschema .= $realname;
        $tasktableschema .= " ";
        $key = array_search($realmapping, array_values($words));
        $parsedtype = $words[$key+1];
        $tasktableschema .= $parsedtype;
      }
      $mappinginfo .= " ";
      $tasktableschema .= " ";
    }
  }
  if($r1[0]==0)
  {
    $query = "insert into Original_Data_Type (ID, SchemaInfo, TaskName, MappingInfo) ";
    $query.= "values ('$ODTname','$tasktableschema','$taskname','$mappinginfo')";
    $result = mysql_query($query, $con);
    if(!$result)
    {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
    }
    else
    {
      echo "<script>alert('ODT 생성 성공!');
              location.replace('admin_taskODT.php');
              </script>";
    }

  }
?>
</body>
</html>
