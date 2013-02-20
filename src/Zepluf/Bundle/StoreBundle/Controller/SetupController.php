<?php
/**
 * Created by RubikIntegration Team.
 * Date: 2/1/13
 * Time: 9:09 PM
 * Question? Come to our website at http://rubikintegration.com
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zepluf\Bundle\StoreBundle\Controller;

class SetupController extends Controller
{
    public function setupAction()
    {
        $sysSettings = $this->container->getParameter('sys');
        // initialize

        // save sys settings
        $this->get('plugin')->saveSysSettings($this->get('utility.file'), $this->get('utility.collection'), array('initialized' => true));

        foreach ($sysSettings['core'] as $plugin) {
            $this->get('plugin')->uninstall($this->container, $plugin);
            $this->get('plugin')->install($this->container, $plugin);
            $this->get('plugin')->activate($this->container, $plugin);
        }

        // setup missing page check to off
        $configValue = $this->get('doctrine')->getManager()->getRepository('StoreBundle:ConfigValue')->findOneByKey('MISSING_PAGE_CHECK');
        $configValue->setValue('Off');
        $this->get('doctrine')->getManager()->persist($configValue);
        $this->get('doctrine')->getManager()->flush();

        // register menu link
        $id = md5('ri.php/plugins/manager/');
        zen_deregister_admin_pages($id);
        zen_register_admin_page($id, 'ZEPLUF_NAME_' . $id, 'ZEPLUF_URL_' . $id, '', 'extras', 'Y', 1);

        $this->get('templating.helper.holders')->add('main', $this->renderView('bundles:StoreBundle:setup.html.php'));

        return $this->render('bundles:StoreBundle:backend/layout.html.php');
    }
}
