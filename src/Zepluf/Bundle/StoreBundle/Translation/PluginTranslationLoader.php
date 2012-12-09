<?php
/**
 * Created by RubikIntegration Team.
 *
 * Date: 11/25/12
 * Time: 12:23 AM
 * Question? Come to our website at http://rubikin.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code or refer to the LICENSE
 * file of ZePLUF framework
 */

namespace Zepluf\Bundle\StoreBundle\Translation;

use Symfony\Component\Translation\Loader\LoaderInterface;

class PluginTranslationLoader implements LoaderInterface
{
    public function load($resource, $locale, $domain = 'messages'){
        var_dump($resource, $locale, $domain);die('here');
    }
}
