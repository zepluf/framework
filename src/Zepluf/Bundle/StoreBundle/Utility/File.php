<?php

namespace Zepluf\Bundle\StoreBundle\Utility;

/**
 * File Utilities offers convenience methods to handle files and directories
 */
class File extends \Symfony\Component\Filesystem\Filesystem
{
    protected $path = array();

    protected $stringUtility;

    /**
     * Constructor
     * @param $stringUtility
     */
    public function __construct($stringUtility)
    {
        $this->stringUtility = $stringUtility;
    }

    /**
     * Get relative path between 2 directories
     * @param $from
     * @param $to
     * @return string
     */
    public function getRelativePath($from, $to)
    {
        $from = explode(DIRECTORY_SEPARATOR, realpath($from));
        $to = explode(DIRECTORY_SEPARATOR, realpath($to));

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
        $depth = count($from);
        for ($i = 0; $i < $depth; $i++) {
            array_unshift($to, '..');
        }

        $result = implode('/', $to);

        return $result;
    }

    /**
     * Generate a unique filename in specific directory
     * @param $absolute_path
     * @param $name
     * @return mixed
     */
    public function generateUniqueName($absolute_path, $name)
    {
        $now = time();
        while (file_exists($absolute_path . $name)) {
            $now++;
            $name = $now . '-' . $name;
        }

        return $name;
    }

    /**
     * @param $name
     * @param $cache_folder
     * @param int $use_subfolder
     * @return string
     */
    public function calculatePath($name, $cache_folder, $use_subfolder = 0)
    {
        if ($use_subfolder > 0) {
            $name = $this->stringUtility->stripNonAlphaNumeric(strtolower($name));
            $path = substr($name, 0, $use_subfolder);
            $cache_folder .= chunk_split($path, 1, '/');
        }

        $cache_folder = trim($cache_folder, '/');

        return $cache_folder;
    }

    /**
     * Upload file to a specific dir
     * @param $name
     * @param $tmp_name
     * @param $absolute_destination_path
     * @param int $use_subfolder
     * @return array
     */
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
    /**
     * Remove a dirs even contains hidden files.
     * @param string $dir The target directory
     * @param bool $DeleteMe If true delete also $dir, if false leave it alone
     * @return mixed
     */
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

    /**
     * Write to file with given data
     * @param $file
     * @param $data
     * @param int $chmod
     */
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
            touch($file, time() + 3600);

            if ($chmod != 0) @chmod($file, $chmod);
        }
    }

    /**
     * @param $request_type
     * @return mixed
     */
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

    /**
     * @param $request_type
     * @return mixed
     */
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
     * @param       string   $destination      Destination path
     * @param       int   $permissions New folder creation permissions
     * @return      bool     Returns true on success, false on failure
     */
    public function xcopy($source, $destination, $permissions = 0755)
    {
        if (is_readable($source)) {
            // Check for symlinks
            if (is_link($source)) {
                return symlink(readlink($source), $destination);
            }

            // Simple copy for a file
            if (is_file($source)) {
                return copy($source, $destination);
            }

            // Make destination directory
            if (!is_dir($destination)) {
                riMkDir($destination, $permissions);
            }

            // Loop through the folder
            $dir = dir($source);
            while (false !== $entry = $dir->read()) {
                // Skip pointers
                if ($entry == '.' || $entry == '..') {
                    continue;
                }

                // Deep copy directories
                $this->xcopy("$source/$entry", "$destination/$entry", $permissions);
            }

            // Clean up
            $dir->close();

            return true;
        } else {

            return false;
        }
    }

    /**
     * Make a filename safe to use in any function. (Accents, spaces, special chars...)
     * The iconv function must be activated.
     *
     * @param string  $fileName       The filename to sanitize (with or without extension)
     * @param string  $defaultIfEmpty The default string returned for a non valid filename (only special chars or separators)
     * @param string  $separator      The default separator
     * @param boolean $lowerCase      Tells if the string must converted to lower case
     *
     * @author COil <https://github.com/COil>
     * @see    http://stackoverflow.com/questions/2668854/sanitizing-strings-to-make-them-url-and-filename-safe
     *
     * @return string
     */
    public function sanitizeFilename($fileName, $defaultIfEmpty = 'default', $separator = '_', $lowerCase = true)
    {
        // Gather file informations and store its extension
        $fileInfos = pathinfo($fileName);
        $fileExt   = array_key_exists('extension', $fileInfos) ? '.'. strtolower($fileInfos['extension']) : '';

        // Removes accents
        $fileName = @iconv('UTF-8', 'us-ascii//TRANSLIT', $fileInfos['filename']);

        // Removes all characters that are not separators, letters, numbers, dots or whitespaces
        $fileName = preg_replace("/[^ a-zA-Z". preg_quote($separator). "\d\.\s]/", '', $lowerCase ? strtolower($fileName) : $fileName);

        // Replaces all successive separators into a single one
        $fileName = preg_replace('!['. preg_quote($separator).'\s]+!u', $separator, $fileName);

        // Trim beginning and ending seperators
        $fileName = trim($fileName, $separator);

        // If empty use the default string
        if (empty($fileName)) {
            $fileName = $defaultIfEmpty;
        }

        return $fileName. $fileExt;
    }
}