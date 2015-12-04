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

  //header to give the order to the browser
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment;filename='.$tempname.'');

	//select table to export the data
	$select_table=mysql_query('select * from '.$taskTableName.'');
	$rows = mysql_fetch_assoc($select_table);

	if ($rows)
	{
		getcsv(array_keys($rows));
	}
	while($rows)
	{
		getcsv($rows);
		$rows = mysql_fetch_assoc($select_table);
	}

	// get total number of fields present in the database
	function getcsv($no_of_field_names)
	{
		$separate = '';


		// do the action for all field names as field name
		foreach ($no_of_field_names as $field_name)
		{
			if (preg_match('/\\r|\\n|,|"/', $field_name))
			{
				$field_name = '' . str_replace('', $field_name) . '';
			}
			echo $separate . $field_name;

			//sepearte with the comma
			$separate = ',';
		}

		//make new row and line
		echo "\r\n";
	}

  ?>
</body>
