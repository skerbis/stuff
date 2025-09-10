# Artikel oder Slice einbinden

Ein modernes REDAXO-Modul zum flexiblen Einbinden von Artikelinhalten oder einzelnen Slices/Blöcken in andere Artikel.

## 📝 Beschreibung

Manchmal benötigt man eine Information, die bereits in einem Artikel eingepflegt ist. Natürlich kann man diese kopieren oder doppelt pflegen, was jedoch dazu führen kann, dass diese Informationen nicht immer auf dem aktuellen Stand sind. Eine Lösung hierfür ist die Einbindung zentral gepflegter Artikel oder Tabellendaten. Eine andere ist die Einbindung eines Slices.

Mit diesem Modul bindet man einen ausgewählten Slice eines anderen Artikels ein oder bei Bedarf einen ganzen Artikel. Das Modul basiert auf das Slice-HiJacker-Modul von Mirco Brandes/Gerald Rusche für REDAXO 4.x und wurde für REDAXO 5.15+ modernisiert.

## ✨ Features

- **Komplette Artikel einbinden**: Bindet alle Inhalte eines anderen Artikels ein
- **Einzelne Slices einbinden**: Wählen Sie gezielt einzelne Blöcke/Slices aus
- **Live-Vorschau**: Sehen Sie eine Vorschau der verfügbaren Slices im Backend
- **Endlosschleifen-Schutz**: Verhindert das Einbinden des aktuellen Artikels
- **Umfassende Validierung**: Prüfung auf existierende Artikel und Slices
- **Backend-Hinweise**: Hilfreiche Informationen für Redakteure
- **Online-Status berücksichtigt**: Offline-Artikel werden im Frontend nicht angezeigt

## 📋 Anforderungen

- REDAXO 5.15+
- PHP 7.4+

## 🚨 Wichtig: Erforderliche Action

**Es muss zusätzlich eine Presave-Action angelegt werden!**

### Action anlegen:
1. Im REDAXO Backend zu **Module** → **Aktionen** gehen
2. Neue Action anlegen mit folgenden Einstellungen:

**Name:** `Artikel/Slice Validierung`  
**Event:** `PRESAVE`  
**Code:**

```php
// Prüfung ob ein Slice/Block ausgewählt wurde
if ($this->getValue(2) == '0') {
    // Der Block wird nicht gespeichert
    $this->save = false;
    // Meldung ausgeben
    $this->messages[] = 'Bitte noch einen Slice/Block auswählen';
}
```

3. Diese Action dem Modul **"Artikel oder Slice einbinden"** zuweisen

## 🔧 Installation

### Über GitHub Installer (empfohlen)
1. GitHub Installer Addon installieren
2. Nach "Artikel oder Slice einbinden" suchen
3. Modul installieren

### Manuell
1. Neues Modul anlegen
2. Code aus `input.php` in das Eingabe-Feld kopieren  
3. Code aus `output.php` in das Ausgabe-Feld kopieren
4. Modul speichern

## 💡 Verwendung

### 1. Artikel auswählen
- Verwenden Sie das Link-Widget um einen Artikel auszuwählen
- Der aktuelle Artikel kann nicht ausgewählt werden (Endlosschleifen-Schutz)

### 2. Einbindungsart wählen
- **Kompletter Artikel**: Alle Inhalte des gewählten Artikels
- **Einzelner Slice**: Wählen Sie einen spezifischen Block aus der Liste

### 3. Slice-Auswahl (optional)
- Alle verfügbaren Blöcke werden mit Vorschau angezeigt
- Modul-Name wird für bessere Orientierung angezeigt
- Live-Vorschau des Slice-Inhalts

## 🎯 Anwendungsfälle

### Wiederkehrende Inhalte
```
Bindet häufig verwendete Inhalte wie:
- Kontaktdaten
- Öffnungszeiten  
- Disclaimers
- Adressinformationen
```

### Modulare Inhaltsbausteine
```
Erstellen Sie wiederverwendbare Content-Blöcke:
- Call-to-Action Bereiche
- Produkt-Highlights
- Team-Vorstellungen
- FAQ-Abschnitte
```

### Template-Bausteine
```
Zentrale Verwaltung von:
- Header-Bereichen
- Footer-Inhalten
- Sidebar-Elementen
- Banner-Rotationen
```

## 🔍 Backend-Features

### Intelligente Validierung
- Prüfung auf existierende Artikel und Slices
- Warnung bei gelöschten Inhalten
- Endlosschleifen-Erkennung

### Benutzerfreundliche Oberfläche
- Artikel-Titel wird angezeigt
- Slice-Vorschau mit Modul-Information
- Visueller Feedback bei Auswahl
- Responsive Layout für mobile Nutzung

### Fehlerbehandlung
- Detaillierte Fehlermeldungen
- Graceful Degradation im Frontend
- Logging von kritischen Fehlern

## 🚀 Technische Details

### Sicherheit
- Schutz vor Endlosschleifen
- Validierung aller Eingaben
- Exception-Handling
- XSS-Schutz durch rex_escape()

### Performance
- Lazy Loading von Slice-Inhalten
- Optimierte Datenbankabfragen
- Caching-freundlich

### Kompatibilität
- REDAXO 5.15+ (verwendet moderne APIs)
- Mehrsprachigkeit unterstützt
- Backend und Frontend optimiert

## 🛠️ Konfiguration

Das Modul benötigt keine spezielle Konfiguration und funktioniert sofort nach der Installation.

### Erweiterte Anpassungen
Für spezielle Anwendungsfälle können Sie das Modul anpassen:

```php
// Beispiel: Zusätzliche CSS-Klassen
echo '<div class="embedded-content">';
echo $articleContent->getArticle();
echo '</div>';
```

## 🐛 Problembehandlung

### Häufige Probleme

**"Artikel existiert nicht mehr"**
- Der ursprünglich ausgewählte Artikel wurde gelöscht
- Lösung: Neuen Artikel auswählen

**"Slice existiert nicht mehr"**  
- Der ausgewählte Block wurde gelöscht
- Lösung: Neuen Block auswählen oder kompletten Artikel einbinden

**"Keine Vorschau verfügbar"**
- Slice enthält nur Medien oder komplexe Inhalte
- Das ist normal und beeinträchtigt die Funktion nicht

### Debug-Modus
Im Backend werden ausführliche Informationen angezeigt:
- Artikel-ID und Name
- Slice-ID und Modul
- Fehlermeldungen mit Details

## 📝 Changelog

### Version 2.0.0
- Komplette Neuentwicklung für REDAXO 5.15+
- Moderne Benutzeroberfläche mit Bootstrap
- Verbesserte Fehlerbehandlung
- Live-Vorschau der Slices
- Endlosschleifen-Schutz
- Mobile-optimiert
- Erweiterte Validierung mit Presave-Action

### Version 1.x (Legacy)
- Originalversion "Slice-HiJacker" von Mirco Brandes/Gerald Rusche
- Für REDAXO 4.x entwickelt
- Basis-Funktionalität

## 👥 Danksagung

- **Mirco Brandes & Gerald Rusche** - Entwickler des ursprünglichen "Slice-HiJacker" Moduls für REDAXO 4.x
- **Friends Of REDAXO Community** - Modernisierung für REDAXO 5.15+

## 📄 Lizenz

MIT License - Siehe LICENSE Datei für Details.

---

*Dieses Modul ist Teil der REDAXO Community Module Collection und wird aktiv gepflegt.*
