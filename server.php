<?php

$stock_server = stream_socket_server("tcp://164.155.78.11:8887",$errno, $errstr);

if(!$stock_server) {
	echo '异常代码：'.$errno.',异常信息'.$errstr;exit;
}
while(1) {
	try {
		$return_data = [];
		$buff = stream_socket_accept($stock_server);
		$data = fread($buff, 2048);
		$_json_data = json_decode($data, true);
		$class = $_json_data['class'];//客户端访问的类
		$file = $class.".php";
		if(!file_exists($file)) {
			throw new Exception("文件不存在", -1);
		}
		require_once $file;
		$method = $_json_data['method'];//客户端访问的方法
		$user_obj = new $class();
		if(isset($_json_data['param']) && !empty($_json_data['param'])) {
			$param = $_json_data['param'];
			$server_data = $user_obj->$method($param);
		}else{
			$server_data = $user_obj->$method();
		}
		$server_data = $user_obj->$method($param);
			
		$return_data['code'] = 1;
		$return_data['data'] = $server_data;
		$return_data['msg'] = 'ok';
		$return_data = json_encode($return_data);
		fwrite($buff,$return_data);
		fclose($buff);

	} catch (Exception $e) {
		$return_data['code'] = $e->getCode();
		$return_data['data'] = '';
		$return_data['msg'] = $e->getMessage();
		$return_data = json_encode($return_data);
		fwrite($buff, $server_data);
	}
	

















































}


