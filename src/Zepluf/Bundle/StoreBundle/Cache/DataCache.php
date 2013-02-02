<?php

namespace Zepluf\Bundle\StoreBundle\Cache;

/**
 * Data cache extension of base caching class
 */
class DataCache extends CoreCache
{

	/**
	 * Retrieves data from the cache
	 *
	 * @param  string $group Group this data belongs to
	 * @param  string $id    Unique ID of the data
	 * @return mixed         Either the resulting data, or null
	 */
	public static function Get($group, $id)
	{
		if (self::isCached($group, $id)) {
			return unserialize(self::read($group, $id));
		}

		return null;
	}

	/**
	 * Stores data in the cache
	 *
	 * @param string $group Group this data belongs to
	 * @param string $id    Unique ID of the data
	 * @param int    $ttl   How long to cache for (in seconds)
	 * @param mixed  $data  The data to store
	 */
	public static function Put($group, $id, $ttl, $data)
	{
		self::write($group, $id, $ttl, serialize($data));
	}
}