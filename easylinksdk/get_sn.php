<?php
include 'koneksidb.php';
$sqldev = mysql_query("SELECT * FROM tb_device");


$test;
$start;
$end;

$jsonStr="oke";


if($datadev = mysql_fetch_array($sqldev)){


	$sn = $datadev[device_sn];
	$port = $datadev[server_port];
	$server_IP=$datadev[server_IP];
	$file=getDviceFileText();
	
	
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

				$obj=$obj.'"'.$temp_sn.'"'.',';			
				
				if((strlen($t_str)-1)==$j){
					$status=1;							
				}
						
				break;
			}					
		}		
		if($status==1){break;}
	}

	$jsonStr='{'.'"'.'ip'.'"'.':'.'"'.$server_IP.'"'.','.'"'.'port'.'"'.':'.'"'.$port.'"'.','.'"'.'sn'.'"'.':'.'['.substr($obj,0,strlen($obj)-1).']}';
	
	$namafile = "datasn.txt"; 
	$handle = fopen ("content/".$namafile, "w"); 
	
	if (!$handle) { 				
		$server_output = "Filed Save"; 
	} else { 				
		fwrite ($handle, $jsonStr); 					
		$dirname = dirname($path)."/datasn.txt";
	} 	
	fclose($handle); 
		
}

function getDviceFileText(){
	
	$str;
	
	$strFileName = "device.ini";

	$myFileLink = fopen($strFileName, 'r');

	$str = fread($myFileLink, filesize($strFileName));
		
	fclose($myFileLink);
	
	return $str;
}

echo $jsonStr;
?>