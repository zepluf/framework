<?php

namespace Zepluf\Bundle\StoreBundle\Controller;

use Zepluf\Bundle\StoreBundle\Entity\Setting;
use Zepluf\Bundle\StoreBundle\Form\ModifySettingsForm;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2013 Christian Raue
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class SettingsController extends Controller
{

    public function modifyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(get_class(new Setting()));
        $allStoredSettings = $repo->findAll();

        $formData = array(
            'settings' => $allStoredSettings,
        );

        $form = $this->createForm(new ModifySettingsForm(), $formData);
        $request = $this->get('request');
        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                foreach ($formData['settings'] as $formSetting) {
                    $storedSetting = $this->getSettingByName($allStoredSettings, $formSetting->getName());
                    if ($storedSetting !== null) {
                        $storedSetting->setValue($formSetting->getValue());
                        $em->persist($storedSetting);
                    }
                }

                $em->flush();

                $this->get('session')->getFlashBag()->set('notice',
                    $this->get('translator')->trans('settings_changed', array(), 'StoreBundle'));
                return $this->redirect($this->generateUrl($this->container->getParameter('store_config.redirectRouteAfterModify')));
            }
        }

        return $this->render('StoreBundle:Settings:modify.html.twig', array(
            'form' => $form->createView(),
            'sections' => $this->getSections($allStoredSettings),
        ));
    }

    public function sectionModifyAction($section)
    {
        var_dump($this->get('store_config')->get('access_license_number'));
        die();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(get_class(new Setting()));
        $query = $repo->createQueryBuilder('p')
            ->where('p.section = :section')
            ->setParameter('section', $section)
            ->getQuery();

        $allStoredSettings = $query->getResult();

        $formData = array(
            'settings' => $allStoredSettings,
        );

        $form = $this->createForm(new ModifySettingsForm(), $formData);
        $request = $this->get('request');
        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                foreach ($formData['settings'] as $formSetting) {
                    $storedSetting = $this->getSettingByName($allStoredSettings, $formSetting->getName());
                    if ($storedSetting !== null) {
                        $storedSetting->setValue($formSetting->getValue());
                        $em->persist($storedSetting);
                    }
                }

                $em->flush();

                $this->get('session')->getFlashBag()->set('notice',
                    $this->get('translator')->trans('settings_changed', array(), 'StoreBundle'));
                return $this->redirect($this->generateUrl($this->container->getParameter('store_config.redirectRouteAfterModify')));
            }
        }

        return $this->render('StoreBundle:Settings:modify.html.twig', array(
            'form' => $form->createView(),
            'sections' => $this->getSections($allStoredSettings),
        ));
    }

    /**
     * @param Setting[] $settings
     * @return string[] (may also contain a null value)
     */
    protected function getSections(array $settings)
    {
        $sections = array();

        foreach ($settings as $setting) {
            $section = $setting->getSection();
            if (!in_array($section, $sections)) {
                $sections[] = $section;
            }
        }

        sort($sections);

        return $sections;
    }

    /**
     * @param Setting[] $settings
     * @param string $name
     * @return Setting|null
     */
    protected function getSettingByName(array $settings, $name)
    {
        foreach ($settings as $setting) {
            if ($setting->getName() === $name) {
                return $setting;
            }
        }

        return null;
    }

}
