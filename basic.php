<?php
  #$myhost = '202.150.213.98';
  $myhost = 'mysql.hostinger.kr';
  $myid = 'u729743068_37';
  $mypw = '123456';
  $con = @mysql_connect($myhost, $myid, $mypw);

  $db = @mysql_select_db("u729743068_37");
  @mysql_query("SET NAMES utf8"); //한글처리
  
?>
