<?php

include 'db.php';

$queryCheck= mysql_query("update tb_penampilan set status_penampilan=1 where status_penampilan=0 ORDER BY no ASC LIMIT 1");
if (!$queryCheck) {
    die("query failed");
}