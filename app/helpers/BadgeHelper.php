<?php

class BadgeHelper
{
    public static function priority(string $priority): string
    {
        $key = strtolower($priority);

        $labels = [
            'low'      => 'Low',
            'medium'   => 'Medium',
            'high'     => 'High',
            'critical' => 'Critical'
        ];

        return sprintf(
            '<span class="badge badge-priority-%s">%s</span>',
            htmlspecialchars($key),
            $labels[$key] ?? ucfirst($priority)
        );
    }

    public static function status(string $status): string
    {
        $key = str_replace('_', '-', strtolower($status));

        $labels = [
            'open'        => 'Open',
            'in-progress' => 'In Progress',
            'done'        => 'Done',
            'closed'      => 'Closed'
        ];

        return sprintf(
            '<span class="badge badge-status-%s">%s</span>',
            htmlspecialchars($key),
            $labels[$key] ?? ucfirst(str_replace('_', ' ', $status))
        );
    }
}

