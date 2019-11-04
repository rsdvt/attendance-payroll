<?php

include 'db.php';

$queryCheck= mysql_query("select * from tb_penampilan");
if (!$queryCheck) {
    die("query failed");
}

$row_queryCheck = mysql_fetch_array($queryCheck);
echo $row_queryCheck;