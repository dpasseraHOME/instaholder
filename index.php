<?php

//https://api.instagram.com/v1/tags/architecture/media/recent?client_id=e4355740e9db4d6eae2570ce171ac807

requestByTag("architecture");

function requestByTag($tagStr) {
	//Query need client_id or access_token
	$query = array(
		'client_id' => 'e4355740e9db4d6eae2570ce171ac807'
	);
	$url = 'https://api.instagram.com/v1/tags/'.$tagStr.'/media/recent?'.http_build_query($query);

	makeCall($url);
}

function requestByUserName($userName) {
	// TODO: search by name, retrieve user id
	// TODO: on search complete, requestByUserId(123);
}

function requestByUserId($userId) {
	//Query need client_id or access_token
	$query = array(
		'client_id' => 'e4355740e9db4d6eae2570ce171ac807'
	);
	$url = 'https://api.instagram.com/v1/users/'.$userId.'/?'.http_build_query($query);

	makeCall($url);
}

//17710590
function requestKen() {
	//Query need client_id or access_token
	$query = array(
		'client_id' => 'e4355740e9db4d6eae2570ce171ac807'
	);
	$url = 'https://api.instagram.com/v1/users/17710590/?'.http_build_query($query);

	makeCall($url);
}

function makeCall($url) {
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

?>