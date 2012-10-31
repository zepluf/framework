<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Zepluf\Bundle\RiStoreBundle\RiStoreBundle(),
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
//            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
//            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
//            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
//            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),

//            new JMS\AopBundle\JMSAopBundle(),
//            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
//            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
//            $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
//            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
//            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
//            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.xml');
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
