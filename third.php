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


echo 'hello vm worldss<br>';

$fp = fopen('test.vv', 'w');
fwrite($fp, '1');
fwrite($fp, '23');
fclose($fp);

?>
