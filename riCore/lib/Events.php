<?php
/**
 * Events Class
 */
namespace plugins\riCore;
 
final class Events
{
    /**
     * this event is triggered at the start of a page
     */
    const onPageStart = 'core.page.start';

    /**
     * this event is triggered at the end of a page
     */
    const onPageEnd = 'core.page.end';
}