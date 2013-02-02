<?php

namespace Zepluf\Bundle\StoreBundle\Cache;

/**
 * Output CoreCache extension of base caching class
 */
class OutputCache extends CoreCache
{
	/**
	 * Group of currently being recorded data
	 * @var string
	 */
	private static $group;

	/**
	 * ID of currently being recorded data
	 * @var string
	 */
	private static $id;

	/**
	 * Ttl of currently being recorded data
	 * @var int
	 */
	private static $ttl;

	/**
	 * Starts caching off. Returns true if cached, and dumps
	 * the output. False if not cached and start output buffering.
	 *
	 * @param  string $group Group to store data under
	 * @param  string $id    Unique ID of this data
	 * @param  int    $ttl   How long to cache for (in seconds)
	 * @return bool          True if cached, false if not
	 */
	public static function Start($group, $id, $ttl)
	{
		if (self::isCached($group, $id)) {
			$data = self::read($group, $id);
			if(self::$gzip_level > 0)
			$data = gzcompress($data);
			echo $data;
			return true;

		} else {
			ob_start();

			self::$group = $group;
			self::$id    = $id;
			self::$ttl   = $ttl;

			return false;
		}
	}

	/**
	 * Ends caching. Writes data to disk.
	 */
	public static function End()
	{
		$data = ob_get_contents();
		ob_end_flush();
		if (self::$gzip_level > 0) {
			$size = strlen($data);
			$crc = crc32($data);

			$data = gzcompress($data, self::$gzip_level);
			//		      $data = substr($data, 0, strlen($data) - 4);
			//		      $data .= pack('V',$crc);
			//           	  $data .= pack('V',$size);
		}

		self::write(self::$group, self::$id, self::$ttl, $data);
	}

	/**
	 * gzuncompress() may not decompress some compressed strings and return a Data Error.
		* The problem could be that the outside compressed string has a CRC32 checksum at the end of the file instead of Adler-32
		*/
	protected function gzuncompress_crc32($data) {
		$f = tempnam('/tmp', 'gz_fix');
		file_put_contents($f, "\x1f\x8b\x08\x00\x00\x00\x00\x00" . $data);
		return file_get_contents('compress.zlib://' . $f);
	}
}

