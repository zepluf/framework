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

namespace Zepluf\Bundle\StoreBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Zepluf\Bundle\StoreBundle\ParameterBag;

/**
 * core holder class
 */
class SettingsHelper extends Helper
{

    /**
     * settings
     *
     * @var
     */
    protected $settings;

    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    /**
     * returns the name of this helper
     * @return string
     */
    public function getName()
    {
        return 'settings';
    }

    public function get($key = null, $default = ParameterBag::DEFAULT_KEY)
    {
        return $this->settings->get($key, $default);
    }

    public function has($key)
    {
        return $this->settings->has($key);
    }
}