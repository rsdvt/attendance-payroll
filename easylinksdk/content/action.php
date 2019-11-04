<?php
include('../koneksidb.php'); 
if(isset($_POST['b_addDev'])){
	$serverIP	= $_POST['i_serverIP'];
	$serverPort	= $_POST['i_serverPort'];
	$devSN	= $_POST['i_devSN'];
	
	$sql	= 'insert into tb_device (server_IP,server_port,device_sn) values ("'.$serverIP.'","'.$serverPort.'","'.$devSN.'")';
	$query	= mysql_query($sql);
	if($query){
		
		header('location: ../index.php'); 
	}
	else{
		echo 'failed';
	}
}else{
//}elseif (isset($_POST['b_delDev'])){
$id	= $_GET['id'];
$sql 	= 'delete from tb_device where No="'.$id.'"';
$query	= mysql_query($sql);
if($query){
		header('location: ../index.php'); 
	}
	else{
		echo 'failed';
	}
}
?>