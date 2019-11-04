<?php
include '../easylinksdk/koneksidb.php';
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


$session=true;
$delSession=true;
$pagingLimit	= $_POST['i_pagingGet'];


    
    $parameter = "sn=".$sn."&limit=".$pagingLimit;
    
    $url = $datadev[server_IP]."/user/all/paging";
    $server_output = webservice($port,$url,$parameter);		
    $content = json_decode($server_output);

    
    if(($content->Data)>0){	
        
        if($delSession){
            $querydeluser	= mysql_query("delete from tb_user");
            $querydeltemp	= mysql_query("delete from tb_template");
            $delSession=false;
        }
                
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

        }
    }