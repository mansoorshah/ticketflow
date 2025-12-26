<?php

class BadgeHelper
{
    public static function priority(string $priority): string
    {
        $priority = strtolower($priority);

        $labels = [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High'
        ];

        return sprintf(
            '<span class="badge badge-priority-%s">%s</span>',
            htmlspecialchars($priority),
            $labels[$priority] ?? ucfirst($priority)
        );
    }

    public static function status(string $status): string
    {
        $statusKey = str_replace('_', '-', strtolower($status));

        $labels = [
            'open' => 'Open',
            'in-progress' => 'In Progress',
            'done' => 'Done',
            'closed' => 'Closed'
        ];

        return sprintf(
            '<span class="badge badge-status-%s">%s</span>',
            htmlspecialchars($statusKey),
            $labels[$statusKey] ?? ucfirst($status)
        );
    }
}
