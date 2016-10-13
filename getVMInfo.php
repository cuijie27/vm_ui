<?php

require("./getHostInfo.php");

function getVMInfo($userpwd_u){

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_VERBOSE, true);	// -v
	curl_setopt($ch, CURLOPT_USERPWD, $userpwd_u);	//-u
	//curl_setopt($ch, CURLOPT_USERPWD, "admin@internal:5idoris");	//-u
	curl_setopt($ch, CURLOPT_CERTINFO, FALSE);		//-k
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//-k
	//curl_setopt($ch, CURLOPT_POST, true);		//-X
	//curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);	//-X
	//curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));	//-H
	//curl_setopt($ch, CURLOPT_INFILE, $fh);		// -T
	//curl_setopt($ch, CURLOPT_URL, "https://v001.ganshane.com/ovirt-engine/api/vms/24a9b519-9748-4662-b785-e3db7dcdc7e1/start");		// url

	curl_setopt($ch, CURLOPT_URL, "https://v001.ganshane.com/ovirt-engine/api/vms");
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
		//echo '返回结果为：'.$ret;
	}

	curl_close($ch);


	$xml = new SimpleXMLElement($ret);
	$vms = $xml->xpath('/vms/vm');

	$vmArr = array();
	$i = 0;
	foreach($vms as $vm){
		$vmName = $vm->name;
		$vmId = $vm['id'];
		$vmStatus = $vm->status;
		$vmPort = $vm->display->secure_port;
		$vmType = $vm->display->type;
		$hostId = $vm->host['id'];

		$vmArr[$i] = array();
		$vmArr[$i]['vmName'] = $vmName;
		$vmArr[$i]['vmId'] = $vmId;
		$vmArr[$i]['status'] = $vmStatus;
		$vmArr[$i]['port'] = $vmPort;
		$vmArr[$i]['hostId'] = $hostId;
		$vmArr[$i]['vmType'] = $vmType;

		$retOfHost = getHostInfo($userpwd_u, $hostId);

		$xml_h = new SimpleXMLElement($retOfHost);
		$vms_h = $xml_h->xpath('/host');
		foreach($vms_h as $vm_h){

			$vmArr[$i]['organization'] = $vm_h->certificate->organization; 
			$vmArr[$i]['subject'] = $vm_h->certificate->subject; 
			$vmArr[$i]['address'] = $vm_h->address; 
		}

		$i++;
	}

	return $vmArr;
}
?>