<div class="uk-text-right">
<a class="uk-button uk-button-primary" href="#cards_help" uk-toggle="target: #cards_help">Info</a>
</div>

<div id="cards_help" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">
         <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">Info zum Modul</h2>
        <p>Dieses Modul ermöglicht die Erstellung mehrpaltiger Designs, ohne fest definiertem Grid. </p>
         <p>Es können in der Sektion Hintergrundfarben und Hintergrundbilder mit Parallax-Effekt eingebunden werden</p>
        <p>Jeder Abschnitt kann unterschiedlich breit sein oder sich dem vorhandenen Platz anpassen</p>
        <p class="uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Schließen</button>
        </p>
    </div>
</div>

<?php
use FriendsOfRedaxo\MForm;
use ExtraStyles\ExtraStyles;

$id = 1;
$MBlock = MForm::factory()
->addTabElement('Cards', MForm::factory()
->addTextField("$id.0.header", array(
    'label' => 'Header:',
))

->addMediaField(1, array(
    'label' => '<i class="fa fa-file" aria-hidden="true"></i> Medium',
    'preview' => '1'
))
->addTextField("$id.0.imageTitle", array(
    'label' => 'Bildinfo:'
))
                
->addSelectField("$id.0.crop")
->setLabel('Bildzuschnitt:')
->setOptions(array(
    '' => 'ja',
    '2' => 'nein',
))

->addTextAreaField("$id.0.content", array(
    'label' => 'Inhalt:',
    'data-lang' => \Cke5\Utils\Cke5Lang::getUserLang() ,
    'data-profile' => 'default',
    'class' => 'cke5-editor'
))
->addCustomLinkField("$id.0.1",array('label'=>'Link'))
->addTextField("$id.0.LinkText", array(
    'label' => 'Linktext (optional):'
))
               ,true,false
               )
    
->addTabElement('Settings für diese Card', MForm::factory()
->addSelectField("$id.0.ukWidth")
->setLabel('Breite:')
->setAttribute('class', 'selectpicker')
->setOptions(array(
    'auto@m' => 'automatisch',
    '1-1@m' => '100%',
    '2-3@m' => '66%',
    '1-2@m' => '50%',
    '1-3@m' => '33%',
    '1-4@m' => '25%',
    '1-5@m' => '20%',
    'expand@m' => 'Ausdehnen'
))

->addSelectField("$id.0.linkdiv")
->setLabel('Kachel verlinken')
->setAttribute('class', 'selectpicker')
->setOptions(array(
    '' => 'Nein',
    'linkdiv' => 'ja'
))

->addSelectField("$id.0.ukColor")
->setLabel('Farbe:')
->setAttribute('class', 'selectpicker')
->setOptions(array_merge(
    [
        'default' => 'Standard',
        'primary' => 'Hauptfarbe',
        'secondary' => 'Sekundär',
        'muted' => 'Muted',
        'transparent' => 'Transparent',
        'transparent uk-light' => 'Transparent helle Schrift'
    ],
    rex_addon::get('extra_styles')->isAvailable() ? ExtraStyles::getSelectOptions('card') : []
))
               );

$mm = MBlock::show($id, $MBlock->show() , array(
    'max' => 100
));



// settings
$MForm = MForm::factory()
->addTabElement('Cards', MForm::factory()
->addHTML($mm), true, false)
->addTabElement('Sektionseinstellung', MForm::factory()
->addSelectField("2.0.gutterWidth")
->setLabel('Abstand:')
->setAttribute('class', 'selectpicker')
->setOptions(array(
    'medium' => 'normal',
    'small' => 'eng',
    'large' => 'weit',
    'collapse' => 'entfernen'
))
->addDescription("Abstände zwischen den 'Cards' verändern")
->addMediaField(1, array('label'=>'Hintergrundbild'))

->addSelectField("3.0.ukcolor")
->setLabel('Farbe:')
->setAttribute('class', 'selectpicker')
->setOptions(array_merge(
    [
        'default' => 'Standard',
        'primary' => 'Primär',
        'secondary' => 'Sekundär',
        'muted' => 'Muted'
    ],
    rex_addon::get('extra_styles')->isAvailable() ? ExtraStyles::getSelectOptions('section') : []
))

// checkbox
->addCheckboxField("2.0.matchHeight", array(
    1 => 'Ja'
) , array(
    'label' => 'Alle gleiche Höhe:'
))

->addSelectField(14, array(''=>'Standard',' uk-padding-remove'=>'Keine',' uk-padding-small'=>'mittel',' uk-padding-large'=>'groß'), array('label'=>'Abschnitssfüllung', 'class'=>'selectpicker'))
                );

echo $MForm->show();
