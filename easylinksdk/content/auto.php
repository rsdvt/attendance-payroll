<?php
include '../koneksidb.php';
$sqldev = mysql_query("SELECT * FROM tb_device");

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

function getTemplate($pinT){
	$header = "[";
	$footer = "]";
	$content = "";
	$sqlGetTemp = mysql_query("SELECT * FROM tb_template where pin=".$pinT);
	while($dataGetTemp = mysql_fetch_array($sqlGetTemp)){
		if ($content != ""){
			$content = $content.',';
		}
		$content = $content.'{"pin":"'.$dataGetTemp[pin].'","idx":"'.$dataGetTemp[finger_idx].'","alg_ver":"'.$dataGetTemp[alg_ver].'","template":"'.$dataGetTemp[template].'"}';
	}
	return ($header.$content.$footer);
}



function CreateJSON_ScanLog(){
	
	$header = '{"Result":true,"Data":[';
	$footer = "]}";
	$content = "";
	$sqlscan = mysql_query("SELECT * FROM tb_scanlog");

	while($datascan = mysql_fetch_array($sqlscan))
	{
	
			if ($content != ""){
				$content = $content.',';
			}
			
			$content = $content.'{"no":"'.$i.'","sn":"'.$datascan[sn].'","scan_date":"'.$datascan[scan_date].'","pin":"'.$datascan[pin].
							'","verifymode":'.$datascan[verifymode].'","iomode":"'.$datascan[iomode].'","workcode":"'.$datascan[workcode].'}';
	
	}
	
	return ($header.$content.$footer);
}



function CreateJSON_DataUser(){

	$startSelect=1;
	$limitDefault=100;
	
	$header = '{"Result":true,"Data":[';
	$footer = "]}";
	$content = "";
	$sqlSetAll = mysql_query("SELECT * FROM tb_user");
	
	while($dataSetAll = mysql_fetch_array($sqlSetAll)){
		if ($content != ""){
			$content = $content.',';
		}
		$content = $content.'{"PIN":"'.$dataSetAll[pin].'","Name":"'.$dataSetAll[nama].'","RFID":"'.$dataSetAll[rfid].'","Password":"'.$dataSetAll[pwd].
							'","Privilege":'.$dataSetAll[privilege].','.GetTemplateAll($dataSetAll[pin]).'}';
	}
	
	return ($header.$content.$footer);
}



function getTemplateAll($pinT){
	$header = '"Template":[';
	$footer = "]";
	$content = "";
	$sqlGetTempAll = mysql_query("SELECT * FROM tb_template where pin=".$pinT);
	while($dataGetTempAll = mysql_fetch_array($sqlGetTempAll)){
		if ($content != ""){
			$content = $content.',';
		}
		$Temp1 = $dataGetTempAll[template];
		$temp = str_replace('+', '%2B', $Temp1);
		$content = $content.'{"pin":"'.$dataGetTempAll[pin].'","idx":"'.$dataGetTempAll[finger_idx].'","alg_ver":"'.$dataGetTempAll[alg_ver].'","template":"'.$temp.'"}';
	}
	return ($header.$content.$footer);
}


?>

<form method="post" action="index.php?m=content&p=auto">
	<div class="row">	
		<div class="col-sm-5">
			<div class="col-xs-6"><input type="submit" class="btn btn-primary btn-block" name="b_GetAllUser_AllDevice" value="Get All User In All Device" style="width:210px"></div>
			<div class="col-xs-6"><input type="text" class="form-control" placeholder="Paging Limit"  name="i_pagingGet" id="limit_paging_getuser" style="width:120px"></div>		
		</div>
	</div>	
	<br>
	<div class="row">	
		<div class="col-sm-5">
			<div class="col-xs-6"><input type="submit" class="btn btn-primary btn-block" name="b_GetLogAllUser" value="Get All ScanLog In All Device" style="width:210px"></div>
			<div class="col-xs-6"><input type="text" class="form-control" placeholder="Paging Limit" name="i_pagingGetLog" id="limit_paging_getlog" style="width:120px"></div>
		</div>		
	</div>
	<br>	
</form>

