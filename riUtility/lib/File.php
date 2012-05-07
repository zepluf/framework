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
	
	// TODO: log error?
    function sureRemoveDir($dir, $DeleteMe, &$counter) {
		//global $messageStack;
	    if(!$dh = @opendir($dir)){
	    	//$messageStack->add("Could not open dir $dir", 'warning');
	    	return;
	    }
	    //if(self::$file_counter > SSU_MAX_CACHE_DELETE){
	    //	return;
	    //}
	    while (false !== ($obj = readdir($dh))) {
	        if($obj=='.' || $obj=='..') continue;
	        if (!@unlink($dir.'/'.$obj)) $this->sureRemoveDir($dir.'/'.$obj, $DeleteMe, $counter);
	        else $counter++;
	        //if($counter >= SSU_MAX_CACHE_DELETE){
			//			return;
	        //}
	    }
	
	    closedir($dh);
	    if ($DeleteMe){
	        @rmdir($dir);
	    }
	}
}