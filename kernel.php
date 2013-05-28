<?php
require_once 'class/ClassLoader.class.php';
ClassLoader::addSourceDir('class/');
spl_autoload_register(array('ClassLoader', 'import'));

function exec_method($object, $methodName, $methodArgs=null)
{
	if(!method_exists($object, $methodName)){
		$className = get_class($object);
		throw new Exception("class '$className' don't has method '$methodName'");
	}
	$callable = array($object, $methodName);
	$funcRef = is_array($methodArgs) ? 'call_user_func_array' : 'call_user_func';
	return $funcRef($callable, $methodArgs);
}

function call_user_func_named_array($methodName, $methodNamedArgs=null)
{
	$reflection_function = new ReflectionFunction($method);
	$methodArgs = array();
	foreach($reflection_function->getParameters() as $reflection_parameter)
	{
		$param_name = $reflection_parameter->name;
		$param_index = $reflection_parameter->getPosition();

		if(isset($methodNamedArgs[$param_name])){
			$methodArgs[$param_index] = $methodNamedArgs[$param_name];
		}else if($reflection_parameter->isOptional()){
			$methodArgs[$param_index] = $reflection_parameter->getDefaultValue();
		}else{
			throw new Exception("miss parameter: $param_name");
		}
	}
	return $reflection_function->invokeArgs($methodArgs);
}

function make_named_array_function($func)
{
	return function($args) use ($func) {
		return call_user_func_named_array($func, $args);
	};
}
/*
call_user_func_named_array($x, ['foo' => 'hello ', 'bar' => 'world']); //Pass all parameterss
call_user_func_named_array($x, ['bar' => 'world']); //Only pass one parameter
call_user_func_named_array($x, []); //Will throw exception

$y = make_named_array_function($x);
$y(['foo' => 'hello ', 'bar' => 'world']); //Pass all parameterss
$y(['bar' => 'world']); //Only pass one parameter
$y([]); //Will throw exception
*/