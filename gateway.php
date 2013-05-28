<?php
//header("Status: 404 Not Found");
require_once 'config.php';
require_once 'kernel.php';
ClassLoader::addSourceDir(SERVICE_DIR);

$http_method = $_SERVER['REQUEST_METHOD'];

if('GET' == $http_method){
	require_once 'service_api_list.php';
	return;
}

$http_body = file_get_contents('php://input');
$response = new Response();

Gateway::recvRequest($http_method, $http_body, $request, $response->data);
Router::route($request, $response);
Gateway::sendResponse($response);