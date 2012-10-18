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

namespace plugins\riPlugin;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Dependency injection container.
 *
 * <p>Based on the <em>symfony2</em> dependency injection component.</p>
 *
 * @author DerManoMann <mano@zenmagick.org>
 */
class Container extends ContainerBuilder {

    /**
     * {@inheritDoc}
     *
     * @param $id
     * @param $invalidBehavior
     * @return null
     * @throws \InvalidArgumentException
     */
    public function get($id, $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE) {
        $service = null;
        if ($this->has($id)) {
            $service = parent::get($id, $invalidBehavior);
        }
        //else if (ClassLoader::classExists($id) && class_exists($id)) {
            // try to default to the id as class name (with scope prototype)
          //  $service = new $id();
        //}

        if (null != $service && $service instanceof ContainerAwareInterface) {
            $service->setContainer($this);
        }

        if (null == $service && self::EXCEPTION_ON_INVALID_REFERENCE === $invalidBehavior) {
            throw new \InvalidArgumentException(sprintf('The service "%s" does not exist.', $id));
        }

        return $service;
    }
}
