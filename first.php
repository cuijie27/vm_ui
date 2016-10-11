<?php
include_once "xx_xml.class.php";
//curl --cacert ./ca.pem -u admin@internal:5idoris -H "Content-Type: application/xml" -X GET "https://v001.ganshane.com/ovirt-engine/api/hosts/d9e1a4f5-c7bb-4cb2-b43a-26640e902138" -v

// 去掉-X GET 参数也是可以运行，得出结果的。
//curl --cacert ./ca.pem -u admin@internal:5idoris -H "Content-Type: application/xml" "https://v001.ganshane.com/ovirt-engine/api/hosts/d9e1a4f5-c7bb-4cb2-b43a-26640e902138" -v
echo 'hello vm worldss<br>';

$ch = curl_init();

curl_setopt($ch, CURLOPT_VERBOSE, true);	// -v
curl_setopt($ch, CURLOPT_USERPWD, "admin@internal:5idoris");	//-u
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
curl_setopt($ch, CURLOPT_URL, "https://v001.ganshane.com/ovirt-engine/api/hosts/d9e1a4f5-c7bb-4cb2-b43a-26640e902138");		// url

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
	echo '返回结果为：'.$ret;
}


curl_close($ch);

/////////////////////////
/*    <certificate>
        <organization>localdomain</organization>
        <subject>O=localdomain,CN=192.168.0.188</subject>
    </certificate>*/
echo "$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$\n";
$xml = new SimpleXMLElement($ret);
$vms = $xml->xpath('/host/certificate');
foreach($vms as $vm){
	echo 'organization : '. $vm->organization."\n";
	echo 'subject: '.$vm->subject."\n";
}
//<status>powering_down</status>

/////////////////////////

?>
