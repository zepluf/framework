<?php
/**
 * Created by Rubikin Team.
 * Date: 3/15/13
 * Time: 12:33 AM
 * Question? Come to our website at http://rubikin.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Component\Price;

class Price
{
    protected $components = array();

    protected $total = 0;

    public function addComponent($code, $tag, $name, $value)
    {
        $this->components[] = array(
            'name' => $name,
            'code' => $code,
            'tag' => $tag,
            'value' => $value);
        $this->total += $value;
    }

    public function getComponent($code)
    {
        return $this->components[$code];
    }

    public function getTotal()
    {
        return $this->total;
    }
}
