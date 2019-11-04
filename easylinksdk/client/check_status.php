<?php

include 'db.php';

$queryCheck= mysql_query("select * from tb_penampilan where status_penampilan=0  ORDER BY no ASC LIMIT 1");
if (!$queryCheck) {
    die("query failed");
}

$row_queryCheck = mysql_fetch_array($queryCheck);
echo json_encode($row_queryCheck);