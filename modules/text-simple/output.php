<?php
$headline = trim(REX_VALUE[1]);
$text = trim(REX_VALUE[2]);
$cssClass = trim(REX_VALUE[3]);

if (!$headline && !$text) {
    // Nichts ausgeben wenn beide Felder leer sind
    return;
}

// CSS-Klasse aufbereiten
$classAttribute = '';
if ($cssClass) {
    $classAttribute = ' class="' . rex_escape($cssClass) . '"';
}
?>

<div class="text-module"<?= $classAttribute ?>>
    <?php if ($headline): ?>
    <h2 class="text-module__headline"><?= rex_escape($headline) ?></h2>
    <?php endif; ?>
    
    <?php if ($text): ?>
    <div class="text-module__content">
        <?= $text ?>
    </div>
    <?php endif; ?>
</div>
