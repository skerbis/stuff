<?php

/** * KLXM Slider - Modul Eingabe * Backend-Formular für die Konfiguration des Glass Sliders */
use FriendsOfRedaxo\MForm;
use FriendsOfRedaxo\MBlock\MBlock;
if (!rex_addon::get('mform')->isAvailable() || !rex_addon::get('mblock')->isAvailable()) {
    echo rex_view::error('Dieses Modul benötigt die Addons MForm und MBlock.');
    return;
}
// MForm für Einstellungen
$mform = MForm::factory();
$mform = $mform
    ->addSelectField(6)
    ->setLabel('Theme')
    ->setOption('dark', 'Dunkel')
    ->setOption('light', 'Hell')
    ->setOption('glass-dark', 'Glass Dunkel (transparent)')
    ->setOption('glass-light', 'Glass Hell (transparent)')
    ->addSelectField(1)
    ->setLabel('Navigation Position')
    ->setOption('bottom-center', 'Unten Mitte')
    ->setOption('bottom-left', 'Unten Links')
    ->setOption('bottom-right', 'Unten Rechts')
    ->setOption('top-center', 'Oben Mitte')
    ->setOption('top-left', 'Oben Links')
    ->setOption('top-right', 'Oben Rechts')
    ->setOption('fixed-bottom', 'Fixiert Unten')
    ->setOption('below-slider', 'Unter Slider')
    ->addSelectField(2)
    ->setLabel('Navigation Sichtbarkeit')
    ->setOption('visible', 'Sichtbar im Viewport')
    ->setOption('always', 'Immer sichtbar')
    ->setOption('hover', 'Bei Hover')
    ->setOption('scroll', 'Beim Scrollen')
    ->addFieldsetArea('Dimensionen', MForm::factory()
        ->addTextField(8, ['label' => 'Höhe (Desktop)', 'placeholder' => 'z.B. 500px, 80vh, auto'])
        ->addTextField(9, ['label' => 'Maximale Höhe (Desktop)', 'placeholder' => 'z.B. 600px oder 80vh'])
        ->addTextField(11, ['label' => 'Aspect Ratio (optional)', 'placeholder' => 'z.B. 16:9, 4:3, 21:9'])
    )
    ->addFieldsetArea('Verhalten', MForm::factory()
        ->addTextField(3, ['label' => 'Autoplay Interval (ms)', 'placeholder' => '4000'])
        ->addTextField(5, ['label' => 'Visibility Offset (px)', 'placeholder' => '200'])
        ->addMultiSelectField(4, ['autoplay' => 'Autoplay', 'keyboard' => 'Keyboard Navigation', 'touch' => 'Touch/Swipe'], ['label' => 'Optionen'])
        ->addMultiSelectField(7, ['noloop' => 'Kein Loop (am Ende stoppen)', 'norounded' => 'Keine abgerundeten Ecken'], ['label' => 'Deaktivieren'])
    );
echo $mform->show();
// MBlock für Slides
$form = MForm::factory();
$form = $form
    ->addMediaField(1, ['label' => 'Bild/Video', 'types' => 'jpg,jpeg,png,gif,webp,mp4,webm'])
    ->addTextField("10.0.title", ['label' => 'Titel'])
    ->addTextAreaField("10.0.description", ['label' => 'Beschreibung'])
    ->addSelectField("10.0.contentPosition")
    ->setLabel('Text-Position')
    ->setOption('bottom-left', 'Unten Links')
    ->setOption('bottom-center', 'Unten Mitte')
    ->setOption('bottom-right', 'Unten Rechts')
    ->setOption('center-left', 'Mitte Links')
    ->setOption('center', 'Mitte')
    ->setOption('center-right', 'Mitte Rechts')
    ->setOption('top-left', 'Oben Links')
    ->setOption('top-center', 'Oben Mitte')
    ->setOption('top-right', 'Oben Rechts')
    ->addLinkField(2, ['label' => 'Link (optional)'])
    ->addSelectField("10.0.linkTarget")
    ->setLabel('Link öffnen in')
    ->setOption('_self', 'Gleiches Fenster')
    ->setOption('_blank', 'Neues Fenster');
echo MBlock::show(10, $form->show(), ['min' => 1, 'max' => 20]);