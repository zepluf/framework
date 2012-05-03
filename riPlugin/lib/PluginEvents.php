<?php 

namespace plugins\riPlugin;

final class PluginEvents
{
    /**
     * The plugin.load.end event is thrown each time a plugin is loaded (1st time)
     * in the system.
     *
     * The event listener receives an plugins\riPlugin\PluginEvent
     * instance.
     *
     * @var string
     */
    const onLoadEnd = 'plugin.load.end';
}