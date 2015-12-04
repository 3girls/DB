<?php
session_start();
// connect mysqldb and $id = session id
?>
<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<?php
  include 'basic.php';
  $taskname = $_GET['taskname'];

  $query = "SELECT * FROM Task Where Name ='$taskname'";
  $TS_result = mysql_query($query, $con);
  if(!$TS_result){
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }
  $temp = mysql_fetch_array($TS_result);
  $taskTableName = $temp["TaskTableName"];

  $tempname = "data_";
  $tempname .= $taskname;
  $tempname .= ".csv";

	$query = "SELECT * INTO OUTFILE '$tempname'
	FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"'
	LINES TERMINATED BY \"\n\"
	FROM $taskTableName";

  ?>
</body>
