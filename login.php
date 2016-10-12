<?php
//https://v001.ganshane.com/ovirt-engine/sso/login.html
require("./getVMInfo.php");
require("./getHostInfo.php");
require("./getCa.php");
require("./getPswd.php");


$usrName = $_POST['username'];
$pswd = $_POST['password'];

$userpwd_u = $usrName."@internal:".$pswd;

$ret = getVMInfo($userpwd_u);

$xml = new SimpleXMLElement($ret);
$vms = $xml->xpath('/vms/vm');

$vmArr = array();
$i = 0;
foreach($vms as $vm){
	$vmName = $vm->name;
	$vmId = $vm['id'];
	$vmStatus = $vm->status;
	$vmPort = $vm->display->secure_port;
	$hostId = $vm->host['id'];

	$vmArr[$i] = array();
	$vmArr[$i]['vmName'] = $vmName;
	$vmArr[$i]['vmId'] = $vmId;
	$vmArr[$i]['status'] = $vmStatus;
	$vmArr[$i]['port'] = $vmPort;
	$vmArr[$i]['hostId'] = $hostId;

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

echo "<table border=1>";
echo "<tr>";
echo "<td>虚拟机名称</td>";
echo "<td>打开虚拟机</td>";
echo "</tr>";
foreach($vmArr as $vm){

	echo "<tr>";
	echo "<td>".$vm['vmName']."</td>";
	echo "<td>".$vm['vmName']."</td>";
	echo "</tr>";
}
echo "</table>";

print_r($vmArr);

getCa();

getPswd();


?>
