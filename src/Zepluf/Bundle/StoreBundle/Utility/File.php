<?php

namespace Zepluf\Bundle\StoreBundle\Utility;

use plugins\riPlugin\Plugin;

class File
{
    protected $path = array();

    public function getRelativePath($from, $to)
    {
        $from = explode('/', $from);
        $to = explode('/', $to);
        foreach ($from as $depth => $dir) {

            if (isset($to[$depth])) {
                if ($dir === $to[$depth]) {
                    unset($to[$depth]);
                    unset($from[$depth]);
                } else {
                    break;
                }
            }
        }
        //$rawresult = implode('/', $to);
        for ($i = 0; $i < count($from) - 1; $i++) {
            array_unshift($to, '..');
        }
        $result = implode('/', $to);
        return $result;
    }

    public function generateUniqueName($absolute_path, $name)
    {
        $now = time();
        while (file_exists($absolute_path . $name)) {
            $now++;
            $name = $now . '-' . $name;
        }
        return $name;
    }

    public function calculatePath($name, $cache_folder, $use_subfolder = 0)
    {
        if ($use_subfolder > 0) {
            $name = Plugin::get('riUtility.String')->stripNonAlphaNumeric(strtolower($name));
            $path = substr($name, 0, $use_subfolder);
            $cache_folder .= chunk_split($path, 1, '/');
        }

        $cache_folder = trim($cache_folder, '/');

        return $cache_folder;
    }

    public function uploadFile($name, $tmp_name, $absolute_destination_path, $use_subfolder = 0)
    {
        $_files_name = $relative_path = '';

        $absolute_destination_path = rtrim($absolute_destination_path, '/') . '/';

        $relative_path = $this->calculatePath($name, '', $use_subfolder);

        $final_path = !empty($relative_path) ? $absolute_destination_path . $relative_path . '/' : $absolute_destination_path;
        // create the folder if not exists
        riMkDir($final_path);

        // generate a new name if the file is already there
        if (file_exists($final_path . $name)) {
            $name = $this->generateUniqueName($final_path, $name);
        }

        $is_moved = @move_uploaded_file($tmp_name, $final_path . $name);

        return array($is_moved, $relative_path, $name);
    }

    // TODO: log error?
    function sureRemoveDir($dir, $DeleteMe = false)
    {

        static $counter = 0;

        //global $messageStack;
        if (!$dh = @opendir($dir)) {
            //$messageStack->add("Could not open dir $dir", 'warning');
            return $counter;
        }

        while (false !== ($obj = readdir($dh))) {
            if ($obj == '.' || $obj == '..') continue;
            if (!@unlink($dir . '/' . $obj)) $this->sureRemoveDir($dir . '/' . $obj, $DeleteMe);
            else $counter++;

        }

        closedir($dh);
        if ($DeleteMe) {
            @rmdir($dir);
        }

        return $counter;
    }

    public function write($file, $data, $chmod = 0)
    {

        // if the dir does not exist lets try to generate it
        $dir = dirname($file);
        riMkDir($dir);

        if ($fp = @fopen($file, 'wb')) {

            // lock file for writing
            if (flock($fp, LOCK_EX)) {
                $written = fwrite($fp, $data);
            }
            fclose($fp);

            // Set filemtime
            touch(file, time() + 3600);

            if ($chmod != 0) @chmod($file, $chmod);
        }
    }

    public function getAdminToCatalogRelativePath($request_type)
    {
        if (!isset($this->path['a2c'][$request_type])) {
            if ($request_type == "SSL") {
                $admin_path = DIR_WS_HTTPS_ADMIN;
                $catalog_path = DIR_WS_HTTPS_CATALOG;
            } else {
                $admin_path = DIR_WS_ADMIN;
                $catalog_path = DIR_WS_CATALOG;
            }
            $this->path['a2c'][$request_type] = $this->getRelativePath($admin_path, $catalog_path);
        }
        return $this->path['a2c'][$request_type];
    }

    public function getCatalogToAdminRelativePath($request_type)
    {
        if (!isset($this->path['c2a'][$request_type])) {
            if ($request_type == "SSL") {
                $admin_path = DIR_WS_HTTPS_ADMIN;
                $catalog_path = DIR_WS_HTTPS_CATALOG;
            } else {
                $admin_path = DIR_WS_ADMIN;
                $catalog_path = DIR_WS_CATALOG;
            }
            $this->path['c2a'][$request_type] = $this->getRelativePath($catalog_path, $admin_path);
        }
        return $this->path['c2a'][$request_type];
    }

    /**
     * Copy a file, or recursively copy a folder and its contents
     * @param       string   $source    Source path
     * @param       string   $dest      Destination path
     * @param       string   $permissions New folder creation permissions
     * @return      bool     Returns true on success, false on failure
     */
    public function xcopy($source, $dest, $permissions = 0755)
    {
        if(is_readable($source)){
            // Check for symlinks
            if (is_link($source)) {
                return symlink(readlink($source), $dest);
            }

            // Simple copy for a file
            if (is_file($source)) {
                return copy($source, $dest);
            }

            // Make destination directory
            if (!is_dir($dest)) {
                riMkDir($dest, $permissions);
            }

            // Loop through the folder
            $dir = dir($source);
            while (false !== $entry = $dir->read()) {
                // Skip pointers
                if ($entry == '.' || $entry == '..') {
                    continue;
                }

                // Deep copy directories
                $this->xcopy("$source/$entry", "$dest/$entry", $permissions);
            }

            // Clean up
            $dir->close();
            return true;
        }
        else {
            return false;
        }
    }
}