# Einfacher Text - REDAXO Modul

Ein einfaches und vielseitiges Textmodul für REDAXO CMS.

## Features

- **Überschrift** (optional): H2-Überschrift für das Textmodul
- **Text**: Freier Textbereich mit HTML-Unterstützung  
- **CSS-Klasse** (optional): Individuelle CSS-Klassen für Styling

## Verwendung

### Felder

1. **Überschrift** (REX_VALUE[1])
   - Optional
   - Wird als `<h2>` ausgegeben
   - HTML wird escaped für Sicherheit

2. **Text** (REX_VALUE[2])
   - HTML-Tags sind erlaubt
   - Mehrzeilige Eingabe möglich
   - Für einfache Formatierung

3. **CSS-Klasse** (REX_VALUE[3])
   - Optional
   - Wird dem Wrapper-`<div>` hinzugefügt
   - Beispiele: `text-center`, `highlight`, `col-md-6`

### HTML-Struktur

```html
<div class="text-module [custom-class]">
    <h2 class="text-module__headline">Überschrift</h2>
    <div class="text-module__content">
        Text-Inhalt...
    </div>
</div>
```

## Installation

Über das Stuff AddOn:
1. Repository hinzufügen
2. Modul "text-simple" installieren
3. In Template verwenden: `REX_MODULE[ID=X]`

## Kompatibilität

- REDAXO 5.13+
- Alle modernen Browser
- Responsive-ready

## Lizenz

MIT License
