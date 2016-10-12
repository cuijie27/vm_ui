<?php
function getCa(){
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_VERBOSE, true);	// -v

	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//-k
	curl_setopt($ch, CURLOPT_URL, "https://v001.ganshane.com/ovirt-engine/services/pki-resource?resource=ca-certificate&format=X509-PEM-CA");
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
		//echo '返回结果为：'.$ret;
	}

	curl_close($ch);

	return $ret;	
}
?>