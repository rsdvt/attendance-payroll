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

function CreateUserJSON(){

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

function viewUser(){
	$sqluser = mysql_query("SELECT * FROM tb_user order by pin ASC");
	$jml = mysql_num_rows($sqluser);
	echo'
	<h3>Data User <span class="badge">'.$jml.'</span></h3>';
	while($datauser = mysql_fetch_array($sqluser))
	{
		$idUser = $datauser[pin];
		echo "
		<td>".$idUser."</td>
		<td>".$datauser[nama]."</td>
		<td>".$datauser[pwd]."</td>
		<td>".$datauser[rfid]."</td>
		<td>".$datauser[privilege]."</td>";
		echo'
		<td>
			<button type="button" class="btn" data-toggle="modal" data-target="#message'.$idUser.'">
			<span class="glyphicon glyphicon glyphicon-eye-open"></span></button>
		</td>
		</tr>
		<div id="message'.$idUser.'" class="modal fade" role="dialog">
			<div class="modal-dialog">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
					<!--  <h4 class="modal-title"></h4>-->
					</div>
					<div class="modal-body">
					';
					$sqltemplate = mysql_query("SELECT * FROM tb_template where pin=".$idUser );
					while($datatemplate = mysql_fetch_array($sqltemplate)){
						echo '
						<ul class="list-group">
							<li class="list-group-item">
								<label>PIN : </label>
								<input type="text" class="form-control" value="'.$datatemplate[pin].'" readonly="readonly">
							</li>
							<li class="list-group-item">
								<label>Finger Index : </label>
								<input type="text" class="form-control" value="'.$datatemplate[finger_idx].'" readonly="readonly">
							</li>
							<li class="list-group-item">
								<label>Algoritma Version : </label>
								<input type="text" class="form-control" value="'.$datatemplate[alg_ver].'" readonly="readonly">
							</li>
							<li class="list-group-item">
								<label>Template : </label>
								<textarea class="form-control" readonly="readonly">'.$datatemplate[template].'</textarea>
							</li>
						</ul>
						';
					}
					echo'
					</div>
					<div class="modal-footer">
						<button class="btn btn-info" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>';
	}
	echo '
	</table>
	';
}
?>

<form method="post" action="index.php?m=content&p=user">


<div class="row">
	<div class="col-sm-4"><div class="col-xs-6"><input type="text" class="form-control" placeholder="Paging Limit"  name="i_pagingGet" style="width:120px"></div>
	<div class="col-xs-6"><input type="submit" class="btn btn-primary btn-block" name="b_GetUser" value="Get All User" style="width:133px"></div></div>
	
	
	<div class="col-sm-4"><div class="col-xs-6"><input type="text" class="form-control" placeholder="Paging Limit" name="i_pagingSet" style="width:120px"></div>
	<div class="col-xs-6"><input type="submit" class="btn btn-primary btn-block" name="b_SetAllUser" value="Set All User" style="width:133px"></div></div>


	<div class="col-sm-4"><input type="submit" class="btn btn-primary btn-block" name="b_DelUser" value="Delete All User"></div>
	
</div>

<br>

<div class="row">
	<div class="col-sm-4"><div class="col-xs-6"><input type="text" class="form-control" placeholder="PIN"  name="i_setUser" style="width:120px"></div>
	<div class="col-xs-6"><input type="submit" class="btn btn-primary btn-block" name="b_SetUser" value="Set User" style="width:133px"></div></div>
	
	
	<div class="col-sm-4"><div class="col-xs-6"><input type="text" class="form-control" placeholder="PIN" name="i_delUser" style="width:120px"></div>
	<div class="col-xs-6"><input type="submit" class="btn btn-primary btn-block" name="b_delUserPIN" value="Delete User Pin" style="width:133px"></div></div>
	
	<div class="col-sm-4"><input type="submit" class="btn btn-primary btn-block" name="b_delUserDB" value="Clear User in Database"></div>
	
</div>

<table class="table table-hover">
	<tr>
		<th>PIN</th>
		<th>Nama</th>
		<th>Password</th>
		<th>RFID</th>
		<th>Privilege</th>
		<th></th>
	</tr>
	<tr>
</form>

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

if($datadev = mysql_fetch_array($sqldev)) {
	$sn = $datadev[device_sn];
	$port = $datadev[server_port];
	
	
	if(isset($_POST['b_GetUser'])){
	
		$session=true;
		$delSession=true;
		$pagingLimit	= $_POST['i_pagingGet'];
		
		while($session){
			
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
					fwrite ($handle, CreateUserJSON()); 					
					$dirname = dirname($path)."/JSOnDataUser.txt";
				} 
				fclose($handle); 
			}	
			
			$session=$content->IsSession;				
		}
		
		
	}elseif(isset($_POST['b_SetAllUser'])){
	
		$parameter; //= "sn=".$sn."&data=".CreateUserJSON();
		$url = $datadev[server_IP]."/user/set-all";

		$offset=0;
		$limitPaging=$_POST['i_pagingSet'];
	
		$header = '{"Result":true,"Data":[';
		$footer = "]}";
		$content = "";
		$rowTotal;
		

		$result=mysql_query("SELECT count(*) as total from tb_user");		
		while($dataSetAll = mysql_fetch_array($result)){
			$rowTotal=$dataSetAll[total];
		}
		
		$n = (int) ($rowTotal / $limitPaging)+1;	
		
		for($i=1; $i<=$n; $i++){ 
			$content="";
			$sqlSetAll = mysql_query("SELECT * FROM tb_user LIMIT ".$offset.",".$limitPaging."");
			while($dataSetAll = mysql_fetch_array($sqlSetAll)){
				
				if ($content != ""){
					$content = $content.',';
				}
				
				$content = $content.'{"PIN":"'.$dataSetAll[pin].'","Name":"'.$dataSetAll[nama].'","RFID":"'.$dataSetAll[rfid].'","Password":"'.$dataSetAll[pwd].
									'","Privilege":'.$dataSetAll[privilege].','.GetTemplateAll($dataSetAll[pin]).'}';
												
			}
			
			if($content!=""){
				$offset=($offset+$limitPaging);
				$data=$header.$content.$footer;
				$parameter = "sn=".$sn."&data=".$data;
				//$server_output=$parameter;
				//$server_output=$parameter;
				//$server_output = webservice($port,$url,$parameter);
				
				$server_output = webservice($port,$url,$parameter);
			}
		}
		
	}elseif (isset($_POST['b_DelUser'])){
		$parameter = "sn=".$sn;
		$url = $datadev[server_IP]."/user/delall";
		$server_output = webservice($port,$url,$parameter);
	}elseif (isset($_POST['b_delUserPIN'])){
		$pinDel	= $_POST['i_delUser'];
		$parameter = "sn=".$sn."&pin=".$pinDel;
		$url = $datadev[server_IP]."/user/del";
		$server_output = webservice($port,$url,$parameter);
	}elseif (isset($_POST['b_SetUser'])){
		$pinSet	= $_POST['i_setUser'];
		if ($pinSet == null){
			echo '<script>alert ("Please Insert User PIN")</script>';
		}else{
			$sqluserUp = mysql_query("SELECT * FROM tb_user where pin=".$pinSet);
		}
		while ($datauserUp = mysql_fetch_array($sqluserUp)) {
			$upPin = $datauserUp[pin];
			$upNama = $datauserUp[nama];
			$upPwd = $datauserUp[pwd];
			$upRfid = $datauserUp[rfid];
			$upPriv = $datauserUp[privilege];
			$upTemp = getTemplate($upPin);
			$upTemp = str_replace("+","%2B",$upTemp);
			$parameter = "sn=".$sn."&pin=".$upPin."&nama=".$upNama."&pwd=".$upPwd."&rfid=".$upRfid."&priv=".$upPriv."&tmp=".$upTemp;
			$url = $datadev[server_IP]."/user/set";
			$server_output = webservice($port,$url,$parameter);
		}
	}

	if(isset($_POST['b_GetUser'])){

	}
}
echo viewUser(),'<textarea class="form-control" placeholder="Result" readonly="readonly">'.$server_output."</textarea>";
?>