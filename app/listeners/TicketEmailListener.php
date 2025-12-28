<?php

class TicketEmailListener
{
    protected static function send($user, $subject, $template, $data)
    {
        if (!$user || empty($user['email'])) {
            return;
        }

        Mailer::send(
            $user['email'],
            $subject,
            $template,
            $data
        );
    }

    public static function onAssigned($payload)
    {
        EmailLogger::log('Event: ticket.assigned', [
            'ticket_id' => $payload['ticket']['id'],
            'to' => $payload['assignee']['email'] ?? null
        ]);

        self::send(
            $payload['assignee'],
            "New Ticket Assigned: #{$payload['ticket']['id']}",
            'ticket_assigned',
            $payload
        );
    }

    public static function onUnassigned($payload)
    {
        self::send(
            $payload['oldAssignee'],
            "Ticket Unassigned: #{$payload['ticket']['id']}",
            'ticket_unassigned',
            $payload
        );
    }

    public static function onCommented($payload)
    {
        self::send(
            $payload['assignee'],
            "New Comment on Ticket #{$payload['ticket']['id']}",
            'ticket_commented',
            $payload
        );
    }

    public static function onStatusChanged($payload)
    {
        self::send(
            $payload['assignee'],
            "Ticket Status Updated: #{$payload['ticket']['id']}",
            'ticket_status_changed',
            $payload
        );
    }

    public static function onPriorityChanged($payload)
    {
        self::send(
            $payload['assignee'],
            "Ticket Priority Updated: #{$payload['ticket']['id']}",
            'ticket_priority_changed',
            $payload
        );
    }


}
