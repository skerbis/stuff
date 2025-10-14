<?php

/**
 * Example Helper Class
 * 
 * @title Example Helper
 * @description Eine Beispiel-Klasse zur Demonstration des GitHub Installers
 * @version 1.0.0
 * @author GitHub Installer Demo
 */
class ExampleHelper
{
    /**
     * Beispiel-Methode
     */
    public static function sayHello(string $name = 'World'): string
    {
        return "Hello, {$name}!";
    }
    
    /**
     * Aktuelle Zeit formatiert zurückgeben
     */
    public static function getCurrentTime(string $format = 'Y-m-d H:i:s'): string
    {
        return date($format);
    }
    
    /**
     * Array mit Beispiel-Daten
     */
    public static function getSampleData(): array
    {
        return [
            'installed_via' => 'GitHub Installer',
            'created_at' => self::getCurrentTime(),
            'greeting' => self::sayHello('REDAXO')
        ];
    }
}