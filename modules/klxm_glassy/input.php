<?php
/**
 * KLXM Glassy Components - Kombiniertes Modul
 * Slider, Feature-Slider und Carousel in einem Modul
 */

use FriendsOfRedaxo\MForm;
use FriendsOfRedaxo\MBlock\MBlock;

if (!rex_addon::get('mform')->isAvailable() || !rex_addon::get('mblock')->isAvailable()) {
    echo rex_view::error('Dieses Modul benötigt die Addons MForm und MBlock.');
    return;
}

// ============================================================
// Slider-Konfiguration (für MBlock)
// ============================================================
$sliderForm = MForm::factory()
    ->addMediaField(1, ['label' => '<i class="fas fa-image"></i> Bild/Video', 'types' => 'jpg,jpeg,png,gif,webp,mp4,webm'])
    ->addTextField("10.0.title", ['label' => '<i class="fas fa-heading"></i> Titel'])
    ->addTextAreaField("10.0.description", ['label' => '<i class="fas fa-align-left"></i> Beschreibung'])
    ->addSelectField("10.0.contentPosition", [
        'bottom-left' => 'Unten Links',
        'bottom-center' => 'Unten Mitte',
        'bottom-right' => 'Unten Rechts',
        'center-left' => 'Mitte Links',
        'center' => 'Mitte',
        'center-right' => 'Mitte Rechts',
        'top-left' => 'Oben Links',
        'top-center' => 'Oben Mitte',
        'top-right' => 'Oben Rechts'
    ], ['label' => '<i class="fas fa-arrows-alt"></i> Text-Position', 'class' => 'selectpicker'])
    ->addLinkField(2, ['label' => '<i class="fas fa-link"></i> Link (optional)'])
    ->addSelectField("10.0.linkTarget", ['_self' => 'Gleiches Fenster', '_blank' => 'Neues Fenster'], ['label' => '<i class="fas fa-external-link-alt"></i> Link öffnen in', 'class' => 'selectpicker']);

// ============================================================
// Feature-Slider-Konfiguration (für MBlock)
// ============================================================
$featureForm = MForm::factory()
    ->addTextField("11.0.title", ['label' => '<i class="fas fa-heading"></i> Titel'])
    ->addTextAreaField("11.0.description", ['label' => '<i class="fas fa-align-left"></i> Beschreibung'])
    ->addTextField("11.0.icon", [
        'label' => '<i class="fas fa-icons"></i> Icon',
        'placeholder' => '🎨 oder home oder fa-star',
        'notice' => 'Emoji (🎨), UIkit Icon-Name (home, settings), FontAwesome (fa-star, fas fa-home) oder HTML'
    ])
    ->addSelectField("11.0.mediaType", [
        'content' => 'HTML Content (freier Text)',
        'article' => 'Artikel einbinden',
        'image' => 'Bild',
        'video' => 'Video'
    ], ['label' => '<i class="fas fa-photo-video"></i> Media Typ', 'class' => 'selectpicker'])
    ->addMediaField(1, ['label' => '<i class="fas fa-image"></i> Bild/Video Datei', 'types' => 'jpg,jpeg,png,gif,webp,mp4,webm'])
    ->addLinkField(2, ['label' => '<i class="fas fa-file-alt"></i> Artikel (nur bei "Artikel einbinden")'])
    ->addTextAreaField("11.0.content", [
        'label' => '<i class="fas fa-code"></i> HTML Content',
        'class' => 'form-control cke5-editor',
        'data-lang' => \rex_i18n::getLanguage(),
        'data-profile' => 'default'
    ]);

// ============================================================
// Carousel-Konfiguration (für MBlock)
// ============================================================
$carouselForm = MForm::factory()
    ->addMediaField(1, ['label' => '<i class="fas fa-image"></i> Bild'])
    ->addTextField("12.0.title", ['label' => '<i class="fas fa-heading"></i> Titel'])
    ->addTextAreaField("12.0.description", ['label' => '<i class="fas fa-align-left"></i> Beschreibung'])
    ->addLinkField(2, ['label' => '<i class="fas fa-link"></i> Link (optional)'])
    ->addSelectField("12.0.linkTarget", ['_self' => 'Gleiches Fenster', '_blank' => 'Neues Fenster'], ['label' => '<i class="fas fa-external-link-alt"></i> Link öffnen in', 'class' => 'selectpicker']);

