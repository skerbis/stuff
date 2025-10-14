# Example Helper

Eine Beispiel-Klasse zur Demonstration des GitHub Installer Systems.

## Funktionen

- `sayHello($name)` - Gibt eine Begrüßung zurück
- `getCurrentTime($format)` - Gibt die aktuelle Zeit formatiert zurück  
- `getSampleData()` - Gibt Beispiel-Daten als Array zurück

## Verwendung

```php
// Beispiel-Nutzung in REDAXO
echo ExampleHelper::sayHello('REDAXO Developer');
echo ExampleHelper::getCurrentTime();
$data = ExampleHelper::getSampleData();
```

## Installation

Diese Klasse wurde über den GitHub Installer installiert und wird in das Verzeichnis `project/lib/gitClasses/ExampleHelper/` gespeichert.

## Updates

Updates erfolgen automatisch über den GitHub Installer - lokale Änderungen werden dabei überschrieben.