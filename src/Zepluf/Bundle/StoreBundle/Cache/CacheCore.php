<?php
/**
 * This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this software; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * � Copyright 2005 Richard Heyes
 */

/**
 * Caching Libraries for PHP5
 *
 * Handles data and output caching. Defaults to /dev/shm
 * (shared memory). All methods are static.
 *
 * Eg: (output caching)
 *
 * if (!OutputCache::Start('group', 'unique id', 600)) {
 *
 *   // ... Output
 *
 *   OutputCache::End();
 * }
 *
 * Eg: (data caching)
 *
 * if (!$data = DataCache::Get('group', 'unique id')) {
 *
 *   $data = time();
 *
 *   DataCache::Put('group', 'unique id', 10, $data);
 * }
 *
 * echo $data;
 */

namespace Zepluf\Bundle\StoreBundle\Cache;

class CoreCache
{
	/**
	 * gzip level
	 * @var bool
	 */
	protected static $gzip_level;
	 
	/**
	 * Whether caching is enabled
	 * @var bool
	 */
	public static $enabled = true;

	/**
	 * Place to store the cache files
	 * @var string
	 */
	protected static $store = '/dev/shm/';

	/**
	 * Prefix to use on cache files
	 * @var string
	 */
	protected static $prefix = 'cache_';

	/**
	 * Stores data
	 *
	 * @param string $group Group to store data under
	 * @param string $id    Unique ID of this data
	 * @param int    $ttl   How long to cache for (in seconds)
	 */
	protected static function write($group, $id, $ttl, $data)
	{
		$filename = self::getFilename($group, $id);

		if ($fp = @fopen($filename, 'xb')) {

			if (flock($fp, LOCK_EX)) {
				fwrite($fp, $data);
			}
			fclose($fp);

			// Set filemtime
			touch($filename, time() + $ttl);
		}
	}

	/**
	 * Reads data
	 *
	 * @param string $group Group to store data under
	 * @param string $id    Unique ID of this data
	 */
	protected static function read($group, $id)
	{
		$filename = self::getFilename($group, $id);

		return file_get_contents($filename);
	}

	/**
	 * Determines if an entry is cached
	 *
	 * @param string $group Group to store data under
	 * @param string $id    Unique ID of this data
	 */
	protected static function isCached($group, $id)
	{
		$filename = self::getFilename($group, $id);

		if (self::$enabled && file_exists($filename) && filemtime($filename) > time()) {
			return true;
		}

		@unlink($filename);

		return false;
	}

	/**
	 * Builds a filename/path from group, id and
	 * store.
	 *
	 * @param string $group Group to store data under
	 * @param string $id    Unique ID of this data
	 */
	protected static function getFilename($group, $id)
	{
		$id = md5($id);
		$suffix = (self::$gzip_level > 0) ? '_gz' : '';
		return self::$store . self::$prefix . "{$group}_{$id}{$suffix}";
	}

	/**
	 * Sets the filename prefix to use
	 *
	 * @param string $prefix Filename Prefix to use
	 */
	public static function setPrefix($prefix)
	{
		self::$prefix = $prefix;
	}

	/**
	 * Sets the store for cache files. Defaults to
	 * /dev/shm. Must have trailing slash.
	 *
	 * @param string $store The dir to store the cache data in
	 */
	public static function setStore($store)
	{
		self::$store = $store;
	}
}