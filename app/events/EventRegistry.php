<?php

class EventRegistry
{
    public static function register()
    {
        Event::listen('ticket.assigned', [TicketEmailListener::class, 'onAssigned']);
        Event::listen('ticket.unassigned', [TicketEmailListener::class, 'onUnassigned']);
        Event::listen('ticket.commented', [TicketEmailListener::class, 'onCommented']);
        Event::listen('ticket.status_changed', [TicketEmailListener::class, 'onStatusChanged']);
        Event::listen('ticket.priority_changed', [TicketEmailListener::class, 'onPriorityChanged']);
    }
}
