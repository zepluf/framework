<?php
namespace plugins\riUtility;

class File{
    public function getRelativePath($from, $to)
	{
		$from = explode('/', $from);
		$to = explode('/', $to);
		foreach($from as $depth => $dir)
		{

			if(isset($to[$depth]))
			{
				if($dir === $to[$depth])
				{
					unset($to[$depth]);
					unset($from[$depth]);
				}
				else
				{
					break;
				}
			}
		}
		//$rawresult = implode('/', $to);
		for($i=0;$i<count($from)-1;$i++)
		{
			array_unshift($to,'..');
		}
		$result = implode('/', $to);
		return $result;
	}
}