<?php

include '../koneksidb.php';

$sqldev = mysql_query("SELECT * FROM tb_device");

if($datadev = mysql_fetch_array($sqldev)) {
	
	$sn = $datadev[device_sn];
	$port = $datadev[server_port];
	$parameter = "sn=".$sn;
}

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

		$url = $datadev[server_IP]."/scanlog/new";
		$parameter = "sn=".$sn;
		$server_output = webservice($port,$url,$parameter);
		
		$content = json_decode($server_output);
		
		foreach ($content as $key => $value) {
			if ((!is_array($value)) and ($value==1)) {
				$querydel	= mysql_query("delete from tb_scanlog");
				if($querydel){}else{
					echo '<script>alert ("Failed !")</script>';
				}
				foreach($content->Data as $entry){
					$Jsn = $entry->SN;
					$Jsd = $entry->ScanDate;
					$Jpin = $entry->PIN;
					$Jvm = $entry->VerifyMode;
					$Jim = $entry->IOMode;
					$Jwc = $entry->WorkCode;
					$sqlinsertscan	= 'insert into tb_scanlog (sn,scan_date,pin,verifymode,iomode,workcode) values ("'.$Jsn.'","'.$Jsd.'","'.$Jpin.'","'.$Jvm.'","'.$Jim.'","'.$Jwc.'")';
					$queryinsert	= mysql_query($sqlinsertscan);
					if($queryinsert){
					}else{
						echo '<script>alert ("Failed !")</script>';
					}
				}
			}elseif((!is_array($value)) and (!$value==1)) {
			}
		}



