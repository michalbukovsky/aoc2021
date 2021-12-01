<?php declare(strict_types=1);

namespace App\Utils;

abstract class Outputter
{
    private const RED = "\033[91m";
    private const GREEN = "\033[92m";
    private const YELLOW = "\033[93m";


    public static function errorFatal(string $message): void
    {
        self::error($message);
        die;
    }


    public static function error(string $message): void
    {
        self::echoMessage($message, self::RED);
    }


    public static function success(string $message): void
    {
        self::echoMessage($message, self::GREEN);
    }


    public static function notice(string $message, bool $newline = true): void
    {
        self::echoMessage($message, self::YELLOW, $newline);
    }


    public static function newline(): void
    {
        echo "\n";
    }


    private static function echoMessage(string $message, string $color, bool $newline = true): void
    {
        echo $color . $message . ($newline ? "\n" : '');
    }
}
