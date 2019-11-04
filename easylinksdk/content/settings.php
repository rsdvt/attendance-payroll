<?php
include '../koneksidb.php';
$sql = mysql_query("SELECT * FROM tb_device");

function webservice($port,$url,$parameter){
	$curl = curl_init();
	set_time_limit(0);
	curl_setopt_array($curl, array(
		CURLOPT_PORT => $port,
		CURLOPT_URL => "http://".$url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => $parameter,
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: application/x-www-form-urlencoded"
			),
		)
	);
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
		$response = ("Error #:" . $err);
	}
	else
	{
		$response;
	}
	return $response;
}

?>

<form method="post" action="index.php?m=content&p=settings">
	<h3>Device Settings</h3>
	<div class="col-sm-4">
		<input type="submit" class="btn btn-primary btn-block" name="b_syncDT" value="Sync Date Time">
		<input type="submit" class="btn btn-primary btn-block" name="b_delAdm" value="Delete Admin">
		<input type="submit" class="btn btn-primary btn-block" name="b_delLog" value="Delete Device Log">
		<input type="submit" class="btn btn-primary btn-block" name="b_init" value="Initialization">
	</div>
</form>

<?php
if($data = mysql_fetch_array($sql)) {
	$sn = $data[device_sn];
	$port = $data[server_port];
	if((isset($_POST['b_syncDT'])) or (isset($_POST['b_delAdm'])) or (isset($_POST['b_delLog'])) or (isset($_POST['b_init']))){
		if(isset($_POST['b_syncDT'])){
		$url = $data[server_IP]."/dev/settime";
	}elseif (isset($_POST['b_delAdm'])){
		$url = $data[server_IP]."/dev/deladmin";
	}elseif (isset($_POST['b_delLog'])){
		$url = $data[server_IP]."/log/del";
	}elseif (isset($_POST['b_init'])){
		$url = $data[server_IP]."/dev/init";
	}
	$parameter = "sn=".$sn;
	$server_output = webservice($port,$url,$parameter);
	}
	
	
}else{
	if((isset($_POST['b_syncDT'])) or (isset($_POST['b_delAdm'])) or (isset($_POST['b_delLog'])) or (isset($_POST['b_init']))){
		echo '
		<div class="col-sm-8"></div>
		<div class="col-sm-12"><br><div class="alert alert-danger">Please Insert Data Device</div></div>';
	}
}
echo '
<div class="col-sm-8"></div>
<div class="col-sm-12"><br><textarea class="form-control" placeholder="Result" readonly="readonly">'.$server_output.'</textarea></div>';
?>