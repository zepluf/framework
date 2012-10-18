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
* Events Class
*/
final class Events
{
    /**
     * this event is triggered at the start of a page
     */
    const onPageStart = 'core.page.start';

    /**
     * this event is triggered at the end of a page
     */
    const onPageEnd = 'core.page.end';
}