<?php
/**
 * Created by RubikIntegration Team.
 * Date: 2/2/13
 * Time: 12:49 AM
 * Question? Come to our website at http://rubikintegration.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Utility;

class Collection
{
    /**
     * If one of the Arguments isn't an Array, first Argument is returned.
     * If an Element is an Array in both Arrays, Arrays are merged recursively,
     * otherwise the element in $ins will overwrite the element in $arr (only if key is not numeric).
     * This also applys to Arrays in $arr, if the Element is scalar in $ins (in difference to the previous approach).
     *
     * @param array $arr
     * @param array $ins
     * @return array
     */
    function arrayMergeWithReplace($arr, $ins)
    {
        # Loop through all Elements in $ins:
        if (is_array($arr) && is_array($ins))
            foreach ($ins as $k => $v) {
                # Key exists in $arr and both Elemente are Arrays: Merge recursively.
                if (is_integer($k)) {
                    if (!in_array($v, $arr))
                        $arr[] = $v;
                }
                else if (isset($arr[$k]) && is_array($v) && is_array($arr[$k]))
                    $arr[$k] = arrayMergeWithReplace($arr[$k], $v);
                # Place more Conditions here (see below)
                # ...
                # Otherwise replace Element in $arr with Element in $ins:
                else {
                    $arr[$k] = $v;
                }
            }
        # Return merged Arrays:
        return ($arr);
    }
}
