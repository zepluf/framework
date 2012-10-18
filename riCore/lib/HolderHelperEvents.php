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
 * class contains helper events constants
 */
final class HolderHelperEvents
{
    /**
     * this event is triggered when a holder starts
     */
    const onHolderStart = 'view.helper.holder.get.start';

    /**
     * this event is triggered when a holder ends
     */
    const onHolderEnd = 'view.helper.holder.get.end';
}