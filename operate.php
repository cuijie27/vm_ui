<?php

$vmid = $_GET['vmid'];
$operate = $_GET['operate'];
$userpswd_u = $_GET['usrpswd'];

$ch = curl_init();

$xml_data = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><action><async>true</async></action>';

curl_setopt($ch, CURLOPT_VERBOSE, true);	// -v
curl_setopt($ch, CURLOPT_USERPWD, $userpswd_u);	//-u
//curl_setopt($ch, CURLOPT_USERPWD, "admin@internal:5idoris");	//-u
curl_setopt($ch, CURLOPT_CERTINFO, FALSE);		//-k
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//-k
curl_setopt($ch, CURLOPT_POST, true);		//-X
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);	//-X
curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));	//-H
//curl_setopt($ch, CURLOPT_INFILE, $fh);		// -T
//curl_setopt($ch, CURLOPT_URL, "https://v001.ganshane.com/ovirt-engine/api/vms/24a9b519-9748-4662-b785-e3db7dcdc7e1/start");		// url

curl_setopt($ch, CURLOPT_URL, "https://v001.ganshane.com/ovirt-engine/api/vms/".$vmid."/".$operate);
//curl_setopt($ch, CURLOPT_URL, "https://v001.ganshane.com/ovirt-engine/api/vms/24a9b519-9748-4662-b785-e3db7dcdc7e1/shutdown");
//curl_setopt($ch, CURLOPT_FILE, $fh);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


$ret = curl_exec($ch);

if($ret === false)
{
    echo 'Curl error: ' . curl_error($ch);
}
else
{
    //echo '操作完成没有任何错误<br>';
	echo '操作结果为：'.$ret;
}
curl_close($ch);
?>