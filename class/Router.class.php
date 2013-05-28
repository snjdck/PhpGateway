<?php
final class Router
{
	static public function route($request, $response)
	{
		if(null == $request){
			return;
		}

		$opList = explode('.', $request->op, 2);

		if(count($opList) < 2){
			$response->data = 'op format error';
			return;
		}
		
		list($className, $methodName) = $opList;

		try{
			$response->data = exec_method(new $className(), $methodName, $request->data);
			$response->ok = true;
		}catch(Exception $error){
			$response->data = $error->getMessage();
		}
	}
}