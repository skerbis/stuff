<?php
/**
 * KLXM Feature Slider - Modul Eingabe
 * Backend-Formular für die Konfiguration des Glass Feature Sliders
 */

use FriendsOfRedaxo\MForm;
use FriendsOfRedaxo\MBlock\MBlock;

if (!rex_addon::get('mform')->isAvailable() || !rex_addon::get('mblock')->isAvailable()) {
    echo rex_view::error('Dieses Modul benötigt die Addons MForm und MBlock.');
    return;
}

// MForm für Einstellungen
$mform = MForm::factory();

$mform->addSelectField(1);
$mform->setLabel('Theme');
$mform->setOption('dark', 'Dunkel');
$mform->setOption('light', 'Hell');
$mform->setOption('glass-dark', 'Glass Dunkel (transparent)');
$mform->setOption('glass-light', 'Glass Hell (transparent)');

$mform->addSelectField(5);
$mform->setLabel('Transition');
$mform->setOption('scale', 'Scale (Standard)');
$mform->setOption('fade', 'Fade');
$mform->setOption('slide', 'Slide');
$mform->setOption('flip', 'Flip');
$mform->setOption('none', 'Keine Animation');

$mform->addTextField(2, ['label' => 'Höhe (Desktop)', 'placeholder' => 'z.B. 500px, 80vh, auto']);
$mform->addTextField(6, ['label' => 'Maximale Höhe (Desktop)', 'placeholder' => 'z.B. 600px oder 80vh']);
$mform->addTextField(3, ['label' => 'Aspect Ratio (optional)', 'placeholder' => 'z.B. 16:9, 4:3, 21:9']);

$mform->addMultiSelectField(4, [
    'scrollableContent' => 'Scrollbarer Content aktivieren',
    'hideIcons' => 'Icons ausblenden',
    'useRatioWrapper' => 'Aspect-Ratio als Wrapper (stabiler)',
    'norounded' => 'Keine abgerundeten Ecken'
], ['label' => 'Optionen']);

echo $mform->show();

// MBlock für Feature Slides
$form = MForm::factory();

$form->addTextField("10.0.title", ['label' => 'Titel']);
$form->addTextAreaField("10.0.description", ['label' => 'Beschreibung']);
$form->addTextField("10.0.icon", [
    'label' => 'Icon', 
    'placeholder' => '🎨 oder home oder fa-star',
    'notice' => 'Emoji (🎨), UIkit Icon-Name (home, settings), FontAwesome (fa-star, fas fa-home) oder HTML (<i class="...">)'
]);

$form->addSelectField("10.0.mediaType");
$form->setLabel('Media Typ');
$form->setOption('content', 'HTML Content (freier Text)');
$form->setOption('article', 'Artikel einbinden');
$form->setOption('image', 'Bild');
$form->setOption('video', 'Video');

$form->addMediaField(1, ['label' => 'Bild/Video Datei', 'types' => 'jpg,jpeg,png,gif,webp,mp4,webm']);

// Link-Widget für Artikel-Auswahl
$form->addLinkField(2, ['label' => 'Artikel (nur bei Media Typ "Artikel einbinden")']);

// CKE5 Editor für HTML Content
$form->addTextAreaField("10.0.content", [
    'label' => 'HTML Content (nur bei Media Typ "HTML Content")',
    'class' => 'form-control cke5-editor',
    'data-lang' => \rex_i18n::getLanguage(),
    'data-profile' => 'default'
]);

echo MBlock::show(10, $form->show(), ['min' => 1, 'max' => 20]);
