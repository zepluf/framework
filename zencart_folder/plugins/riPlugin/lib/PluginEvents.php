<?php 

namespace plugins\riPlugin;

final class PluginEvents
{
    /**
     * The store.order event is thrown each time an order is created
     * in the system.
     *
     * The event listener receives an Acme\StoreBundle\Event\FilterOrderEvent
     * instance.
     *
     * @var string
     */
    const onStoreOrder = 'store.order';
}