<script type="text/javascript" src="js/json2.js"></script>
<script type="text/javascript" >

	var xhttp;
	var status;
	var text;
	var t_jam;
	var str=0,i;
	var paging_limit=0;
	var DevicedownloadStatus;
	
	
	function StopTimer(){
		status=0;
		clearInterval(myTimer);
		document.getElementById("txtHint").innerHTML = 'off';
	}
	
	
	function startTimer(){
		var date=getCurrentTime();
		create_Logdownload("19497383",date);
		
		/*status=1;
		
		//mengambil nilai paging limit yang di inputkan
		paging_limit = document.getElementById("limit_paging_getuser").value;
		
		document.getElementById("txtHint").innerHTML = 'on';	
		
		//mengambil jadwal (json_array) dari file device.ini melalui pemanggilan fungsi yang terdapat di script PHP (ext.php)
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {					
			if 	(this.readyState == 4 && this.status == 200) {
				text=this.responseText;	
				//alert(text);				
			}			
		};
		
		xhttp.open("GET", "get_time_request.php", true);
		xhttp.send();  
		
		//menentukan waktu pengecekan waktu saat ini dengan jang ada di jadwal
		setInterval(myTimer ,1000);*/
		
	}
	
	function myTimer() {
	
		if(status==1){
					
			var data = JSON.parse(text);
						
			for (i in data.jam) {
						
				t_jam=data.jam[i];
								
				var currentdate = new Date(); 
				
				var current_time = currentdate.getHours() + ":" + currentdate.getMinutes();							
								
				if(t_jam==current_time){
					
							
					xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
									
						if 	(this.readyState == 4 && this.status == 200) {
						
							var device=this.responseText;
							var obj=JSON.parse(device);
													
							var ipServer=obj.ip;
							var portServer=obj.port;
							
							var url=ipServer+"/user/all/paging";
							
							
							for (j in obj.sn) {
								
															
								//alert(url+" "+obj.sn[j]+" "+paging_limit);
								//t_url, t_port, t_sn, t_limit
								//var url="192.91.25.5/user/all/paging";
								//var sn="6668601649075";
								//var port="1891";

								simpleReqHttp(url,portServer,obj.sn[j],paging_limit);
																					
							}
																				
						}			
					};				
					xhttp.open("GET", "get_sn.php", true);
					xhttp.send();  							
				}			
			}			
		}
	}
	
	
	function create_Logdownload(t_sn,t_time){
		var strLog=get_DownloadLog();
		var jsLog;
		alert(strLog);
		
		
		/*if(strLog!="undefined"){		
			//var newElemnt=JSON.parse('{'+'"sn"'+':'+'"'+t_sn+'"'+','+'"datetime"'+':'+'"'+t_time+'"'+'}');
			//jsLog = JSON.parse(this.responseText);		
			//jsLog['data'].push(newElemnt);
			//var Str_txt = JSON.stringify(jsLog);
			//alert(Str_txt);
		}else{		
			jsLog='{'+'"sn"'+':'+'"'+t_sn+'"'+','+'"datetime"'+':'+'"'+t_time+'"'+'}';
			//var fso = new ActiveXObject("Scripting.FileSystemObject"); 
			//var FileObject = fso.OpenTextFile("log_auto_download.txt", 8, true,0); // 8=append, true=create if not exist, 0 = ASCII 
			//new Object.write(jsLog); 
			//new FileObject.close();		
			alert(jsLog);			
		}*/		
	}
	
	
	function simpleReqHttp(t_url, t_port, t_sn, t_limit){
		var params ="page_limit="+t_limit+"&server_url="+t_url+"&server_port="+t_port+"&dev_sn="+t_sn;	
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if 	(this.readyState == 4 && this.status == 200) {
				//alert(this.responseText);										
			}			
	    };				
		xhttp.open("GET", "download_user_with_timer.php?"+params, true);
		xhttp.send(); 
	}
	
	
	function getCurrentTime(){
		var currentdate = new Date(); 
		/*+ currentdate.getDate() + "/"
        + (currentdate.getMonth()+1)  + "/" 
        + currentdate.getFullYear() + " @ "  
        + currentdate.getHours() + ":"  
        + currentdate.getMinutes() + ":" 
        + currentdate.getSeconds();	*/				
		var current_datetime = 	currentdate.getDate()+"/"+ (currentdate.getMonth()+1)  + "/" +currentdate.getFullYear()+" "+currentdate.getHours() + ":" + currentdate.getMinutes();		
		return current_datetime;	
	}
	
	
	function get_DownloadLog(){
		var logdata;
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {									
			if 	(this.readyState == 4 && this.status == 200) {						
				//logdata=	
				alert(this.responseText);		
			}			
	    };				
		xhttp.open("GET", "log_auto_download.txt", true);
		xhttp.send(); 
		
		return logdata;
	}
	
	
	function downloadStatus(){
		var time_download_status;
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {					
			
			if 	(this.readyState == 4 && this.status == 200) {			
				
				var data = JSON.parse(this.responseText);
				var currentdate = new Date(); 

				/*+ currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + " @ "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() + ":" 
                + currentdate.getSeconds();	*/
				
				var current_datetime = 	currentdate.getDate()+"-"+ (currentdate.getMonth()+1)  + "-" +currentdate.getFullYear()+" "+currentdate.getHours() + ":" + currentdate.getMinutes();
				for (i in data.jam) {										
					
				}				
			}			
		};
		
		xhttp.open("GET", "log_auto_download.php", true);
		xhttp.send();  
			
		return time_download_status;		
	}
	
