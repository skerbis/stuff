# REDAXO Stuff Repository

Beispiel-Repository für REDAXO Module und Templates, kompatibel mit dem **Stuff AddOn**.

## Struktur

Dieses Repository folgt der empfohlenen Struktur für das Stuff AddOn:

```
/modules/           # REDAXO Module
  /modulname/
    config.yml      # Modul-Konfiguration
    input.php       # Input-Code  
    output.php      # Output-Code
    README.md       # Dokumentation (optional)
    styles.scss     # Styles (optional)
    /assets/        # Asset-Dateien (optional)

/templates/         # REDAXO Templates
  /templatename/
    config.yml      # Template-Konfiguration
    template.php    # Template-Code
    README.md       # Dokumentation (optional)
    /assets/        # Asset-Dateien (optional)
```

## Verfügbare Module

- **text-simple**: Einfaches Text-Modul mit Überschrift
- **image-text**: Bild-Text-Kombination

## Verfügbare Templates

- **basic-page**: Basis-Seitentemplate

## Verwendung mit Stuff AddOn

1. Stuff AddOn in REDAXO installieren
2. Repository hinzufügen: `dein-username/stuff`
3. Module und Templates durchsuchen und installieren

## Eigene Module hinzufügen

1. Repository forken oder eigenes Repository verwenden
2. Neue Module/Templates nach obiger Struktur hinzufügen
3. Über Stuff AddOn synchronisieren

## Lizenz

MIT License
