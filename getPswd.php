<?php
function getPswd(){

	$xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><action><async>true</async><ticket><expiry>120</expiry></ticket></action>';

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_VERBOSE, true);	// -v
	curl_setopt($ch, CURLOPT_USERPWD, "admin@internal:5idoris");	//-u
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);//-k
	curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/ca.pem'); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);	//-X
	curl_setopt($ch, CURLOPT_POST, true);		//-X
	curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));	//-H
	curl_setopt($ch, CURLOPT_URL, "https://v001.ganshane.com/ovirt-engine/api/vms/24a9b519-9748-4662-b785-e3db7dcdc7e1/ticket");		// url
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$ret = curl_exec($ch);

	if($ret === false)
	{
	    echo 'Curl error: ' . curl_error($ch);
	}
	else
	{
	    //echo '操作完成没有任何错误<br>';
		//echo '返回结果为：'.$ret;
	}


	curl_close($ch);


	//echo "$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$\n";
	$xml = new SimpleXMLElement($ret);
	$vms = $xml->xpath('/action/ticket');
	foreach($vms as $vm){
		//echo 'expiry : '. $vm->expiry."\n";
		//echo 'value: '.$vm->value."\n";
		if($vm->value){
			return $vm->value;
		}
	}
	return "";
}
?>