<?php
/**
 * daYamlEditorBase provide all the logical form building
 *
 * @see daYamlEditorPlugin
 * @author dalexandre
 */
abstract class daYamlEditorBase
{
    protected
    $dispatcher  = null;
    protected
    $name        = null;
    protected
    $_config     = array();
    protected
    $type_widget = array (
      'string'  => 'sfWidgetFormInputText',
      'boolean' => 'sfWidgetFormInputCheckbox',
      'number'  => 'sfWidgetFormInputText',
      'integer' => 'sfWidgetFormInputText',
      'email'   => 'sfWidgetFormInputText',
    );
    protected
    $default_widget_options = array (
      'string'  => array(),
      'number'  => array(),
      'integer' => array(),
      'boolean' => array('value_attribute_value' => 1),
      'email'   => array(),
    );
    protected
    $type_validator = array (
      'string'  => 'sfValidatorString',
      'boolean' => 'sfValidatorBoolean',
      'number'  => 'sfValidatorNumber',
      'integer' => 'sfValidatorInteger',
      'email'   => 'sfValidatorEmail',
    );

    /**
     * @param sfEventDispatcher $dispatcher
     * @param string $name
     */
    public function __construct(sfEventDispatcher $dispatcher, $name = null)
    {
        $this->dispatcher  = $dispatcher;
        $this->name        = $name;
    }

    /**
     * Return the name of the config block in use
     * If null, all the block are used
     * @return null | string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add all the widgets and validators to the form
     * Read the yaml files to get the default values
     * @param sfForm $form
     * @throw Exception
     */
    public function buildForm(sfForm $form)
    {
        $this->dispatcher->notify(new sfEvent($this, 'application.log', array("Build the form object with fields")));

        foreach ($this->getConfig() as $block)
        {
            if (!is_writable($block['file'])) throw new Exception("The config file '".$block['file']."' is not writable !");
            $file_array = (array)sfYaml::load($block['file']);

            foreach ($block['fields'] as $name => $field)
            {
                $form->setWidget($name, $this->createWidgetByType($field['type'], $this->buildWidgetOptions($field, $file_array)));
                $form->setValidator($name, $this->createValidatorByType($field['type'], $this->buildValidatorOptions($field), $this->buildValidatorMessages($field)));

                if (isset($field['help'])) $form->getWidgetSchema()->setHelp($name, $field['help']);
            }
        }
    }

    /**
     * Load the daYamlEditor configuration from the cache
     * If self::$name is set, we try to load only the specified block (allow unique file editing)
     * @return array
     */
    public function getConfig()
    {
        if (empty($this->_config))
        {
            $config = include sfApplicationConfiguration::getActive()->getConfigCache()->checkConfig('config/daYamlEditor.yml');

            if (!is_null($this->name) && isset($config[$this->name]))
            {
                $this->_config[0] = $config[$this->name];
            }
            else
            {
                $this->_config = $config;
            }
        }
        return $this->_config;
    }

    /**
     * Create a new widget instance from the type defined in daYamlEditor.yml
     * @param string $type
     * @param array  $options
     * @param array  $attributes
     * @return sfWidget
     */
    protected function createWidgetByType($type, $options = array(), $attributes = array())
    {
        if (!isset($this->type_widget[$type])) throw new Exception("Unrecognized widget type '".$type."' in daYamlEditor");

        $class = $this->type_widget[$type];
        return new $class($options, $attributes);
    }
    /**
     * Create a new validator instance from the type defined in daYamlEditor.yml
     * @param string $type
     * @param array  $options
     * @param array  $messages
     * @return sfValidatorBase
     */
    protected function createValidatorByType($type, $options = array(), $messages = array())
    {
        if (!isset($this->type_validator[$type])) throw new Exception("Unrecognized validator type '".$type."' in daYamlEditor");

        $class = $this->type_validator[$type];
        return new $class($options, $messages);
    }

    /**
     * Build the options for a sfWidget
     * @param array $field   The field config
     * @param array $default The yaml file as an array
     * @return array         The "options" array for sfWidget
     */
    protected function buildWidgetOptions(array $field, array $default)
    {
        // Search the default value
        foreach(explode('/', $field['path']) as $key)
        {
            if (isset($default[$key]))
            {
                $default = $default[$key];
            }
            else
            {
                $default = null;
                break;
            }
        }
        if (is_array($default)) throw new Exception("Array data are not supported yet");

        return array_merge($this->default_widget_options[$field['type']], array('default' => $default, 'label' => $field['label']));
    }

    /**
     * Build the options for a sfValidator
     * @param array $field   The field config
     * @return array         The "options" array for sfValidator
     */
    protected function buildValidatorOptions(array $field)
    {
        $options = array();
        if (isset($field['validate']))
        {
            $options = $field['validate'];
        }
        return $options;
    }
    /**
     * Build the messages array for a sfValidator
     * @param array $field   The field config
     * @return array         The "messages" array for sfValidator
     */
    protected function buildValidatorMessages(array $field)
    {
        $messages = array();
        if (isset($field['message']))
        {
            $messages = $field['message'];
    }
    return $messages;
  }
}
