<?php
$bgimage = $footer = $result = $mediaFile = '';
$rexInputVars = rex_var::toArray("REX_VALUE[1]");
$rexSettingVars = rex_var::toArray("REX_VALUE[2]")[0];
$rexColorVars = rex_var::toArray("REX_VALUE[3]")[0];
$bgimage = '';
if ('REX_MEDIA[1]' != '') {
    $bgimage = 'style="background-image: url('.rex_media_manager::getUrl('uikit_hero_image','REX_MEDIA[1]').')" ';
}
?>

<?php
$footer = '';
$rexInputVars = rex_var::toArray("REX_VALUE[1]");
$rexSettingVars = rex_var::toArray("REX_VALUE[2]")[0];
// settings vars
$ukGutterWidth = 'uk-grid-' . $rexSettingVars['gutterWidth'];
#$ukMatchHeight = isset($rexSettingVars['matchHeight']) ? ' uk-grid-match' : '';
$ukMatchHeight = isset($rexSettingVars['matchHeight']) ? ' uk-height-match=".uk-card-wrapper" ' : '';

$output = array();
$output[] = '<div '.$ukMatchHeight.' uk-scrollspy="target: > div; cls:uk-animation-fade; delay: 500" class="' . $ukGutterWidth . ' uk-child-width-expand@m uk-flex-center" uk-grid>';

foreach ($rexInputVars as $rexVar) {
    $linkpre = $linksuf = $uklinkdiv = '';
    // uk vars
    $ukColor = 'uk-card-' . $rexVar['ukColor'];
    $body_padding_remove = '';
    if ($rexVar['ukColor'] == 'transparent' or $rexVar['ukColor'] == 'transparent uk-light')
    {    
    $body_padding_remove = ' uk-padding-remove';
    }
    $ukWidth = 'uk-width-' . $rexVar['ukWidth'];
    $uklinkdiv = ' ' . $rexVar['linkdiv'];
    // content vars
    $header = $rexVar['header'];
    $title = $rexVar['imageTitle'];
    $content = $rexVar['content'];
    $mediaFile = $rexVar['REX_MEDIA_1'];
    $managertype_effect = '';
    $media_type = rex_media::get($mediaFile);
    
    $cropping = '';
    if (isset($rexVar['crop']))
    {    
    $cropping = $rexVar['crop']; 
    }
    
    if ($media_type) {
        $media_type = $media_type->getType();

        if ($media_type != 'image/svg+xml') {
            $managertype_effect = 'card'.$cropping.'/';
        }
    }

    $managertype_effect = 'card'.$cropping;

    $link = $rexVar[1];
    $LinkText = $rexVar['LinkText'];
    if ($LinkText == '') {
        $LinkText = 'Weitere Informationen';
    }

// BEGIN Wrapper 
    if ($link != '') {
        if (!uikit_checklink($link)) {
            $link = rex_getUrl($link);
        }
        if ($rexVar['linkdiv'] != '') {
            $linkpre = '<a class="uk-link-reset" href="' . $link . '" title="Alle Infos anzeigen">';
            $linksuf = '</a>';
        }

        $linkout = uikit_checklink($link);
        $linkout = '<a class="uk-preserve-color uk-button uk-button-text" href="' . $linkout . '">' . $LinkText . ' <i data-uk-icon="icon: chevron-right; ratio: 1"></i></a>';
    }


    $output[] = '<div class="' . $ukWidth . '">';
    $output[] =  $linkpre . '<div class="uk-card uk-preserve-color ' . $ukColor .  '">';
    $output[] = '<div class="uk-card-wrapper">';

// Image oder Video selected?
    if ($mediaFile != '') {
        
        $mediaObject = rex_media::get($mediaFile);
        $mediaTitle = $mediaObject ->getTitle();
        
        if (uikit_checkMedia($mediaFile) == true) {
            $output[] = '
<div class="uk-card-media-top"  uk-lightbox="video-autoplay:true">
<a uk-tooltip="title: Click zum Vergrößern; pos: top-left" data-type="video" href="' . rex_url::media($mediaFile) . '" data-caption="Video">
<video title="' . $mediaTitle . '" src="'.rex_url::media($mediaFile).'" muted loop playsinline uk-video="autoplay: inview"></video>
</a>




</div>';
        } else {
            $output[] = '<div class="uk-card-media-top"><div class="uk-overflow-hidden">
            <img uk-image uk-scrollspy="cls:uk-animation-fade;" src="'.rex_media_manager::getUrl($managertype_effect,$mediaFile).'" title="' . $mediaTitle . '" alt="' . $mediaTitle . '">
            </div></div>';
        }
    }
    // Card header
    if ($header != '') {
        $output[] = '<div class="uk-card-header'.$body_padding_remove.'"><h2 class="uk-card-title">' . $header . '</h2></div>';
    }

    // body / content
    $output[] = '<div class="uk-card-body'.$body_padding_remove.'">';
    $output[] = $content;
    $output[] = '</div>';
    $output[] = '</div>';
    // footer
    if ($rexVar[1]) {
        $output[] = '<div class="uk-card-footer'.$body_padding_remove.'">';
        $output[] = $linkout;
        $output[] = '</div>';
    }

    // end wrapper
    $output[] = '</div>';
    $output[] = '</div>';
    $output[] = $linksuf;
}

$output[] = '</div>';
$result =  join("\n", $output);
?>

<section <?= $bgimage ?> class="uk-background-cover uk-section uk-preserve-color uk-background-cover uk-section-<?= $rexColorVars['ukcolor'] ?>REX_VALUE[14]"  uk-parallax="bgy: -100"> <div class="uk-container">
    <?= $result ?></div>
</section>