<?php

use FriendsOfRedaxo\MForm;
use FriendsOfRedaxo\MBlock\MBlock;

if (rex_addon::get('mform')->isAvailable() && rex_addon::get('mblock')->isAvailable()) {
    $mform = MForm::factory();

    $mform->addSelectField(6);
    $mform->setLabel('Theme');
    $mform->setOption('dark', 'Dunkel');
    $mform->setOption('light', 'Hell');
    $mform->setOption('glass-dark', 'Glass Dunkel (transparent)');
    $mform->setOption('glass-light', 'Glass Hell (transparent)');

    $mform->addSelectField(1);
    $mform->setLabel('Navigation Position');
    $mform->setOption('bottom-center', 'bottom-center');
    $mform->setOption('bottom-left', 'bottom-left');
    $mform->setOption('bottom-right', 'bottom-right');
    $mform->setOption('top-center', 'top-center');
    $mform->setOption('top-left', 'top-left');
    $mform->setOption('top-right', 'top-right');
    $mform->setOption('fixed-bottom', 'fixed-bottom');
    $mform->setOption('below-carousel', 'below-carousel');

    $mform->addSelectField(2);
    $mform->setLabel('Navigation Visibility');
    $mform->setOption('visible', 'visible');
    $mform->setOption('always', 'always');
    $mform->setOption('hover', 'hover');
    $mform->setOption('scroll', 'scroll');

    $mform->addTextField(3, ['label' => 'Autoplay Interval (ms)', 'default' => 4000]);

    $mform->addMultiSelectField(4, [
        'autoplay' => 'Autoplay',
        'keyboard' => 'Keyboard Navigation',
        'touch' => 'Touch/Swipe'
    ], ['label' => 'Optionen']);
    
    $mform->addMultiSelectField(5, [
        'noloop' => 'Kein Loop (am Ende stoppen)',
        'norounded' => 'Keine abgerundeten Ecken'
    ], ['label' => 'Deaktivieren']);
    
    echo $mform->show();

    // Items via MBlock
    $form = MForm::factory();
    $form->addMediaField(1, ['label' => 'Bild']);
    $form->addTextField("10.0.title", ['label' => 'Titel']);
    $form->addTextAreaField("10.0.description", ['label' => 'Beschreibung']);
    $form->addLinkField(2, ['label' => 'Link (optional)']);
    $form->addSelectField("10.0.linkTarget");
    $form->setLabel('Link öffnen in');
    $form->setOption('_self', 'Gleiches Fenster');
    $form->setOption('_blank', 'Neues Fenster');

    echo MBlock::show(10, $form->show(), ['min' => 1, 'max' => 20]);
} else {
    echo rex_view::error('Dieses Modul benötigt die Addons MForm und MBlock.');
}
?>