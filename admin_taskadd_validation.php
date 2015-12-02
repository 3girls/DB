<?session_start()?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  $id = $_SESSION['id'];

  include 'basic.php';

  //기타 추가.. : attribute갯수 정할 수 있게 하기
  //원본스키마 1개 이상이므로, 태스크 등록하자마자 바로 등록할 수 있게하기 
  $taskname = $_POST['taskname'];
  $taskdescription = $_POST['taskdescription'];
  $minuploadperiod = $_POST['minuploadperiod'];
  $tablename = $_POST['tablename'];
  $tasktableschema ="";


  $query = "select count(*) from Task where Name='$taskname'";
  $result = mysql_query($query,$con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $r1 = mysql_fetch_row($result);

  if($r1[0]>0){
  echo "<script>alert('중복된 태스크 이름입니다.');history.back();</script>";
  }
  $query = "select count(*) from Task where TaskTableName='$tablename'";
  $result = mysql_query($query,$con);
  if(!$result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $r2 = mysql_fetch_row($result);

  if($r2[0]>0){
  echo "<script>alert('중복된 테이블 이름입니다.');history.back();</script>";
  }
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

    if(!empty($realname)){
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
        $tasktableschema .= " ";
    }
  }

  if($r1[0]==0 && $r2[0]==0)
  {
    $query = "insert into Task (Name, Description, MinUploadPeriod, TaskTableName, TaskDataTableSchemaInfo) ";
    $query.= "values ('$taskname','$taskdescription','$minuploadperiod','$tablename','$tasktableschema')";
    $result = mysql_query($query, $con);
    if(!$result)
    {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $query;
            die($message);
    }
    else
    {
            echo "<script>alert('태스크 추가 성공!');</script>";
            $words = explode(" ", $tasktableschema);
            $words_count =  count($words);

           $query = "create table $tablename (SID VARCHAR(10) NOT NULL, ";
           for($i = 0 ; $i < ($words_count-1) ; $i+=2)
           {
            $tempattribute=$words[$i];
            $tempdomain=$words[$i+1];
            $query .= "$tempattribute $tempdomain";
            if($i!=($words_count-3)){
              $query .= ", ";
            }
           }
           $query .= ")";

           $result = mysql_query($query, $con);
            if(!$result)
            {
              $message  = 'Invalid query: ' . mysql_error() . "\n";
              $message .= 'Whole query: ' . $query;
              die($message);
            }
            else
            {
              echo "<script>alert('태스크 테이블 생성 성공!');
              location.replace('admin_taskadd.php');
              </script>";
            }
    }

  }
?>
</body>
</html>
