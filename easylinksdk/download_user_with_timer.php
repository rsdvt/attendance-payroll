<?php

include 'koneksidb.php';
$sqldev = mysql_query("SELECT * FROM tb_device");

$t_limit=$_GET['page_limit'];	
$t_url=$_GET['server_url'];	
$t_port=$_GET['server_port'];
$t_sn=$_GET['dev_sn'];

$t_param="sn=".$t_sn."&limit=".$t_limit;

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
	}else{
		$response;
	}
	
	return $response;
	
}

$session=true;
$delSession=true;
$respons_data;
$resultStatus;





while($session){

	$server_output = webservice($t_port,$t_url,$t_param);
	$content = json_decode($server_output);
	
	if(($content->Data)>0){	
				
		/*if($delSession){
			$querydeluser	= mysql_query("delete from tb_user");
			$querydeltemp	= mysql_query("delete from tb_template");
			$delSession=false;
		}*/
						
		if($querydeluser and $querydeltemp){}else{
			echo '<script>alert ("Failed !")</script>';
		}
						
		foreach($content->Data as $entry){
				
			$Jpin = $entry->PIN;
			$Jname = $entry->Name;
			$Jrfid = $entry->RFID;
			$Jpass = $entry->Password;
			$Jpriv = $entry->Privilege;
			$JTemp = $entrytemp->Template;
			$sqlinsertuser	= 'insert into tb_user (pin,nama,pwd,rfid,privilege) values ("'.$Jpin.'","'.$Jname.'","'.$Jpass.'","'.$Jrfid.'","'.$Jpriv.'")';
			$queryinsertuser	= mysql_query($sqlinsertuser);
					
			if($queryinsertuser){
			}else{
				echo '<script>alert ("Failed !")</script>';
			}
					
			foreach($entry->Template as $values){
				$valPin = $values->pin;
				$valIdx = $values->idx;
				$valAlg_ver = $values->alg_ver;
				$valTemp = $values->template;
				$sqlinserttemp	= 'insert into tb_template (pin,finger_idx,alg_ver,template) values ("'.$valPin.'","'.$valIdx.'","'.$valAlg_ver.'","'.$valTemp.'")';
				$queryinserttemp	= mysql_query($sqlinserttemp);
						
				if($queryinserttemp){
				}else{
					echo '<script>alert ("Failed !")</script>';
				}
			}
			
			/*if($content->Result==true){		
				$resultStatus=true;
			}else{
				$resultStatus=false;
			}*/	
		}
	}	
	$session=$content->IsSession;	
}

/*$namafile = "JSOnDataUser.txt"; 
$handle = fopen ("content/".$namafile, "w"); 

if (!$handle) { 				
	$server_output = "Filed Save"; 
} else { 				
	fwrite ($handle, CreateUserJSON()); 					
	$dirname = dirname($path)."/JSOnDataUser.txt";
} 
	
fclose($handle); */

echo $resultStatus;
?>