// ============================================================
// Hauptformular mit Tabs
// ============================================================
$main = MForm::factory()
    // Tab 1: Komponententyp wählen
    ->addTabElement('<i class="fas fa-cubes"></i> Komponente', MForm::factory()
        ->addSelectField("1.0.componentType", [
            'slider' => 'Glass Slider',
            'feature' => 'Glass Feature Slider',
            'carousel' => 'Glass Carousel'
        ], ['label' => '<i class="fas fa-exchange-alt"></i> Komponenten-Typ', 'class' => 'selectpicker'])
        ->setToggleOptions([
            'slider' => 'slider-options',
            'feature' => 'feature-options',
            'carousel' => 'carousel-options'
        ])
        
        // Slider Items (toggle: slider-options)
        ->addCollapseElement('<i class="fas fa-images"></i> Slider Items', MForm::factory()
            ->addHtml(MBlock::show(10, $sliderForm->show(), ['min' => 1, 'max' => 20]))
        , false, false, ['data-group-collapse-target' => 'slider-options'])
        
        // Feature Items (toggle: feature-options)
        ->addCollapseElement('<i class="fas fa-star"></i> Feature Items', MForm::factory()
            ->addHtml(MBlock::show(11, $featureForm->show(), ['min' => 1, 'max' => 20]))
        , false, false, ['data-group-collapse-target' => 'feature-options'])
        
        // Carousel Items (toggle: carousel-options)
        ->addCollapseElement('<i class="fas fa-clone"></i> Carousel Items', MForm::factory()
            ->addHtml(MBlock::show(12, $carouselForm->show(), ['min' => 1, 'max' => 20]))
        , false, false, ['data-group-collapse-target' => 'carousel-options'])
    , true)
    
    // Tab 2: Komponenten-Einstellungen
    ->addTabElement('<i class="fas fa-sliders-h"></i> Einstellungen', MForm::factory()
        ->addFieldsetArea('Darstellung', MForm::factory()
            ->addSelectField("2.0.theme", [
                'dark' => 'Dunkel',
                'light' => 'Hell',
                'glass-dark' => 'Glass Dunkel (transparent)',
                'glass-light' => 'Glass Hell (transparent)'
            ], ['label' => '<i class="fas fa-palette"></i> Theme', 'class' => 'selectpicker'])
            ->addTextField("2.0.height", ['label' => '<i class="fas fa-arrows-alt-v"></i> Höhe', 'placeholder' => 'z.B. 500px, 80vh, auto'])
            ->addTextField("2.0.maxHeight", ['label' => '<i class="fas fa-compress-alt"></i> Maximale Höhe', 'placeholder' => 'z.B. 600px oder 80vh'])
            ->addTextField("2.0.aspectRatio", ['label' => '<i class="fas fa-expand"></i> Aspect Ratio', 'placeholder' => 'z.B. 16:9, 4:3, 21:9'])
            ->addMultiSelectField("2.0.disableOptions", [
                'norounded' => 'Keine abgerundeten Ecken'
            ], ['label' => '<i class="fas fa-ban"></i> Deaktivieren'])
        )
        ->addFieldsetArea('Verhalten', MForm::factory()
            ->addSelectField("2.0.navPosition", [
                'bottom-center' => 'Unten Mitte',
                'bottom-left' => 'Unten Links',
                'bottom-right' => 'Unten Rechts',
                'top-center' => 'Oben Mitte',
                'top-left' => 'Oben Links',
                'top-right' => 'Oben Rechts',
                'fixed-bottom' => 'Fixiert Unten',
                'below-slider' => 'Unter Komponente'
            ], ['label' => '<i class="fas fa-map-marker-alt"></i> Navigation Position', 'class' => 'selectpicker'])
            ->addSelectField("2.0.navVisibility", [
                'visible' => 'Sichtbar im Viewport',
                'always' => 'Immer sichtbar',
                'hover' => 'Bei Hover',
                'scroll' => 'Beim Scrollen'
            ], ['label' => '<i class="fas fa-eye"></i> Navigation Sichtbarkeit', 'class' => 'selectpicker'])
            ->addTextField("2.0.interval", ['label' => '<i class="fas fa-clock"></i> Autoplay Interval (ms)', 'placeholder' => '4000'])
            ->addMultiSelectField("2.0.options", [
                'autoplay' => 'Autoplay',
                'keyboard' => 'Keyboard Navigation',
                'touch' => 'Touch/Swipe'
            ], ['label' => '<i class="fas fa-toggle-on"></i> Optionen'])
            ->addMultiSelectField("2.0.behaviorDisable", [
                'noloop' => 'Kein Loop (am Ende stoppen)'
            ], ['label' => '<i class="fas fa-ban"></i> Deaktivieren'])
        )
        ->addFieldsetArea('Feature-Slider Optionen', MForm::factory()
            ->addSelectField("2.0.transition", [
                'scale' => 'Scale (Standard)',
                'fade' => 'Fade',
                'slide' => 'Slide',
                'flip' => 'Flip',
                'none' => 'Keine Animation'
            ], ['label' => '<i class="fas fa-magic"></i> Transition', 'class' => 'selectpicker'])
            ->addSelectField("2.0.mediaFit", [
                'contain' => 'Zentriert (komplett sichtbar)',
                'cover' => 'Füllend (Cover)'
            ], ['label' => '<i class="fas fa-crop-alt"></i> Medium-Anpassung', 'class' => 'selectpicker'])
            ->addMultiSelectField("2.0.featureOptions", [
                'scrollableContent' => 'Scrollbarer Content aktivieren',
                'hideIcons' => 'Icons ausblenden'
            ], ['label' => '<i class="fas fa-cog"></i> Feature Optionen'])
        )
    )
    
    // Tab 3: Sektion & Container (wie Content Builder Pro)
    ->addTabElement('<i class="fas fa-layer-group"></i> Sektion', MForm::factory()
        ->addSelectField("3.0.container", [
            'uk-container' => 'Standard',
            'uk-container uk-container-xsmall' => 'Extra schmal (xsmall)',
            'uk-container uk-container-small' => 'Schmal (small)',
            'uk-container uk-container-large' => 'Weit (large)',
            'uk-container uk-container-xlarge' => 'Extra weit (xlarge)',
            'uk-container uk-container-expand' => 'Maximale Breite (expand)',
            '' => 'Volle Breite (kein Container)'
        ], ['label' => '<i class="fas fa-expand-arrows-alt"></i> Container-Breite', 'class' => 'selectpicker', 'default-value' => 'uk-container'])
        ->addMediaField(3, ['label' => '<i class="fas fa-image"></i> Hintergrundbild'])
        ->addTextField("3.0.bgColor", ['label' => '<i class="fas fa-fill-drip"></i> Hintergrundfarbe', 'placeholder' => 'z.B. #f5f5f5 oder rgba(0,0,0,0.5)'])
        ->addSelectField("3.0.padding", [
            '' => 'Sektions-Standard',
            ' uk-padding-remove' => 'Keine Füllung',
            ' uk-padding-small' => 'Klein',
            ' uk-padding' => 'Mittel',
            ' uk-padding-large' => 'Groß',
            ' uk-padding-remove-top' => 'Füllung oben entfernen',
            ' uk-padding-remove-bottom' => 'Füllung unten entfernen'
        ], ['label' => '<i class="fas fa-arrows-alt-v"></i> Abschnittsfüllung', 'class' => 'selectpicker'])
        ->addSelectField("3.0.margin", [
            '' => 'Standard',
            ' uk-margin-remove' => 'Kein Margin',
            ' uk-margin-small' => 'Klein',
            ' uk-margin' => 'Mittel',
            ' uk-margin-large' => 'Groß',
            ' uk-margin-xlarge' => 'Extra Groß'
        ], ['label' => '<i class="fas fa-border-style"></i> Außenabstand', 'class' => 'selectpicker'])
        ->addTextField("3.0.customClass", ['label' => '<i class="fas fa-code"></i> Zusätzliche CSS-Klassen', 'placeholder' => 'z.B. my-custom-section'])
        ->addTextField("3.0.sectionId", ['label' => '<i class="fas fa-hashtag"></i> Sektion ID (für Anker-Links)', 'placeholder' => 'z.B. hero-section'])
    )
    
    // Tab 4: Hilfe
    ->addTabElement('<i class="fas fa-question-circle"></i> Hilfe', MForm::factory()
        ->addHtml('
            <div class="panel panel-default">
                <div class="panel-heading"><strong><i class="fas fa-images"></i> Glass Slider</strong></div>
                <div class="panel-body">
                    <p>Klassischer Bild-/Video-Slider mit Overlay-Text.</p>
                    <ul>
                        <li><strong>Medien:</strong> Bilder (jpg, png, webp, gif) oder Videos (mp4, webm)</li>
                        <li><strong>Titel/Beschreibung:</strong> Werden als Overlay auf dem Medium angezeigt</li>
                        <li><strong>Text-Position:</strong> Bestimmt wo der Overlay-Text erscheint</li>
                        <li><strong>Link:</strong> Optional - macht das gesamte Slide klickbar</li>
                    </ul>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading"><strong><i class="fas fa-star"></i> Glass Feature Slider</strong></div>
                <div class="panel-body">
                    <p>Feature-Showcase mit erweiterbarer Sidebar-Navigation (inspiriert von Apple Produktseiten).</p>
                    
                    <h5><i class="fas fa-photo-video"></i> Media-Typen:</h5>
                    <ul>
                        <li><strong>Bild:</strong> Zeigt ein Bild im Content-Bereich</li>
                        <li><strong>Video:</strong> Zeigt ein Video (autoplay, muted, loop)</li>
                        <li><strong>HTML Content:</strong> Freier HTML/Text-Inhalt mit CKEditor</li>
                        <li><strong>Artikel einbinden:</strong> Lädt den Inhalt eines anderen REDAXO-Artikels</li>
                    </ul>
                    
                    <h5><i class="fas fa-crop-alt"></i> Medium-Anpassung:</h5>
                    <ul>
                        <li><strong>Zentriert (contain):</strong> Das gesamte Bild ist sichtbar, wird zentriert dargestellt</li>
                        <li><strong>Füllend (cover):</strong> Bild füllt den gesamten Bereich, kann beschnitten werden</li>
                    </ul>
                    
                    <h5><i class="fas fa-icons"></i> Icons:</h5>
                    <p>Unterstützte Icon-Formate:</p>
                    <ul>
                        <li><strong>Emoji:</strong> 🎨 📱 🚀 (einfach kopieren)</li>
                        <li><strong>UIkit Icons:</strong> <code>home</code>, <code>settings</code>, <code>star</code></li>
                        <li><strong>FontAwesome:</strong> <code>fa-star</code>, <code>fas fa-home</code></li>
                        <li><strong>HTML:</strong> <code>&lt;i class="fa fa-star"&gt;&lt;/i&gt;</code></li>
                    </ul>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb"></i> <strong>Tipp:</strong> Bei Bild/Video nur die Medien-Datei auswählen. 
                        Der HTML-Content wird ignoriert wenn ein Media-Typ ausgewählt ist.
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading"><strong><i class="fas fa-clone"></i> Glass Carousel</strong></div>
                <div class="panel-body">
                    <p>3D Coverflow-Karussell für Bildergalerien.</p>
                    <ul>
                        <li><strong>Medien:</strong> Nur Bilder (jpg, png, webp, gif)</li>
                        <li><strong>Titel/Beschreibung:</strong> Werden unter dem aktiven Bild angezeigt</li>
                        <li><strong>Link:</strong> Optional - öffnet bei Klick auf das aktive Bild</li>
                    </ul>
                </div>
            </div>
            
            <div class="panel panel-warning">
                <div class="panel-heading"><strong><i class="fas fa-exclamation-triangle"></i> Häufige Probleme</strong></div>
                <div class="panel-body">
                    <h5>Bild wird nicht richtig angezeigt (Feature Slider):</h5>
                    <ul>
                        <li>Media-Typ auf "Bild" oder "Video" setzen</li>
                        <li>Medium-Anpassung prüfen (Zentriert vs. Füllend)</li>
                        <li>Aspect Ratio oder Höhe in den Einstellungen setzen</li>
                    </ul>
                    
                    <h5>Komponente wird nicht angezeigt:</h5>
                    <ul>
                        <li>Mindestens ein Item muss angelegt sein</li>
                        <li>Bei Feature Slider: Media-Typ muss ausgewählt sein</li>
                        <li>Cache leeren (REDAXO Cache löschen)</li>
                    </ul>
                    
                    <h5>Styles werden nicht geladen:</h5>
                    <ul>
                        <li>Prüfen ob <code>klxm_components</code> Addon aktiv ist</li>
                        <li>Browser-Cache leeren (Strg+F5)</li>
                    </ul>
                </div>
            </div>
            
            <div class="panel panel-info">
                <div class="panel-heading"><strong><i class="fas fa-code"></i> Technische Hinweise</strong></div>
                <div class="panel-body">
                    <ul>
                        <li><strong>Web Components:</strong> Nutzt Shadow DOM für isoliertes Styling</li>
                        <li><strong>Themes:</strong> dark, light, glass-dark, glass-light</li>
                        <li><strong>Responsive:</strong> Alle Komponenten passen sich automatisch an mobile Geräte an</li>
                        <li><strong>Performance:</strong> Lazy Loading für Bilder, IntersectionObserver für Autoplay-Pause</li>
                    </ul>
                </div>
            </div>
        ')
    );

echo $main->show();
