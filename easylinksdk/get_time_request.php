<?php

	
	$strFileName = "device.ini";

	$myFileLink = fopen($strFileName, 'r');

	$str = fread($myFileLink, filesize($strFileName));
		
	fclose($myFileLink);
	
	$DownloadStatus;
	$start;
				
	for($i=0; $i<=strlen($str); $i++){
		if(strpos(substr($str,$i,4),'jam=')!==false){		
			$start=$i+4;	
			break;
		}	
	}
		
	$t_file=substr($str,$start,strlen($str)-$start).';';
	
	$obj='';
	$status=0;
	$iter=0;
		
	for($i=0; $i<=strlen($t_file); $i++){
		
		$content=0;
		$iter=$iter+1;		
		for($j=$i; $j<=strlen($t_file); $j++){
					
			$content=$content+1;
					
			if(strpos(substr($t_file,$j,1),';')!==false){
						
				$time_req=preg_replace('/;/','',substr($t_file,$i,$content));
				$i=$j;
				
				if(substr($time_req,0,1)=='0'){
					$time_req=substr($time_req,1,strlen($time_req)-1);
				}
		
				$obj=$obj.'"'.$time_req.'"'.',';	
						
				if((strlen($t_file)-1)==$j){
					
					$status=1;							
				}
				
				break;
			}				
		}	
		if($status==1){
			break;
		}
	}
		
	
	echo '{'.'"'.'jam'.'"'.':'.'['.substr($obj,0,strlen($obj)-1).']}';

?>