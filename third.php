<?php
//////////////////////////////////////////////////////////////////
// first step
//curl --cacert ./ca.pem -u admin@internal:5idoris -H "Content-Type: application/xml" -X GET "https://v001.ganshane.com/ovirt-engine/api/hosts/d9e1a4f5-c7bb-4cb2-b43a-26640e902138" -v
// 去掉-X GET 参数也是可以运行，得出结果的。
//curl --cacert ./ca.pem -u admin@internal:5idoris -H "Content-Type: application/xml" "https://v001.ganshane.com/ovirt-engine/api/hosts/d9e1a4f5-c7bb-4cb2-b43a-26640e902138" -v



//////////////////////////////////////////////////////////////////
// second step
// curl -v -T ./ca.xml --cacert ./ca.pem -u admin@internal:5idoris -H "Content-Type: application/xml" -X POST "https://v001.ganshane.com/ovirt-engine/api/vms/24a9b519-9748-4662-b785-e3db7dcdc7e1/ticket"



//////////////////////////////////////////////////////////////////
// third step create console.vv
//bash-3.2$ /Applications/RemoteViewer.app/Contents/MacOS/RemoteViewer --spice-ca-file ca.pem --spice-host-subject "O-localdomain,CN=192.168.0.188" spice://192.168.0.188/?port=-1\&tls-port=5901

require("./getPswd.php");
require("./getCa.php");
require("./getVMInfo.php");

$vmid=$_GET['vmid'];
$hostid=$_GET['hostid'];
$usrpswd=$_GET['usrpswd'];

/*
echo $vmid."<br>";
echo $usrpswd."<br>";
echo $hostid."<br>";
*/

$pswd = getPswd($usrpswd, $vmid);
$vmInfoArr = getVMInfo($usrpswd);
$type = '';
$host = '';
$title = '';
$tlsPort = '';
$hostSubject = '';

//print_r($vmInfoArr);

foreach($vmInfoArr as $vm){
	if (0 == strcmp($vm['vmId'], $vmid)){
		$type = $vm['vmType'];
		$host = $vm['address'];
		$title = $vm['vmName'];	
		$tlsPort = $vm['port'];
		$hostSubject = $vm['subject'];
	}
}
//echo $pswd;


$ca=getCa();

//$cc = strstr($ca, "\n");
//echo $cc;die;

$cc = str_replace("\n", "\\n", $ca);

if ("" == $pswd){
	echo "the pswd is empty";
}

header("Content-type:application/x-virt-viewer");

$console = "[virt-viewer]
type=".$type."
host=".$host."
port=-1
password=".$pswd."
# Password is valid for 120 seconds.
delete-this-file=1
fullscreen=0
title=".$title.":%d
toggle-fullscreen=shift+f11
release-cursor=shift+f12
secure-attention=ctrl+alt+end
tls-port=".$tlsPort."
enable-smartcard=0
enable-usb-autoshare=1
usb-filter=-1,-1,-1,-1,0
tls-ciphers=DEFAULT
host-subject=".$hostSubject."
ca=".$cc."
secure-channels=main;inputs;cursor;playback;record;display;smartcard;usbredir
versions=rhev-win64:2.0-160;rhev-win32:2.0-160;rhel7:2.0-6;rhel6:99.0-1
newer-version-url=http://www.ovirt.org/documentation/admin-guide/virt/console-client-resources";

