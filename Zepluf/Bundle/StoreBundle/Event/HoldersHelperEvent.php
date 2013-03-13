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

namespace Zepluf\Bundle\StoreBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * holder event class
 */
class HoldersHelperEvent extends Event
{
    /**
     * holder
     *
     * @var holder
     */
    private $holder;

    /**
     * @param $holder
     */
    public function __construct($holder){
        $this->setHolder($holder);
    }

    /**
     * sets holder name
     *
     * @param $holder
     * @return HoldersHelperEvent
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