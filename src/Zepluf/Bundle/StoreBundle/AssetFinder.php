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

class AssetFinder
{
    protected $kernel;

    protected $template;

    protected $page_directory = '';

    protected $dirs;

    protected $baseDirs = array();

    protected $current_page = '';

    protected $request_type;

    protected $this_is_home_page;

    protected $cPath;

    /**
     * @var array
     */
    protected $supportedExternals = array('http://', 'https://', '//');

    /**
     * @var
     */
    protected $webDir;

    /**
     * @var
     */
    protected $appDir;

    /**
     * @var
     */
    protected $currentTemplate;

    protected $environment;

    protected $subEnvironment;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;

        $this->environment = $kernel->getContainer()->get('environment')->getEnvironment();
        $this->subEnvironment = $kernel->getContainer()->get('environment')->getSubEnvironment();

        $this->webDir = $kernel->getContainer()->getParameter('web.dir');
        $this->appDir = $kernel->getContainer()->getParameter('kernel.root_dir');

        $this->templatesDir = $kernel->getContainer()->getParameter('store.' . $this->subEnvironment . '.templates_dir');
        $this->currentTemplate = $kernel->getContainer()->get('environment')->getTemplate();
    }

    /**
     * finds an array of assets
     *
     * @param $files
     * @return array
     */
    public function findAssets($files)
    {
        if (!is_array($files)) {
            $files = array($files => null);
        }

        $list = array();
        foreach ($files as $file => $options) {
            $path = $this->findAsset($file, $options);
            if (!empty($path)) {
                $list[$path] = $options;
            }
        }
        return $list;
    }

    /**
     * looks for an asset (image, css, js)
     *
     * the asset should be in one of these forms:
     * 1. absolute path to the asset
     * 2. templates:templateName:path/to/asset -> will look in the template folder
     * 3. bundles:bundleName:path/to/asset
     * 4. plugins:pluginName:path/to/asset
     * 5. images:path/to/asset
     *
     * @param $file
     * @param array $options
     * @return string
     */
    public function findAsset($file, &$options = array())
    {
        $error = false;
        $path = '';

        // inline is a very special case
        if (!empty($options['inline'])) {
            $path = $file;
        } // is this an external file?
        elseif (!isset($options['external'])) {
            $options['external'] = false;
            foreach ($this->supportedExternals as $supportedExternal) {
                if (strpos($file, $supportedExternal) === 0) {
                    $path = $file;
                    $options['external'] = true;
                    break;
                }
            }
        } elseif ($options['external']) {
            $path = $file;
        }
        // absolute?
        if ((!isset($options['inline']) || !$options['inline']) && !$options['external'] && (!is_file($path = $file) || !is_readable($path))) {
            //  explode
            $fileParts = explode(":", $file);
            // supports for path with missing elements
            switch (count($fileParts)) {
                case 3:
                    // good
                    break;
                case 2:
                    // assumes bundle
                    if ("Bundle" == substr($fileParts[0], -6)) {
                        array_unshift($fileParts, "bundles");
                    } // assume plugin
                    else {
                        if ($fileParts[0] != "images") {
                            array_unshift($fileParts, "plugins");
                        }
                    }

                    break;
                case 1:
                    // assumes template
                    array_unshift($fileParts, "templates", "current");
            }

            /*
             * $fileParts[0]: type of asset
             * $fileParts[1]: bundle/plugin name or path to image
             * $fileParts[2]: path to file
             */

            switch ($fileParts[0]) {
                case "templates":
                    // look into the current template first
                    $template = "current" == $fileParts[1] ? $this->currentTemplate : $fileParts[1];
                    // in prod env we look in the web templates folders
                    if ($this->environment == "prod") {
                        if (!file_exists($path = sprintf($this->webDir . '/' . $this->subEnvironment . '/templates/%s/%s', $template, $fileParts[2]))) {
                            // look into the default template
                            if (!file_exists($path = sprintf($this->webDir . '/' . $this->subEnvironment . '/templates/template_default/%s', $fileParts[2]))) {
                                $error = true;
                            }
                        }
                    } // in dev env we look in the app templates folders
                    else {
                        if (!file_exists($path = sprintf($this->templatesDir . '/%s/%s', $template, $fileParts[2]))) {
                            // look into the default template
                            if (!file_exists($path = sprintf($this->templatesDir . '/template_default/%s', $fileParts[2]))) {
                                $error = true;
                            }
                        }
                    }
                    break;
                case "plugins":
                    // in prod env we look in the web plugins folders
                    if ($this->environment == "prod") {
                        // check to see if there is template override
                        if (!file_exists($path = sprintf($this->webDir . '/' . $this->subEnvironment . '/templates/' . $this->currentTemplate . "/plugins/%s/%s", $fileParts[1], $fileParts[2]))) {
                            if (!file_exists($path = sprintf($this->webDir . "/plugins/%s/%s", $fileParts[1], $fileParts[2]))) {
                                $error = true;
                            }
                        }
                    } // in dev env we look in the plugins folders
                    else {
                        if (!file_exists($path = sprintf($this->kernel->getContainer()->getParameter('plugins.root_dir') . "/%s/Resources/public/%s", $fileParts[1], $fileParts[2]))) {
                            $error = true;
                        }
                    }
                    break;
                case "bundles":
                    // in prod env we look in the web bundles folders
                    if ($this->environment == "prod") {
                        $fileParts[1] = strtolower(substr($fileParts[1], 0, strrpos($fileParts[1], 'Bundle')));
                        if (!file_exists($path = sprintf($this->webDir . '/' . $this->subEnvironment . '/templates/' . $this->currentTemplate . "/bundles/%s/%s", $fileParts[1], $fileParts[2]))) {
                            if (!file_exists($path = sprintf($this->webDir . "/bundles/%s/%s", $fileParts[1], $fileParts[2]))) {
                                $error = true;
                            }
                        }
                    } // in dev env we look in the bundles folders
                    else {
                        if (!file_exists($path = sprintf($this->kernel->getBundle($fileParts[1])->getPath() . "/Resources/public/%s", $fileParts[2]))) {
                            $error = true;
                        }
                    }
                    break;
                case "images":
                    if (!file_exists($path = sprintf($this->webDir . '/images/' . $fileParts[1]))) {
                        $error = true;
                    }
                    break;
                default:
                    break;
            }

        }

        if (!$error) {
            return $path;
        } else {
            return ''; // some kind of error logging here
        }
    }

    /**
     * @param array $files
     * @return array
     */
    public function get($files)
    {
        $list = $this->findAssets($files);
        $result = array();
        foreach ($list as $file => $options) {
            $result[] = array(
                'path' => $this->kernel->getContainer()->get("utility.file")->getRelativePath($this->webDir, $file),
                'options' => $options
            );
        }

        return $result;
    }

    public function setSupportedExternals($supportedExternals)
    {
        $this->supportedExternals = $supportedExternals;
    }

    public function setDirs($dirs)
    {
        $this->dirs = $dirs;
    }

    /**
     * @param $haystack
     * @param $needles
     * @return bool|int
     */
    private function strposArray($haystack, $needles)
    {
        $pos = false;
        if (is_array($needles)) {
            foreach ($needles as $str) {
                if (is_array($str)) {
                    $pos = $this->strposArray($haystack, $str);
                } else {
                    $pos = strpos($haystack, $str);
                }
                if ($pos !== FALSE) {
                    break;
                }
            }
        } else {
            $pos = strpos($haystack, $needles);
        }
        return $pos;
    }
}
