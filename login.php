<?php
require("./getVMInfo.php");


$usrName = $_POST['username'];
$pswd = $_POST['password'];

$userpwd_u = $usrName."@internal:".$pswd;

$vmArr = getVMInfo($userpwd_u);

echo "<table border=1>";
echo "<tr>";
echo "<td>虚拟机名称</td>";
echo "<td>虚拟机状态</td>";
echo "<td>打开虚拟机</td>";
echo "<td>重启</td>";
echo "</tr>";
foreach($vmArr as $vm){

	echo "<tr>";
	echo "<td>".$vm['vmName']."</td>";
	echo "<td>".$vm['status']."</td>";
	echo "<td><a href=\"./third.php?vmid=".$vm["vmId"]."&hostid=".$vm["hostId"]."&usrpswd=".$userpwd_u."\">连接虚拟机 ".$vm['vmName']."</a></td>";
	echo "</tr>";
}
echo "</table>";

//print_r($vmArr);

?>
