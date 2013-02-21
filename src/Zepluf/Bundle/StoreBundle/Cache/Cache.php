<?php

namespace Zepluf\Bundle\StoreBundle\Cache;

/**
 * @package Pages
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: cache.php 274 2009-11-20 17:13:45Z yellow1912 $
 */
class Cache
{

    /**
     * @var
     */
    protected $cache;

    /**
     * @var
     */
    protected $path;

    /**
     * @var
     */
    protected $status;

    /**
     * @var array
     */
    protected $blocks = array();

    /**
     * @var
     */
    protected $cacheDir;

    /**
     * @param $settings
     */

    /**
     * @var
     */
    protected $utilityFile;

    public function __construct($status, $utilityFile, $cacheDir)
    {
        $this->utilityFile = $utilityFile;
        $this->status = $status;
        $this->cacheDir = $cacheDir;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function write($file, $content, $use_subfolder = false)
    {

        if (!$this->status) {
            return false;
        }

        $cache_folder = dirname($file);

        // if this dir does not exist, assuming we need to append absolute cache path
        if (!is_dir($cache_folder) && !$this->utilityFile->isAbsolutePath($cache_folder)) {
            $cache_folder = $this->cacheDir . '/' . $cache_folder;
        }

        $name = basename($file);

        $this->cache[$cache_folder][$name] = array(
            'time' => time(),
            'content' => $content
        );

        $cache_folder = $this->calculatePath($name, $cache_folder, $use_subfolder);

        $cache_file = "$cache_folder/$name";

        $written = 0;
        if ($fp = @fopen($cache_file, 'wb')) {

            // lock file for writing
            if (flock($fp, LOCK_EX)) {
                $written = fwrite($fp, $content);
            }
            fclose($fp);

            // Set filemtime
            touch($cache_file, time() + 3600);

            //@chmod($cache_file, 0777);
        }

        return $written !== false && $written > 0 ? $cache_file : false;
    }

    public function read($file, $time = 0, $use_subfolder = false)
    {

        if (!$this->status) {
            return false;
        }

        $cache_folder = dirname($file);

        // if this dir does not exist, assuming we need to append absolute cache path
        if (!is_dir($cache_folder) && !$this->utilityFile->isAbsolutePath($cache_folder)) {
            $cache_folder = $this->cacheDir . '/' . $cache_folder;
        }

        $name = basename($file);

        // TODO: we may want to check time here
        if (isset($this->cache[$cache_folder][$name])) {
            return $this->cache[$cache_folder][$name]['content'];
        }

        $cache_folder = $this->calculatePath($name, $cache_folder, $use_subfolder);

        $cache_file = "$cache_folder/$name";

        if (is_file($cache_file) && is_readable($cache_file)) {
            $mtime = filemtime($cache_file);
            if ($time > 0) {
                if (time() - $mtime > $time) {
                    return false;
                }
            }

            $read = @file_get_contents($cache_file);

            $this->cache[$cache_folder][$name] = array(
                'time' => $mtime,
                'content' => $read
            );

            return $read ? $read : false;
        }

        return false;
    }

    public function remove($name = '', $cache_folder, $DeleteMe = false)
    {
        if (empty($name)) {

            if (!is_dir($cache_folder)) {
                $cache_folder = $this->cacheDir . '/' . $cache_folder;
            }

            return $this->utilityFile->sureRemoveDir($cache_folder, $DeleteMe);
        } else {
            return @unlink($cache_folder . $name);
        }
    }

    public function exists($file, $use_subfolder = false)
    {
        $name = basename($file);
        $cache_folder = $this->calculatePath($name, dirname($file), $use_subfolder);
        return file_exists("$cache_folder/$name") ? "$cache_folder/$name" : false;
    }

    private function calculatePath($name, $cache_folder, $use_subfolder)
    {
        $cache_folder = "$cache_folder/";
        if ($use_subfolder) {
            $path = substr($name, 0, 4);
            $cache_folder .= chunk_split($path, 1, '/');
        }

        $cache_folder = rtrim($cache_folder, '/');

        riMkDir($cache_folder);

        return $cache_folder;
    }
}