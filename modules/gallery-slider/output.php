<?php
/**
 * Galerie Slider - Output
 * 
 * @package REDAXO Module
 * @author Friends Of REDAXO
 * @version 1.2.0
 */

// Daten laden
$medialist = explode(',', "REX_MEDIALIST[1]");
$headline = "REX_VALUE[1]";
$description = "REX_VALUE[2]";
$settings = json_decode("REX_VALUE[3]", true) ?: [];

// Keine Ausgabe wenn keine Bilder vorhanden
if (empty($medialist) || empty($medialist[0])) {
    return;
}

// Einstellungen mit Defaults
$autoplay = $settings['autoplay'] ?? false;
$speed = $settings['speed'] ?? 3000;
$showDots = $settings['showDots'] ?? true;
$showArrows = $settings['showArrows'] ?? true;

// Eindeutige Slider-ID generieren
$sliderId = 'gallery-slider-' . rex_article::getCurrentId() . '-' . $this->getId();

?>
<div class="gallery-slider-container" id="<?= $sliderId ?>">
    <?php if ($headline): ?>
        <h3 class="gallery-title"><?= rex_escape($headline) ?></h3>
    <?php endif; ?>
    
    <?php if ($description): ?>
        <p class="gallery-description"><?= nl2br(rex_escape($description)) ?></p>
    <?php endif; ?>
    
    <div class="gallery-slider" 
         data-autoplay="<?= $autoplay ? 'true' : 'false' ?>"
         data-speed="<?= $speed ?>"
         data-dots="<?= $showDots ? 'true' : 'false' ?>"
         data-arrows="<?= $showArrows ? 'true' : 'false' ?>">
        
        <div class="slider-wrapper">
            <?php foreach ($medialist as $index => $filename): ?>
                <?php if (empty($filename)) continue; ?>
                <?php 
                $media = rex_media::get($filename);
                if (!$media) continue;
                
                $title = $media->getTitle() ?: $media->getFileName();
                $alt = $media->getValue('med_description') ?: $title;
                ?>
                
                <div class="slide" data-slide="<?= $index ?>">
                    <figure class="slide-figure">
                        <img src="<?= rex_url::media($filename) ?>" 
                             alt="<?= rex_escape($alt) ?>"
                             title="<?= rex_escape($title) ?>"
                             class="slide-image"
                             loading="<?= $index === 0 ? 'eager' : 'lazy' ?>">
                        
                        <?php if ($title && $title !== $filename): ?>
                            <figcaption class="slide-caption">
                                <?= rex_escape($title) ?>
                            </figcaption>
                        <?php endif; ?>
                    </figure>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($showArrows && count($medialist) > 1): ?>
            <button class="slider-nav slider-prev" aria-label="Vorheriges Bild">
                <span class="sr-only">Zurück</span>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                </svg>
            </button>
            
            <button class="slider-nav slider-next" aria-label="Nächstes Bild">
                <span class="sr-only">Weiter</span>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                </svg>
            </button>
        <?php endif; ?>
        
        <?php if ($showDots && count($medialist) > 1): ?>
            <div class="slider-dots">
                <?php foreach ($medialist as $index => $filename): ?>
                    <?php if (empty($filename)) continue; ?>
                    <button class="dot <?= $index === 0 ? 'active' : '' ?>" 
                            data-slide="<?= $index ?>"
                            aria-label="Zu Bild <?= $index + 1 ?> wechseln"></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Slider initialisieren
document.addEventListener('DOMContentLoaded', function() {
    if (typeof GallerySlider !== 'undefined') {
        new GallerySlider('#<?= $sliderId ?> .gallery-slider');
    }
});
</script>
