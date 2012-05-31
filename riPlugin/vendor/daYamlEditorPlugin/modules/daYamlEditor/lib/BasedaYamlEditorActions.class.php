<?php

/**
 * Base actions for the daYamlEditorPlugin daYamlEditor module
 * 
 * @package     daYamlEditorPlugin
 * @author      dalexandre
 */
abstract class BasedaYamlEditorActions extends sfActions
{
  /**
   * Index action, override to use your own daYamlEditor forms
   * @param sfWebRequest $request
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new daYamlEditorForm();
    $this->processForm($request);
  }

  /**
   * Process and save the form
   * @param sfWebRequest $request
   */
  public function processForm(sfWebRequest $request)
  {
    if ($request->isMethod('post'))
    {
      $this->form->bind(
        $request->getParameter($this->form->getName())
      );
      if ($this->form->isValid())
      {
        if ($this->form->save())
        {
          $this->getUser()->setFlash('notice', "Configuration edited succesfully", true);
          $requestParameters = $request->getRequestParameters();
          $this->redirect($requestParameters['module'].'/'.$requestParameters['action']);
        }
      }
    }
  }
}
