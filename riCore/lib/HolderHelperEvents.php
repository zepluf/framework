<?php 

namespace plugins\riCore;

final class HolderHelperEvents
{
    /**
     * this event is triggered when a holder starts
     */
    const onHolderStart = 'view.helper.holder.get.start';

    /**
     * this event is triggered when a holder ends
     */
    const onHolderEnd = 'view.helper.holder.get.end';
}