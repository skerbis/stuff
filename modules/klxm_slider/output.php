<?php

/** * KLXM Slider - Modul Ausgabe * Frontend-Ausgabe für den Glass Slider */
use FriendsOfRedaxo\MBlock\MBlock;
if (!rex_addon::get('mblock')->isAvailable()) { return; } $theme = "REX_VALUE[6]" ?: 'dark';
$nav_pos = "REX_VALUE[1]" ?: 'bottom-center';
$nav_vis = "REX_VALUE[2]" ?: 'visible';
$interval = "REX_VALUE[3]" ?: '4000';
$vis_offset = "REX_VALUE[5]" ?: '200';
$options = "REX_VALUE[4]";
$disableOptions = "REX_VALUE[7]";
// Dimensionen
$height = trim("REX_VALUE[8]");
$maxHeight = trim("REX_VALUE[9]");
$aspectRatio = trim("REX_VALUE[11]");
$autoplay = strpos($options, 'autoplay') !== false ? 'true' : 'false';
// Loop ist standardmäßig AN, nur wenn 'noloop' gewählt wird aus
$loop = strpos($disableOptions, 'noloop') !== false ? 'false' : 'true';
// Rounded ist standardmäßig AN, nur wenn 'norounded' gewählt wird aus
$rounded = strpos($disableOptions, 'norounded') !== false ? 'false' : 'true';
$keyboard = strpos($options, 'keyboard') !== false ? 'true' : 'false';
$touch = strpos($options, 'touch') !== false ? 'true' : 'false';
$items = MBlock::getDataArray('REX_VALUE[10]');
if ($items) {
    // CSS Custom Properties für Dimensionen
    $styleVars = [];
    if ($height !== '') { $styleVars[] = '--component-height: ' . $height; } 
    if ($maxHeight !== '') { $styleVars[] = '--component-max-height: ' . $maxHeight; } 
    if ($aspectRatio !== '') { 
        // Convert 16:9 or 16/9 to proper CSS format 16 / 9
        $aspectRatio = preg_replace('/\s*[:\/]\s*/', ' / ', $aspectRatio);
        $styleVars[] = '--component-aspect-ratio: ' . $aspectRatio; 
    } 
    $styleAttr = !empty($styleVars) ? ' style="' . implode('; ', $styleVars) . '"' : '';
    echo '<glass-slider 
        theme="' . $theme . '" nav-position="' . $nav_pos . '" nav-visibility="' . $nav_vis . '" visibility-offset="' . $vis_offset . '" autoplay="' . $autoplay . '" interval="' . $interval . '" loop="' . $loop . '" rounded="' . $rounded . '" keyboard="' . $keyboard . '" touch="' . $touch . '" ' . $styleAttr . '>';
    foreach ($items as $item) { 
        $mediaId = $item['REX_MEDIA_1'] ?? ''; 
        $media = $mediaId ? rex_media::get($mediaId) : null; 
        $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8'); 
        $desc = htmlspecialchars($item['description'] ?? '', ENT_QUOTES, 'UTF-8'); 
        $contentPosition = $item['contentPosition'] ?? 'bottom-left';
        $linkId = $item['REX_LINK_2'] ?? ''; 
        $linkTarget = $item['linkTarget'] ?? '_self';
        // Build link URL
        $linkUrl = '';
        if ($linkId) { $linkArticle = rex_article::get($linkId); if ($linkArticle) { $linkUrl = $linkArticle->getUrl(); } }
        // Determine media type
        $type = 'content';
        $src = '';
        if ($media) { $ext = strtolower(rex_file::extension($media->getFileName())); if (in_array($ext, ['mp4', 'webm'])) { $type = 'video'; } else { $type = 'image'; } $src = $media->getUrl(); }
        // Build attributes
        $attrs = ['type="' . $type . '"'];
        if ($src) { $attrs[] = 'src="' . $src . '"'; } 
        if ($title) { $attrs[] = 'title="' . $title . '"'; } 
        if ($desc) { $attrs[] = 'description="' . $desc . '"'; } 
        $attrs[] = 'content-position="' . $contentPosition . '"';
        if ($linkUrl) { $attrs[] = 'link="' . htmlspecialchars($linkUrl, ENT_QUOTES, 'UTF-8') . '"'; $attrs[] = 'link-target="' . $linkTarget . '"'; }
        echo '<slider-item ' . implode(' ', $attrs) . '></slider-item>';
    }
    echo '</glass-slider>';
}