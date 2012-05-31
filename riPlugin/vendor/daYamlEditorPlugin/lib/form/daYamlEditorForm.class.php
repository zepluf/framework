<?php
/**
 * daYamlEditorForm has no default fields,
 * they are created by daYamlEditor::buildForm.
 *
 * @package    daYamlEditorPlugin
 * @author     dalexandre
 */
class daYamlEditorForm extends sfFormSymfony
{
  /**
   * You can set a specific config block to use (usefull if you want multiple forms)
   * If null, all the daYamlEditor.yml declared blocks will be use
   * @var string
   */
  protected $daYamlEditorName = null;

  /**
   * Call daYamlEditor::buildForm and do some settings.
   * Don't forgot to call parent::configure() if you extend this method.
   */
  public function configure()
  {
    if (self::$dispatcher)
    {
      $this->daYamlEditor = new daYamlEditor(self::$dispatcher, $this->daYamlEditorName);
      $this->daYamlEditor->buildForm($this);
    }

    $this->widgetSchema->setNameFormat('dayamleditor[%s]');

    // This formatter make your form looking like a Doctrine one
    $this->widgetSchema->setFormFormatterName('daYamlEditor');
  }

  /**
   * Save the form
   * update the Yaml Files and dispatch daYamlEditor.save event
   */
  public function save()
  {
    $form_values = $this->getValues();

    foreach ($this->daYamlEditor->getConfig() as $block)
    {
      $file_array = (array)sfYaml::load($block['file']);

      foreach ($block['fields'] as $name => $field)
      {
        if (isset($form_values[$name]))
        {
          $to_edit = &$file_array;
          foreach(explode('/', $field['path']) as $key)
          {
            $to_edit = &$to_edit[$key];
          }
          $to_edit = $form_values[$name];
        }
      }

      if (!file_put_contents($block['file'], sfYaml::dump($file_array)))
      {
        throw new Exception("Can't save, check file permissions");
      }

      self::$dispatcher->notify(new sfEvent($this, 'application.log', array($block['file']." saved")));
      self::$dispatcher->notify(new sfEvent($this, 'daYamlEditor.save', array($this->daYamlEditor->getName())));
    }

    return true;
  }
}