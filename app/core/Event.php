<?php

class Event
{
    protected static array $listeners = [];

    public static function listen(string $event, callable $handler)
    {
        self::$listeners[$event][] = $handler;
    }

    public static function dispatch(string $event, array $payload = [])
    {
        if (!empty(self::$listeners[$event])) {
            foreach (self::$listeners[$event] as $handler) {
                call_user_func($handler, $payload);
            }
        }
    }
}
