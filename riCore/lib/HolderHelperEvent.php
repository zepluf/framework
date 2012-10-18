<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 9/30/12
 * Time: 4:31 PM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF
 */

namespace plugins\riCore;

/**
 * holder event class
 */
class HolderHelperEvent extends Event
{
    /**
     * holder
     *
     * @var holder
     */
    private $holder;

    /**
     * sets holder name
     *
     * @param $holder
     * @return HolderHelperEvent
     */
    public function setHolder($holder){
        $this->holder = $holder;
        return $this;
    }

    /**
     * gets holder name
     *
     * @return mixed
     */
    public function getHolder(){
        return $this->holder;
    }
}