</script>


<?php
if(isset($_POST['b_delUserDB'])){
	$querydeluser	= mysql_query("delete from tb_user");
	$querydeltemp	= mysql_query("delete from tb_template");
	if($querydeluser and $querydeltemp){
		header("location: index.php?m=content&p=user");
	}else{
		echo '<script>alert ("Failed !")</script>';
	}
}


function get_AllLog($ipServer,$port, $pagingL, $devSN){
	$downloadResult;
	$session=true;
	$delSession=true;	
	$url = $ipServer."/scanlog/all/paging";
	$parameter = "sn=".$devSN."&limit=".$pagingL;
	$server_output;
	while($session){
	
		
		$server_output = webservice($port,$url,$parameter);
		$content = json_decode($server_output);
		
		if(($content->Data)>0){	
		
			/*
			if($delSession){
				$querydel= mysql_query("delete from tb_scanlog");
			
				if($querydel){}else{
					echo '<script>alert ("Failed !")</script>';
				}
				
				$delSession=false;
			}*/
					
			foreach($content->Data as $entry){
				$Jsn = $entry->SN;
				$Jsd = $entry->ScanDate;
				$Jpin = $entry->PIN;
				$Jvm = $entry->VerifyMode;
				$Jim = $entry->IOMode;
				$Jwc = $entry->WorkCode;
				$sqlinsertscan	= 'insert into tb_scanlog (sn,scan_date,pin,verifymode,iomode,workcode) values ("'.$Jsn.'","'.$Jsd.'","'.$Jpin.'","'.$Jvm.'","'.$Jim.'","'.$Jwc.'")';
				$queryinsert	= mysql_query($sqlinsertscan);
				/*if($queryinsert){
				}else{
					echo '<script>alert ("Failed !")</script>';
				}*/
			}	
		}
		
		if($content->IsSession != $session){
			$namafile = "JSOnDataScanLog.txt"; 
			$handle = fopen ("content/".$namafile, "w"); 
			if (!$handle) { 				
					$server_output = "Filed Save"; 
			} else { 				
				fwrite ($handle, CreateJSON_ScanLog()); 					
				$dirname = dirname($path)."/JSOnDataScanLog.txt";
			} 
			fclose($handle); 
		}	
		$session=$content->IsSession;
		
		if($content->Result==true){
			$downloadResult="Download Status is True ";
		}else{
			$downloadResult="Download Status is False ";
		}
	}
	
	return 	$downloadResult;

}



function get_AllUser($ipServer, $port ,$pagingL, $devSN){
	$downloadResult;
	$session=true;
	$delSession=true;
	$url = $ipServer."/user/all/paging";	
	$parameter = "sn=".$devSN."&limit=".$pagingL;
	$server_output;
	
	while($session){
									
		$server_output = webservice($port,$url,$parameter);		
		$content = json_decode($server_output);
		
			
		if(($content->Data)>0){	
				
				/*if($delSession){
					$querydeluser	= mysql_query("delete from tb_user");
					$querydeltemp	= mysql_query("delete from tb_template");
					$delSession=false;
				}
						
				if($querydeluser and $querydeltemp){}else{
					echo '<script>alert ("Failed !")</script>';
				}*/
						
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
			}
		}
			
		if($content->IsSession != $session){
				$namafile = "JSOnDataUser.txt"; 
				$handle = fopen ("content/".$namafile, "w"); 
				if (!$handle) { 				
					$server_output = "Filed Save"; 
				} else { 				
					fwrite ($handle, CreateJSON_DataUser()); 					
					$dirname = dirname($path)."/JSOnDataUser.txt";
				} 
				fclose($handle); 
		}	
			
		$session=$content->IsSession;	
		
		if($content->Result==true){
			$downloadResult="Download Status is True ";
		}else{
			$downloadResult="Download Status is False ";
		}			
	}
		
	return $downloadResult;
}


function getDviceFileText(){
	
	$str;
	
	$strFileName = "device.ini";

	$myFileLink = fopen($strFileName, 'r');

	$str = fread($myFileLink, filesize($strFileName));
		
	fclose($myFileLink);
	
	return $str;
}


