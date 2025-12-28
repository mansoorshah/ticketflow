<?php

class EmailLogger
{
    public static function log(string $message, array $context = [])
    {
        $time = date('Y-m-d H:i:s');

        $entry = "[{$time}] {$message}";

        if (!empty($context)) {
            $entry .= ' | ' . json_encode($context);
        }

        $entry .= PHP_EOL;

        file_put_contents(
            __DIR__ . '/../logs/email.log',
            $entry,
            FILE_APPEND
        );
    }
}
