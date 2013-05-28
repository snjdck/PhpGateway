<?php
function getClassDesc($className)
{
	$result = array();

	$classInfo = new ReflectionClass($className);
	foreach($classInfo->getMethods() as $methodInfo){
		$argList = array();
		foreach($methodInfo->getParameters() as $paramInfo){
			$argList[$paramInfo->getPosition()] = $paramInfo->getName();
		}
		$result[$methodInfo->getName()] = array(
			'args' => $argList,
			'desc' => $methodInfo->getDocComment()
		);
	}

	return $result;
}

function getServiceApiList()
{
	$exclude_list = array('.', '..');
	$file_list = scandir(SERVICE_DIR);
	$result = array();

	foreach($file_list as $file)
	{
		if(in_array($file, $exclude_list)){
			continue;
		}
		if(is_dir(SERVICE_DIR.$file)){
			continue;
		}
		if(false === strrpos($file, ClassLoader::CLASS_FILE_SUFFIX)){
			continue;
		}
		$class_name = basename($file, ClassLoader::CLASS_FILE_SUFFIX);
		$result[$class_name] = getClassDesc($class_name);
	}

	return $result;
}

$api_list = getServiceApiList();
?>
<html>
<head>
	<title>api list</title>
	<link rel="stylesheet" type="text/css" href="static/css/theme.css" />
	<script type="text/javascript" src="static/js/core.js"></script>
</head>
<body>
	<script type="text/javascript">
	</script>
	<div>
		<ul>
			<?php foreach($api_list as $className => $classInfo): ?>
			<li><?= $className ?>
				<ol>
					<?php foreach($classInfo as $methodName => $methodInfo): ?>
					<li>
						<a href=""><?= "$className.$methodName" ?></a>
						<span><?= $methodInfo['desc'] ?></span>
					</li>
					<?php endforeach; ?>
				</ol>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</body>
</html>