<?php

/**
 * StuffX Demo Helper Class
 * 
 * Diese Klasse demonstriert nützliche Helper-Funktionen für REDAXO Projekte
 * und kann als Vorlage für eigene Utility-Klassen verwendet werden.
 * 
 * @package StuffX
 * @author Thomas Skerbis
 * @version 1.0.0
 */

class DemoHelper
{
    /**
     * Generiert eine HTML-Card-Komponente
     * 
     * @param string $title Titel der Card
     * @param string $content Inhalt der Card
     * @param string $image Bild-URL (optional)
     * @param string $link Link-URL (optional)
     * @param array $classes Zusätzliche CSS-Klassen
     * @return string HTML-Code der Card
     */
    public static function generateCard($title, $content, $image = '', $link = '', $classes = [])
    {
        $cardClasses = array_merge(['card', 'mb-4'], $classes);
        $classString = implode(' ', $cardClasses);
        
        $html = '<div class="' . rex_escape($classString) . '">';
        
        // Bild
        if (!empty($image)) {
            $html .= '<img src="' . rex_escape($image) . '" class="card-img-top" alt="' . rex_escape($title) . '">';
        }
        
        $html .= '<div class="card-body">';
        $html .= '<h5 class="card-title">' . rex_escape($title) . '</h5>';
        $html .= '<p class="card-text">' . $content . '</p>';
        
        // Link-Button
        if (!empty($link)) {
            $html .= '<a href="' . rex_escape($link) . '" class="btn btn-primary">Weiterlesen</a>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Formatiert einen Text für die Ausgabe mit Fallback
     * 
     * @param string $text Der zu formatierende Text
     * @param string $fallback Fallback-Text wenn leer
     * @param bool $stripTags HTML-Tags entfernen
     * @param int $maxLength Maximale Länge (0 = unbegrenzt)
     * @return string Formatierter Text
     */
    public static function formatText($text, $fallback = 'Kein Text verfügbar', $stripTags = false, $maxLength = 0)
    {
        // Fallback wenn leer
        if (empty(trim($text))) {
            return rex_escape($fallback);
        }
        
        // HTML-Tags entfernen falls gewünscht
        if ($stripTags) {
            $text = strip_tags($text);
        }
        
        // Text kürzen falls gewünscht
        if ($maxLength > 0 && mb_strlen($text) > $maxLength) {
            $text = mb_substr($text, 0, $maxLength) . '...';
        }
        
        return $stripTags ? rex_escape($text) : $text;
    }
    
    /**
     * Generiert eine Breadcrumb-Navigation
     * 
     * @param array $items Array mit ['title' => 'Titel', 'url' => 'URL'] Einträgen
     * @param string $separator Trennzeichen zwischen Einträgen
     * @return string HTML-Code der Breadcrumb
     */
    public static function generateBreadcrumb($items, $separator = '/')
    {
        if (empty($items)) {
            return '';
        }
        
        $html = '<nav aria-label="breadcrumb">';
        $html .= '<ol class="breadcrumb">';
        
        $lastIndex = count($items) - 1;
        
        foreach ($items as $index => $item) {
            $isLast = ($index === $lastIndex);
            
            $html .= '<li class="breadcrumb-item' . ($isLast ? ' active' : '') . '">';
            
            if (!$isLast && !empty($item['url'])) {
                $html .= '<a href="' . rex_escape($item['url']) . '">' . rex_escape($item['title']) . '</a>';
            } else {
                $html .= rex_escape($item['title']);
            }
            
            $html .= '</li>';
        }
        
        $html .= '</ol>';
        $html .= '</nav>';
        
        return $html;
    }
    
    /**
     * Generiert ein responsives Bild mit verschiedenen Breakpoints
     * 
     * @param string $imagePath Pfad zum Bild
     * @param string $alt Alt-Text
     * @param array $breakpoints Array mit Breakpoint-Definitionen
     * @param array $attributes Zusätzliche HTML-Attribute
     * @return string HTML-Code des responsiven Bildes
     */
    public static function generateResponsiveImage($imagePath, $alt = '', $breakpoints = [], $attributes = [])
    {
        if (empty($imagePath)) {
            return '';
        }
        
        // Standard-Attribute
        $defaultAttributes = [
            'class' => 'img-fluid',
            'loading' => 'lazy'
        ];
        
        $attributes = array_merge($defaultAttributes, $attributes);
        $attributeString = '';
        
        foreach ($attributes as $key => $value) {
            $attributeString .= ' ' . rex_escape($key) . '="' . rex_escape($value) . '"';
        }
        
        // Einfaches Bild wenn keine Breakpoints definiert
        if (empty($breakpoints)) {
            return '<img src="' . rex_escape($imagePath) . '" alt="' . rex_escape($alt) . '"' . $attributeString . '>';
        }
        
        // Picture-Element mit Breakpoints
        $html = '<picture>';
        
        foreach ($breakpoints as $breakpoint) {
            if (isset($breakpoint['media']) && isset($breakpoint['src'])) {
                $html .= '<source media="' . rex_escape($breakpoint['media']) . '" srcset="' . rex_escape($breakpoint['src']) . '">';
            }
        }
        
        $html .= '<img src="' . rex_escape($imagePath) . '" alt="' . rex_escape($alt) . '"' . $attributeString . '>';
        $html .= '</picture>';
        
        return $html;
    }
    
    /**
     * Erstellt eine einfache Pagination
     * 
     * @param int $currentPage Aktuelle Seite
     * @param int $totalPages Gesamtanzahl Seiten
     * @param string $baseUrl Basis-URL für Links
     * @param int $range Anzahl Seiten links/rechts der aktuellen Seite
     * @return string HTML-Code der Pagination
     */
    public static function generatePagination($currentPage, $totalPages, $baseUrl, $range = 2)
    {
        if ($totalPages <= 1) {
            return '';
        }
        
        $html = '<nav aria-label="Pagination">';
        $html .= '<ul class="pagination justify-content-center">';
        
        // Vorherige Seite
        if ($currentPage > 1) {
            $prevUrl = $baseUrl . '?page=' . ($currentPage - 1);
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link" href="' . rex_escape($prevUrl) . '">Vorherige</a>';
            $html .= '</li>';
        }
        
        // Seitenzahlen
        $start = max(1, $currentPage - $range);
        $end = min($totalPages, $currentPage + $range);
        
        for ($i = $start; $i <= $end; $i++) {
            $isActive = ($i === $currentPage);
            $pageUrl = $baseUrl . '?page=' . $i;
            
            $html .= '<li class="page-item' . ($isActive ? ' active' : '') . '">';
            
            if ($isActive) {
                $html .= '<span class="page-link">' . $i . '</span>';
            } else {
                $html .= '<a class="page-link" href="' . rex_escape($pageUrl) . '">' . $i . '</a>';
            }
            
            $html .= '</li>';
        }
        
        // Nächste Seite
        if ($currentPage < $totalPages) {
            $nextUrl = $baseUrl . '?page=' . ($currentPage + 1);
            $html .= '<li class="page-item">';
            $html .= '<a class="page-link" href="' . rex_escape($nextUrl) . '">Nächste</a>';
            $html .= '</li>';
        }
        
        $html .= '</ul>';
        $html .= '</nav>';
        
        return $html;
    }
    
    /**
     * Validiert eine E-Mail-Adresse
     * 
     * @param string $email E-Mail-Adresse
     * @return bool True wenn gültig
     */
    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Generiert einen sicheren Slug aus einem String
     * 
     * @param string $text Eingabetext
     * @param string $separator Trennzeichen für Leerzeichen
     * @return string Generierter Slug
     */
    public static function generateSlug($text, $separator = '-')
    {
        // Umlaute und Sonderzeichen konvertieren
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        
        // Kleinbuchstaben
        $text = strtolower($text);
        
        // Nur Buchstaben, Zahlen und Bindestriche
        $text = preg_replace('/[^a-z0-9\-]/', $separator, $text);
        
        // Mehrfache Separatoren entfernen
        $text = preg_replace('/[' . preg_quote($separator) . ']+/', $separator, $text);
        
        // Separator am Anfang/Ende entfernen
        $text = trim($text, $separator);
        
        return $text;
    }
}
