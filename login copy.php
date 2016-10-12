<?php
//https://v001.ganshane.com/ovirt-engine/sso/login.html
echo 'hello vm worldss<br>';

$usrName = $_POST['username'];
$pswd = $_POST['password'];

$userpwd_u = $usrName."@internal:".$pswd;

$ch = curl_init();

curl_setopt($ch, CURLOPT_VERBOSE, true);	// -v
//curl_setopt($ch, CURLOPT_USERPWD, $userpwd_u);	//-u
curl_setopt($ch, CURLOPT_USERPWD, "admin@internal:5idoris");	//-u
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
    echo '操作完成没有任何错误<br>';
	echo '返回结果为：'.$ret;
}


curl_close($ch);

/////////////////////////
/*    <certificate>
        <organization>localdomain</organization>
        <subject>O=localdomain,CN=192.168.0.188</subject>
    </certificate>*/
$xml = new SimpleXMLElement($ret);
$vms = $xml->xpath('/vms/vm');
foreach($vms as $vm){
	echo "$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$\n";
	echo 'name	: '. $vm->name."\n";
	echo 'vm_id	: '.$vm['id']."\n";
	echo 'status	: '.$vm->status."\n";
	echo 'port	: '.$vm->display->secure_port."\n";
	echo 'host_id	: '.$vm->host['id']."\n";

}
//<status>powering_down</status>

/////////////////////////

?>
