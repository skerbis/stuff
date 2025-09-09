<?php
$headline = trim(REX_VALUE[1]);
$text = trim(REX_VALUE[2]);
$link = trim(REX_VALUE[3]);
$position = REX_VALUE[4] ?: 'left';
$image = REX_MEDIA[1];

if (!$headline && !$text && !$image) {
    return;
}

$hasLink = !empty($link);
$linkStart = $hasLink ? '<a href="' . rex_escape($link) . '">' : '';
$linkEnd = $hasLink ? '</a>' : '';

// Layout-Klassen basierend auf Position
$layoutClass = 'image-text--' . $position;
$imageCol = $position === 'top' ? 'col-12' : 'col-md-6';
$textCol = $position === 'top' ? 'col-12' : 'col-md-6';
?>

<div class="image-text <?= $layoutClass ?>">
    <div class="row">
        <?php if ($position === 'right'): ?>
        <!-- Text zuerst bei rechter Bildposition -->
        <div class="<?= $textCol ?> image-text__text-col">
            <?php if ($headline): ?>
            <h3 class="image-text__headline"><?= rex_escape($headline) ?></h3>
            <?php endif; ?>
            
            <?php if ($text): ?>
            <div class="image-text__content">
                <?= nl2br(rex_escape($text)) ?>
            </div>
            <?php endif; ?>
            
            <?php if ($hasLink): ?>
            <p class="image-text__link">
                <a href="<?= rex_escape($link) ?>" class="btn btn-primary">Mehr erfahren</a>
            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <?php if ($image): ?>
        <div class="<?= $imageCol ?> image-text__image-col">
            <div class="image-text__image">
                <?= $linkStart ?>
                <img src="<?= rex_media_manager::getUrl('rex_media_medium', $image) ?>" 
                     alt="<?= rex_escape($headline ?: 'Bild') ?>" 
                     class="img-responsive" />
                <?= $linkEnd ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($position !== 'right'): ?>
        <!-- Text nach Bild bei linker/oberer Position -->
        <div class="<?= $textCol ?> image-text__text-col">
            <?php if ($headline): ?>
            <h3 class="image-text__headline"><?= rex_escape($headline) ?></h3>
            <?php endif; ?>
            
            <?php if ($text): ?>
            <div class="image-text__content">
                <?= nl2br(rex_escape($text)) ?>
            </div>
            <?php endif; ?>
            
            <?php if ($hasLink): ?>
            <p class="image-text__link">
                <a href="<?= rex_escape($link) ?>" class="btn btn-primary">Mehr erfahren</a>
            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
