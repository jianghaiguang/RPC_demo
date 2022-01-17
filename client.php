<?php

$client = stream_socket_client("tcp://164.155.78.11:8887", $errno, $errstr);
if (!$client) {
	echo '异常代码:'.$errno.',异常信息：'.$errstr;exit;
}
//$data['class'] = 'user';
//$data['method'] = 'get_name';
//$data['param'] = '12';
$data['class'] = $_GET['c'];
$data['method'] = $_GET['m'];
$data['param'] = 12;
$_data = json_encode($data);
fwrite($client, $_data);

$server_data = fread($client, 2048);
$resutl = json_decode($server_data);
fclose($client);

var_dump($resutl);die;

