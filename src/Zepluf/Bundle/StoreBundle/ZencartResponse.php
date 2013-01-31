<?php
/**
 * Created by RubikIntegration Team.
 * Date: 12/28/12
 * Time: 2:28 PM
 * Question? Come to our website at http://rubikintegration.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle;

use Symfony\Component\HttpFoundation\Response;

class ZencartResponse extends Response
{
    const CONTENT_NOT_FOUND = "pageNotFound";
    const CONTENT_STATIC_PAGE = "zencartStaticPage";
}
