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

<form method="post" action="index.php?m=content&p=info">
	<h3>Device Info</h3>
	<div class="col-sm-4"><input type="submit" class="btn btn-primary btn-block" name="b_infoDev" value="Device Info"></div>
</form>

<?php
if($data = mysql_fetch_array($sql)) {
	$sn = $data[device_sn];
	$port = $data[server_port];
	if(isset($_POST['b_infoDev'])){
		$url = $data[server_IP]."/dev/info";
		$parameter = "sn=".$sn;
		$server_output = webservice($port,$url,$parameter);

		echo '
		<div class="col-sm-8">';
			$json = json_decode($server_output, true);
			echo'
			<div class="container col-sm-12">
				<div class="panel-group" id="accordion"><br>
					<div class="panel panel-default">
					    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
						    <button type="button" class="btn">
							    <span class="glyphicon glyphicon-pushpin">
							    </span>
						    </button>
					    </a>
					    <label> DEVINFO</label>
					    <div id="collapse1" class="panel-collapse collapse in">
						    <div class="panel-body">
							    <table class="table">
								';
								foreach ($json as $key => $value) {
									if (!is_array($value)) {
								        //echo $key . ':' . $value . '<br>';
								    }else{
								    	foreach ($value as $key => $val) {
								    		echo '
								    		<tr>
									    		<td>'.$key .'</td>
									    		<td>'. $val . '</td>
								    		</tr>
								    		';
								    	}
								    }
								}
								echo '
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		';
	}
}else{
	if(isset($_POST['b_infoDev'])){
		echo '
		<div class="col-sm-8"></div>
		<div class="col-sm-12"><br><div class="alert alert-danger">Please Insert Data Device</div></div>
		';
	}
}
echo '
<div class="col-sm-12"><br><textarea class="form-control" placeholder="Result" readonly="readonly">'.$server_output.'</textarea></div>
';
?>
