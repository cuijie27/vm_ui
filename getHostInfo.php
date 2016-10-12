<?php
function getHostInfo($userpwd_u, $host_id){
	
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_VERBOSE, true);	// -v
	curl_setopt($ch, CURLOPT_USERPWD, $userpwd_u);	//-u
	//curl_setopt($ch, CURLOPT_USERPWD, "admin@internal:5idoris");	//-u
	//curl_setopt($ch, CURLOPT_CERTINFO, FALSE);		//-k
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);//-k
	curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/ca.pem'); 
	//CURLOPT_SSL_VERIFYPEER
	//CURLOPT_CAINFO
	//CURLOPT_CAPATH

	//curl_setopt($ch, CURLOPT_POST, true);		//-X
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);	//-X
	curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));	//-H
	//curl_setopt($ch, CURLOPT_INFILE, $fh);		// -T
	curl_setopt($ch, CURLOPT_URL, "https://v001.ganshane.com/ovirt-engine/api/hosts/".$host_id);		// url

	//curl_setopt($ch, CURLOPT_URL, "https://v001.ganshane.com/ovirt-engine/api/vms");
	//curl_setopt($ch, CURLOPT_FILE, $fh);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$ret = curl_exec($ch);

	if($ret === false)
	{
	    echo 'Curl error: ' . curl_error($ch);
	}
	else
	{
	    echo '操作完成没有任何错误<br>';
		//echo '返回结果为：'.$ret;
	}

	curl_close($ch);

	return $ret;
}

?>