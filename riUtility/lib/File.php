<?php
namespace plugins\riUtility;

use plugins\riPlugin\Plugin;

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

    public function generateUniqueName($absolute_path, $name){
        $now = time();
        while(file_exists($absolute_path.$name)){
            $now++;
            $name = $now.'-'.$name;
        }
        return $name;
    }

    public function calculatePath($name, $cache_folder, $use_subfolder = 0){
        if($use_subfolder > 0){
            $name = Plugin::get('riUtility.String')->stripNonAlphaNumeric(strtolower($name));
            $path = substr($name , 0, $use_subfolder);
            $cache_folder .= chunk_split($path, 1, '/');
        }

        $cache_folder = trim($cache_folder, '/');

        return $cache_folder;
    }

    public function mkDir($absolute_path, $chmod = '0777'){
        $success = false;
        if(!is_dir($final_path)){
            $old_umask = umask(0);
            $success = @mkdir($absolute_path, $chmod, true);
            umask($old_umask);
        }
        return $success;
    }

    public function uploadFile($name, $tmp_name, $absolute_destination_path, $use_subfolder = 0){
        $_files_name = $relative_path = '';

        $absolute_destination_path = rtrim($absolute_destination_path, '/') . '/';

        $relative_path = $this->calculatePath($name, '', $use_subfolder);

        $final_path = !empty($relative_path) ? $absolute_destination_path . $relative_path . '/' : $absolute_destination_path;
        // create the folder if not exists
        $this->mkDir($final_path);

        // generate a new name if the file is already there
        if(file_exists($final_path . $name)){
            $name = $this->generateUniqueName($final_path, $name);
        }

        $is_moved = @move_uploaded_file($tmp_name, $final_path . $name);

        return array($is_moved, $relative_path, $name);
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
	
	public function write($file, $data, $chmod = 0){
	    
	    // if the dir does not exist lets try to generate it
	    $dir = dirname($file);
	    if(!is_dir($dir)){
			$old_umask = umask(0);
			@mkdir($dir, 0777, true);
			umask($old_umask);
		}
		
	    if ($fp = @fopen($file, 'wb')) {

	        // lock file for writing
			if (flock($fp, LOCK_EX)) {
				$written = fwrite($fp, $data);
			}
			fclose($fp);

			// Set filemtime
			touch(file, time() + 3600);
			
			if($chmod != 0)	@chmod($file, $chmod);			
		}
	}
}