//ca=-----BEGIN CERTIFICATE-----\\nMIIDxjCCAq6gAwIBAgICEAAwDQYJKoZIhvcNAQEFBQAwSTELMAkGA1UEBhMCVVMxFDASBgNVBAoT\\nC2xvY2FsZG9tYWluMSQwIgYDVQQDExtsb2NhbGhvc3QubG9jYWxkb21haW4uMzQxOTMwHhcNMTYx\\nMDA3MTA1OTUxWhcNMjYxMDA2MTA1OTUxWjBJMQswCQYDVQQGEwJVUzEUMBIGA1UEChMLbG9jYWxk\\nb21haW4xJDAiBgNVBAMTG2xvY2FsaG9zdC5sb2NhbGRvbWFpbi4zNDE5MzCCASIwDQYJKoZIhvcN\\nAQEBBQADggEPADCCAQoCggEBAKRnHd0IKsXkDXk6YExJJT2E/fns6xDtYe/M6FpTT9E3YyBg8nSk\\nq9Zkj4vNhik9fO2/E8UG/DY0/I27WiAzreoWkTePvdn1JzLbGUuRf5a4gV9RVI1cQNcpY7rqQ7Gn\\nOhOozyrfp1HfXqocWyOP/n5ukMcbmWll3YFWUL4yLpTSJvf/EDhcYELj5IZP3bmtFAYCbsnQ6f/F\\nfycFQcgOvwfvPkfMPK3Pvs8OI4/1keKFlTuzns+zJlIEeF/vF8oSjeKfgyb3olLd7MlRxXqDGfF1\\nbP3jdeo1rfdmZPykZsJXRBrNptjrKU6ddzFosoXqAni93z6x4ZyxHguzzczJ0wUCAwEAAaOBtzCB\\ntDAdBgNVHQ4EFgQUXDoVO+rAo72kvftUj3bGUOAnkDYwcgYDVR0jBGswaYAUXDoVO+rAo72kvftU\\nj3bGUOAnkDahTaRLMEkxCzAJBgNVBAYTAlVTMRQwEgYDVQQKEwtsb2NhbGRvbWFpbjEkMCIGA1UE\\nAxMbbG9jYWxob3N0LmxvY2FsZG9tYWluLjM0MTkzggIQADAPBgNVHRMBAf8EBTADAQH/MA4GA1Ud\\nDwEB/wQEAwIBBjANBgkqhkiG9w0BAQUFAAOCAQEAFxgyVSLr0qb8SPVzBkI/f2vfDwGzdrZ3cSuS\\nGgPmYzdPapTHNqosYH1ax2K+7oeBDGtiP5FW31JPdfBbITfv3TPo8L9RXy+MXJze8WMkfbRiOsdt\\nwp2czgENt3K4DVeMoR1Sy+nPph+giqHl/JSTiHP4mHd/+PAqIT9v/WVlT064MPxjKj2jdRKzJwON\\nXUvnjR7orQvsJXU9n0Yn3ob1RU03+I3VoQ3lFPp9HlkVeeA/9rkoNDb+1intkMXpOCG8FSLpMzvZ\\ndN93oJJVx/W53o8fyfJCcfTVkDVZvG+xu0Aw/l8GEG38QYv/eOCUmbsRRLs6xFSdHl4vcC6lzoTD\\now==\\n-----END CERTIFICATE-----\\n
echo $console; 

