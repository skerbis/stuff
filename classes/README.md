# DemoHelper - REDAXO Utility Klasse

Eine umfassende Helper-Klasse für REDAXO-Projekte mit nützlichen Funktionen für die Frontend-Entwicklung.

## 🚀 Funktionen

### 🎨 UI-Komponenten
- **HTML-Cards** generieren mit Bild, Titel, Text und Links
- **Breadcrumb-Navigation** erstellen
- **Responsive Bilder** mit Breakpoints
- **Pagination** für Seitennummerierung

### 📝 Text-Verarbeitung
- **Text formatieren** mit Fallback-Optionen
- **Sichere Slugs** aus Texten generieren
- **HTML-Tags entfernen** und Text kürzen

### ✅ Validierung
- **E-Mail-Adressen** validieren

## 📦 Installation

1. Repository zum GitHub Installer hinzufügen
2. Zur "Klassen"-Seite navigieren  
3. Repository auswählen
4. DemoHelper-Klasse installieren
5. Die Klasse wird nach `/project/lib/DemoHelper.php` kopiert

## 💡 Verwendung

### HTML-Card generieren
```php
echo DemoHelper::generateCard(
    'Artikel Titel',
    'Hier steht die Beschreibung des Artikels...',
    '/media/artikel-bild.jpg',
    '/artikel/detail/123',
    ['custom-class', 'featured']
);
```

### Text formatieren
```php
// Text mit Fallback und Längen-Begrenzung
echo DemoHelper::formatText(
    $article_text, 
    'Kein Text verfügbar', 
    true,    // HTML-Tags entfernen
    200      // Maximal 200 Zeichen
);
```

### Breadcrumb-Navigation
```php
$breadcrumb_items = [
    ['title' => 'Home', 'url' => '/'],
    ['title' => 'Kategorie', 'url' => '/kategorie/'],
    ['title' => 'Aktueller Artikel'] // Letzter Eintrag ohne URL
];

echo DemoHelper::generateBreadcrumb($breadcrumb_items);
```

### Responsive Bilder
```php
$breakpoints = [
    ['media' => '(max-width: 768px)', 'src' => '/media/bild-mobile.jpg'],
    ['media' => '(max-width: 1200px)', 'src' => '/media/bild-tablet.jpg']
];

echo DemoHelper::generateResponsiveImage(
    '/media/bild-desktop.jpg',
    'Alt-Text für das Bild',
    $breakpoints,
    ['class' => 'hero-image', 'loading' => 'lazy']
);
```

### Pagination
```php
// Seite 3 von 10 Seiten
echo DemoHelper::generatePagination(3, 10, '/artikel', 2);
```

### E-Mail validieren
```php
if (DemoHelper::validateEmail($email)) {
    echo "Gültige E-Mail-Adresse";
}
```

### Slug generieren
```php
$slug = DemoHelper::generateSlug('Mein Artikel Titel!'); 
// Ergebnis: "mein-artikel-titel"
```

## 🎯 Praktische Beispiele

### Artikel-Teaser mit Card
```php
$articles = rex_article::getRootArticles();

foreach ($articles as $article) {
    echo DemoHelper::generateCard(
        $article->getName(),
        DemoHelper::formatText($article->getValue('art_description'), 'Keine Beschreibung', true, 150),
        $article->getValue('art_image') ? '/media/' . $article->getValue('art_image') : '',
        $article->getUrl(),
        ['col-md-4', 'article-teaser']
    );
}
```

### Breadcrumb aus REDAXO-Pfad
```php
$breadcrumb = [];
$path = rex_article::getCurrent()->getPathAsArray();

foreach ($path as $article) {
    $breadcrumb[] = [
        'title' => $article->getName(),
        'url' => $article->getUrl()
    ];
}

// Aktuelle Seite ohne Link
$breadcrumb[] = ['title' => rex_article::getCurrent()->getName()];

echo DemoHelper::generateBreadcrumb($breadcrumb);
```

## 🔧 Anpassungen

Die Klasse kann einfach erweitert oder angepasst werden:

1. Datei `/project/lib/DemoHelper.php` bearbeiten
2. Neue Methoden hinzufügen
3. Bestehende Methoden anpassen

## 📋 Systemanforderungen

- REDAXO 5.13+
- PHP 8.1+

## 👨‍💻 Autor

Thomas Skerbis - [GitHub](https://github.com/skerbis)

## 📄 Lizenz

MIT License - Kann frei verwendet und angepasst werden.
