<?php
include_once('db.php');
$sql = "SELECT * FROM tb_penampilan";
$res = mysql_query($sql);
$result = array();

while ($row = mysql_fetch_array($res))
array_push($result, array('no' => $row[0],
                            'pin' => $row[1],
                                'nama' => $row[2],
                                     'status_penampilan' => $row[3]));

echo json_encode(array("result" => $result));
?>