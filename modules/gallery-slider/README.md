# Gallery Slider - REDAXO Modul

Ein modernes, vollständig responsives Galerie-Modul mit Slider-Funktionalität und Lightbox für REDAXO CMS.

## ✨ Features

- **📱 Vollständig responsive** - Funktioniert auf allen Geräten
- **👆 Touch-Unterstützung** - Swipe-Gesten auf mobilen Geräten
- **⌨️ Tastatur-Navigation** - Pfeiltasten und ESC-Taste
- **🖼️ Lightbox-Integration** - Bilder in Vollansicht betrachten
- **⚡ Autoplay-Funktion** - Automatische Bildwechsel (optional)
- **🎨 Anpassbares Design** - CSS kann individuell angepasst werden
- **♿ Barrierefrei** - Screen Reader und Keyboard-Support

## 📁 Struktur

```
gallery-slider/
├── config.yml          # Modul-Konfiguration
├── input.php           # Backend-Eingabemaske
├── output.php          # Frontend-Ausgabe
├── README.md          # Diese Dokumentation
└── assets/
    ├── css/
    │   ├── slider.css    # Haupt-Styling für Slider
    │   └── lightbox.css  # Lightbox-Styling
    └── js/
        ├── slider.js     # Slider-Funktionalität
        └── lightbox.js   # Lightbox-Funktionalität
```

## 🚀 Installation

### Über GitHub Installer AddOn:
1. Repository hinzufügen (z.B. `username/stuffx`)
2. Modul "gallery-slider" installieren
3. Assets werden automatisch nach `/assets/modules/gallery_slider/` kopiert

### Manuelle Installation:
1. Modul-Code in REDAXO Backend einfügen
2. Assets manuell in `/assets/modules/gallery_slider/` ablegen
3. CSS und JS in Template einbinden

## 📝 Verwendung

### Backend (Eingabe):
- **Überschrift**: Optionaler Titel für die Galerie
- **Beschreibung**: Optionale Beschreibung
- **Galerie-Bilder**: Medienauswahl per Drag & Drop sortierbar
- **Einstellungen**: 
  - Autoplay aktivieren/deaktivieren
  - Geschwindigkeit (2s, 3s, 5s)
  - Navigationspunkte ein/aus
  - Pfeile ein/aus

### Frontend (Ausgabe):
- Automatische Generierung einer responsiven Galerie
- Touch-Gesten für Navigation auf mobilen Geräten
- Lightbox beim Klick auf Bilder
- Keyboard-Navigation mit Pfeiltasten

## ⚙️ Konfiguration

Die Konfiguration erfolgt über das Backend-Interface. Alle Einstellungen werden als JSON gespeichert:

```json
{
  "autoplay": true,
  "speed": 3000,
  "showDots": true,
  "showArrows": true
}
```

## 🎨 CSS-Anpassungen

Das Design kann über die CSS-Dateien angepasst werden:

- `slider.css` - Hauptstyles für den Slider
- `lightbox.css` - Styles für die Lightbox

Wichtige CSS-Klassen:
- `.gallery-slider-container` - Haupt-Container
- `.gallery-slider` - Slider-Element
- `.slide` - Einzelne Slides
- `.slider-nav` - Navigation-Buttons
- `.slider-dots` - Navigationspunkte

## 📱 Responsive Breakpoints

- **Desktop**: > 768px
- **Tablet**: 768px - 481px  
- **Mobile**: ≤ 480px

## 🔧 JavaScript API

```javascript
// Slider manuell initialisieren
const slider = new GallerySlider('#my-slider .gallery-slider');

// Autoplay steuern
slider.play();
slider.pause();

// Navigation
slider.nextSlide();
slider.prevSlide();
slider.goToSlide(2);

// Lightbox öffnen
slider.openLightbox(0);
```

## ⌨️ Tastatur-Shortcuts

- **Pfeiltasten**: Navigation zwischen Bildern
- **Leertaste/Enter**: Autoplay pausieren/fortsetzen
- **ESC**: Lightbox schließen

## 👆 Touch-Gesten

- **Swipe links/rechts**: Navigation zwischen Bildern
- **Tap auf Bild**: Lightbox öffnen
- **Tap außerhalb**: Lightbox schließen

## 🔗 Asset-Integration

Das Modul bindet automatisch folgende Assets ein:

**CSS:**
- `/assets/modules/gallery_slider/css/slider.css`
- `/assets/modules/gallery_slider/css/lightbox.css`

**JavaScript:**
- `/assets/modules/gallery_slider/js/slider.js`
- `/assets/modules/gallery_slider/js/lightbox.js`

## 🏗️ Template-Integration

Assets können im Template eingebunden werden:

```php
// CSS im <head>
<link rel="stylesheet" href="<?= rex_url::assets('modules/gallery_slider/css/slider.css') ?>">
<link rel="stylesheet" href="<?= rex_url::assets('modules/gallery_slider/css/lightbox.css') ?>">

// JS vor </body>
<script src="<?= rex_url::assets('modules/gallery_slider/js/slider.js') ?>"></script>
<script src="<?= rex_url::assets('modules/gallery_slider/js/lightbox.js') ?>"></script>
```

## 🔧 Systemanforderungen

- REDAXO 5.13+
- PHP 8.1+
- Moderne Browser (Chrome, Firefox, Safari, Edge)
- jQuery 3.6+ (für Backend-Interface)

## 🐛 Bekannte Limitierungen

- Lightbox erfordert JavaScript
- Autoplay wird auf mobilen Geräten automatisch pausiert
- Assets müssen manuell im Template eingebunden werden (falls nicht automatisch)

## 📄 Lizenz

MIT License - Frei verwendbar für alle Projekte.

## 👥 Support

Bei Fragen oder Problemen:
- [GitHub Issues](https://github.com/username/stuffx/issues)
- [REDAXO Community](https://www.redaxo.org/community/)

---

**Erstellt von Friends Of REDAXO** • Version 1.2.0