if($datadev = mysql_fetch_array($sqldev)) {
	$sn = $datadev[device_sn];
	$port = $datadev[server_port];
	$file=getDviceFileText();
	$server_IP=$datadev[server_IP];
	
	if(isset($_POST['b_GetAllUser_AllDevice'])){
	
		
		$pagingLimit=$_POST['i_pagingGet'];		
		$DownloadStatus;
		$start;
		$end;
		
				
		for($i=0; $i<=strlen($file); $i++){
			if(strpos(substr($file,$i,3),'sn=')!==false){		
				$start=$i+3;	
				break;
			}	
		}
		
		for($i=$start; $i<=strlen($file); $i++){		
			if(strpos(substr($file,$i,1),'[')!==false){		
				$end=$i;
				break;				
			}	
		}
		
		
		$t_str=substr($file,$start,($end-$start)).';';
		$status=0;	
		$content=0;
		
		for($i=0; $i<=strlen($t_str); $i++){
		
			$content=0;
			
			for($j=$i; $j<=strlen($t_str); $j++){
				
				$content=$content+1;
				
				if(strpos(substr($t_str,$j,1),';')!==false){
					
					$temp_sn=preg_replace('/[^A-Za-z0-9]/','',substr($t_str,$i,$content));
					$i=$j;
					
					
					
					
						
					if($temp_sn!==''){
					
						//$DownloadStatus=$server_IP.','.$port.','.$pagingLimit.','.$temp_sn;
						//echo "<script type='text/javascript'>alert('$DownloadStatus');</script>";
						
						//$DownloadStatus=get_AllUser($server_IP,$port,$pagingLimit,$temp_sn);	
						$DownloadStatus=$temp_sn.' : '.get_AllUser($server_IP,$port,$pagingLimit,$temp_sn).'  '.$DownloadStatus;							

					}
					
			
					
					if((strlen($t_str)-1)==$j){
						$server_output=$DownloadStatus;
						$status=1;							
					}
					
					break;
				}
				
			}			
			if($status==1){break;}
		}
				
	}if(isset($_POST['b_GetLogAllUser'])){
	
		
		$pagingLimit=$_POST['i_pagingGet'];		
		$DownloadStatus;
		$start;
		$end;
		
				
		for($i=0; $i<=strlen($file); $i++){
			if(strpos(substr($file,$i,3),'sn=')!==false){		
				$start=$i+3;	
				break;
			}	
		}
		
		for($i=$start; $i<=strlen($file); $i++){		
			if(strpos(substr($file,$i,1),'[')!==false){		
				$end=$i;
				break;				
			}	
		}
		
		
		$t_str=substr($file,$start,($end-$start)).';';
		$status=0;	
		$content=0;
		
		for($i=0; $i<=strlen($t_str); $i++){
		
			$content=0;
			
			for($j=$i; $j<=strlen($t_str); $j++){
				
				$content=$content+1;
				
				if(strpos(substr($t_str,$j,1),';')!==false){
					
					$temp_sn=preg_replace('/[^A-Za-z0-9]/','',substr($t_str,$i,$content));
					$i=$j;
					
					if($temp_sn!==''){						
						$DownloadStatus=$temp_sn.' : '.get_AllLog($server_IP,$port,$pagingLimit,$temp_sn).'  '.$DownloadStatus;
					}
										
					if((strlen($t_str)-1)==$j){
						$server_output=$DownloadStatus;
						$status=1;							
					}
					
					break;
				}
				
			}			
			if($status==1){break;}
		}
				
	}elseif (isset($_POST['b_getScanLogAllUser'])){
		
		$DownloadStatus;
		$start;
		$end;
				
		for($i=0; $i<=strlen($file); $i++){
			if(strpos(substr($file,$i,4),'jam=')!==false){		
				$start=$i+4;	
				break;
			}	
		}
		
		$t_file=substr($file,$start,strlen($file)-$start).';';
		$status=0;	
		$content=0;
		
		for($i=0; $i<=strlen($t_file); $i++){
		
			$content=0;
			
			for($j=$i; $j<=strlen($t_file); $j++){
				
				$content=$content+1;
				
				if(strpos(substr($t_file,$j,1),';')!==false){
					
					$temp_sn=preg_replace('/[^A-Za-z0-9]/','',substr($t_file,$i,$content));
					$i=$j;
					
					
					if((strlen($t_file)-1)==$j){
						$server_output=$temp_sn;
						$status=1;							
					}
					
					break;
				}
			}			
			if($status==1){break;}
		}			
	}
}
echo '<br> <textarea class="form-control" placeholder="Result" readonly="readonly">'.$server_output."</textarea>";
?>