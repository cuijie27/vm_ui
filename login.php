<?php
//https://v001.ganshane.com/ovirt-engine/sso/login.html
require("./getVMInfo.php");


$usrName = $_POST['username'];
$pswd = $_POST['password'];

$userpwd_u = $usrName."@internal:".$pswd;

$ret = getVMInfo($userpwd_u);

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

?>
