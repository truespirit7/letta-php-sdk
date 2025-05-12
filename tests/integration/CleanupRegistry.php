<?php
// Helper class for tracking and cleaning up test-created objects

namespace Tests\Integration;

class CleanupRegistry
{
    private static $resources = [
        'tools' => [],
        'identities' => [],
        'blocks' => [],
        // Add more resource types as needed
    ];

    public static function register($type, $id)
    {
        if (!isset(self::$resources[$type])) {
            self::$resources[$type] = [];
        }
        self::$resources[$type][] = $id;
    }

    public static function get($type)
    {
        return self::$resources[$type] ?? [];
    }

    public static function clear($type)
    {
        self::$resources[$type] = [];
    }

    public static function all()
    {
        return self::$resources;
    }

    public static function reset()
    {
        foreach (self::$resources as $type => $ids) {
            self::$resources[$type] = [];
        }
    }
} 