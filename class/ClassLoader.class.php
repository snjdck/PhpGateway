<?php
final class ClassLoader
{
	const CLASS_FILE_SUFFIX = '.class.php';
	static private $sourceDirList = array('');

	static public function addSourceDir($dirPath)
	{
		self::$sourceDirList[] = $dirPath;
	}

	static public function import($className)
	{
		$fileName = self::getFileName($className);
		require_once $fileName;
		if(!class_exists($className)){
			throw new Exception("class '$className' don't found in $fileName.");
		}
	}

	static private function getFileName($className)
	{
		foreach(self::$sourceDirList as $sourceDir){
			$fileName = $sourceDir . $className . self::CLASS_FILE_SUFFIX;
			if(file_exists($fileName)){
				return $fileName;
			}
		}
		throw new Exception("class '$className' don't found in source paths.");
	}
}