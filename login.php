<?php
require("./getVMInfo.php");
require("./getCa.php");
require("./getPswd.php");


$usrName = $_POST['username'];
$pswd = $_POST['password'];

$userpwd_u = $usrName."@internal:".$pswd;

$vmArr = getVMInfo($userpwd_u);

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

//getCa();

//getPswd();


?>
