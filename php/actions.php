<?php

// https://api.instagram.com/v1/media/popular?client_id=e4355740e9db4d6eae2570ce171ac807

//$action = clean($_POST['action']);
$action = $_POST['action'];

switch($action) {

	case 'popular':
		request_popular();
		//phpinfo();
		/*
		$w = stream_get_wrappers();
		echo 'openssl: ',  extension_loaded  ('openssl') ? 'yes':'no', "\n";
		echo 'http wrapper: ', in_array('http', $w) ? 'yes':'no', "\n";
		echo 'https wrapper: ', in_array('https', $w) ? 'yes':'no', "\n";
		echo 'wrappers: ', var_dump($w);
		break;
		*/
}

function clean($str) {
	$str = @trim($str);
	if(get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysql_real_escape_string($str);
}

function request_popular() {
	//Get data from instagram api
	$hashtag = 'max';


	//Query need client_id or access_token
	$query = array(
		'client_id' => 'e4355740e9db4d6eae2570ce171ac807'
	);
	// popular OR recent?
	$url = 'https://api.instagram.com/v1/media/popular?'.http_build_query($query);
	try {
		$curl_connection = curl_init($url);
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);


		//Data are stored in $data as associative array
		$data = json_decode(curl_exec($curl_connection), true);
		curl_close($curl_connection);

		//var_dump($data);

		$img_arr = array();

		foreach($data['data'] as $data_arr) {
			//var_dump($data_arr['images']['standard_resolution']);
			//echo json_encode($data_arr['images']['standard_resolution']);
			array_push($img_arr, $data_arr['images']['standard_resolution']);
		}

		$json_str = json_encode($img_arr);

		echo $json_str;

	} catch(Exception $e) {
		return $e->getMessage();
	}

}

function request_popular_xx() {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://api.instagram.com/v1/media/popular?client_id=e4355740e9db4d6eae2570ce171ac807");
	curl_setopt($ch, CURLOPT_POST, true);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, "client_id=e4355740e9db4d6eae2570ce171ac807");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);

	curl_close($ch);

	echo $response;
}

function request_popular_x()
{
	$data_array = array('client_id' => 'e4355740e9db4d6eae2570ce171ac807');
	$data = http_build_query($data_array);

	$url = 'https://api.instagram.com/v1/media/popular?client_id=e4355740e9db4d6eae2570ce171ac807';

	$optional_headers = null;

	$params = array('http' => array(
						'method' => 'POST'//,
						//'content' => $data
		));

	if($optional_headers !== null) {
		$params['http']['header'] = $optional_headers;
	}

	$ctx = stream_context_create($params);
	$fp = fopen($url, 'r', false, $ctx);

	if(!$fp) {
		throw new Exception("Problem with $url, $php_errormsg");
	}

	$response = @stream_get_contents($fp);

	if($response === false) {
		throw new Exception("Problem reading data from $url, $php_errormsg");
	}

	echo $response;
}


?>