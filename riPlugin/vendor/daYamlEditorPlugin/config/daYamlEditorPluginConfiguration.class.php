<?php

/**
 * daYamlEditorPlugin configuration.
 * 
 * @package     daYamlEditorPlugin
 * @subpackage  config
 * @author      dalexandre
 */
class daYamlEditorPluginConfiguration extends sfPluginConfiguration
{
  const VERSION = '1.0.0';

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    if ($this->configuration instanceof sfApplicationConfiguration)
    {
      $this->configuration->getConfigCache()->registerConfigHandler('config/daYamlEditor.yml', 'daYamlEditorConfigHandler');
    }
  }
}