/*

$fp = fopen('test.vv', 'w');
//fwrite($fp, $content);
fwrite($fp, "[virt-viewer]\n");
fwrite($fp, "type=spice\n");
fwrite($fp, "host=192.168.0.188\n");
fwrite($fp, "port=-1\n");
fwrite($fp, "password=fSVOo5tB69vF\n");
fwrite($fp, "delete-this-file=1\n");
fwrite($fp, "fullscreen=0\n");
fwrite($fp, "title=test:%d\n");
fwrite($fp, "toggle-fullscreen=shift+f11\n");
fwrite($fp, "release-cursor=shift+f12\n");
fwrite($fp, "secure-attention=ctrl+alt+end\n");
fwrite($fp, "tls-port=5901\n");
fwrite($fp, "enable-smartcard=0\n");
fwrite($fp, "enable-usb-autoshare=1\n");
fwrite($fp, "usb-filter=-1,-1,-1,-1,0\n");
fwrite($fp, "tls-ciphers=DEFAULT\n");
fwrite($fp, "host-subject=O=localdomain,CN=192.168.0.188\n");
fwrite($fp, "ca=-----BEGIN CERTIFICATE-----\nMIIDxjCCAq6gAwIBAgICEAAwDQYJKoZIhvcNAQEFBQAwSTELMAkGA1UEBhMCVVMxFDASBgNVBAoT\nC2xvY2FsZG9tYWluMSQwIgYDVQQDExtsb2NhbGhvc3QubG9jYWxkb21haW4uMzQxOTMwHhcNMTYx\nMDA3MTA1OTUxWhcNMjYxMDA2MTA1OTUxWjBJMQswCQYDVQQGEwJVUzEUMBIGA1UEChMLbG9jYWxk\nb21haW4xJDAiBgNVBAMTG2xvY2FsaG9zdC5sb2NhbGRvbWFpbi4zNDE5MzCCASIwDQYJKoZIhvcN\nAQEBBQADggEPADCCAQoCggEBAKRnHd0IKsXkDXk6YExJJT2E/fns6xDtYe/M6FpTT9E3YyBg8nSk\nq9Zkj4vNhik9fO2/E8UG/DY0/I27WiAzreoWkTePvdn1JzLbGUuRf5a4gV9RVI1cQNcpY7rqQ7Gn\nOhOozyrfp1HfXqocWyOP/n5ukMcbmWll3YFWUL4yLpTSJvf/EDhcYELj5IZP3bmtFAYCbsnQ6f/F\nfycFQcgOvwfvPkfMPK3Pvs8OI4/1keKFlTuzns+zJlIEeF/vF8oSjeKfgyb3olLd7MlRxXqDGfF1\nbP3jdeo1rfdmZPykZsJXRBrNptjrKU6ddzFosoXqAni93z6x4ZyxHguzzczJ0wUCAwEAAaOBtzCB\ntDAdBgNVHQ4EFgQUXDoVO+rAo72kvftUj3bGUOAnkDYwcgYDVR0jBGswaYAUXDoVO+rAo72kvftU\nj3bGUOAnkDahTaRLMEkxCzAJBgNVBAYTAlVTMRQwEgYDVQQKEwtsb2NhbGRvbWFpbjEkMCIGA1UE\nAxMbbG9jYWxob3N0LmxvY2FsZG9tYWluLjM0MTkzggIQADAPBgNVHRMBAf8EBTADAQH/MA4GA1Ud\nDwEB/wQEAwIBBjANBgkqhkiG9w0BAQUFAAOCAQEAFxgyVSLr0qb8SPVzBkI/f2vfDwGzdrZ3cSuS\nGgPmYzdPapTHNqosYH1ax2K+7oeBDGtiP5FW31JPdfBbITfv3TPo8L9RXy+MXJze8WMkfbRiOsdt\nwp2czgENt3K4DVeMoR1Sy+nPph+giqHl/JSTiHP4mHd/+PAqIT9v/WVlT064MPxjKj2jdRKzJwON\nXUvnjR7orQvsJXU9n0Yn3ob1RU03+I3VoQ3lFPp9HlkVeeA/9rkoNDb+1intkMXpOCG8FSLpMzvZ\ndN93oJJVx/W53o8fyfJCcfTVkDVZvG+xu0Aw/l8GEG38QYv/eOCUmbsRRLs6xFSdHl4vcC6lzoTD\now==\n-----END CERTIFICATE-----\n\n");
fwrite($fp, "secure-channels=main;inputs;cursor;playback;record;display;smartcard;usbredir\n");
fwrite($fp, "versions=rhev-win64:2.0-160;rhev-win32:2.0-160;rhel7:2.0-6;rhel6:99.0-1\n");
fwrite($fp, "newer-version-url=http://www.ovirt.org/documentation/admin-guide/virt/console-client-resources\n");
fwrite($fp, "release-cursor=shift+f12\n");
//fwrite($fp, "1\n");
//fwrite($fp, "23\n");
fclose($fp);
*/

?>
