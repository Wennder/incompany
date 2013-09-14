<?php
$page= get_url_contents("http://na.ntrsupport.com/inquiero/helpdesk/default.asp?skclient=&lang=br&con=1&online=1&bonline=1&video=&hdcli=&usrrand=5650342000222379871&login=22237&surpre=&sur=&oper=&cat=&cob=0&txtcolor=&bgcolor=&buttoncolor=&ref=&ref2=&tframe=&url=&hd=3&hduser=&URLOffline=&URLbusy=&TransferMsg=1&t=&k=");
echo $page;
function get_url_contents($url){
$crl = curl_init();
$timeout = 5;
curl_setopt ($crl, CURLOPT_URL,$url);
curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
$ret = curl_exec($crl);
curl_close($crl);
return $ret;
}
?>
