<?php

use FriendsOfRedaxo\MBlock\MBlock;
if (rex_addon::get('mblock')->isAvailable()) {
    $theme = "REX_VALUE[6]" ?: 'dark';
    $nav_pos = "REX_VALUE[1]";
    $nav_vis = "REX_VALUE[2]";
    $interval = "REX_VALUE[3]";
    $options = "REX_VALUE[4]";
    $disableOptions = "REX_VALUE[5]";
    
    $autoplay = strpos($options, 'autoplay') !== false ? 'true' : 'false';
    // Loop ist standardmäßig AN, nur wenn 'noloop' gewählt wird aus
    $loop = strpos($disableOptions, 'noloop') !== false ? 'false' : 'true';
    // Rounded ist standardmäßig AN, nur wenn 'norounded' gewählt wird aus
    $rounded = strpos($disableOptions, 'norounded') !== false ? 'false' : 'true';
    $keyboard = strpos($options, 'keyboard') !== false ? 'true' : 'false';
    $touch = strpos($options, 'touch') !== false ? 'true' : 'false';
    
    $items = MBlock::getDataArray('REX_VALUE[10]');

    if ($items) {
        
        echo '<glass-carousel 
            theme="' . $theme . '"
            nav-position="' . $nav_pos . '" 
            nav-visibility="' . $nav_vis . '" 
            autoplay="' . $autoplay . '" 
            interval="' . $interval . '" 
            loop="' . $loop . '" 
            rounded="' . $rounded . '" 
            keyboard="' . $keyboard . '" 
            touch="' . $touch . '" 
        >';
        
        foreach ($items as $item) {
            $mediaId = $item['REX_MEDIA_1'] ?? '';
            $media = $mediaId ? rex_media::get($mediaId) : null;
            $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8');
            $desc = htmlspecialchars($item['description'] ?? '', ENT_QUOTES, 'UTF-8');
            $linkId = $item['REX_LINK_2'] ?? '';
            $linkTarget = $item['linkTarget'] ?? '_self';
            
            // Build link URL
            $linkUrl = '';
            if ($linkId) {
                $linkArticle = rex_article::get($linkId);
                if ($linkArticle) {
                    $linkUrl = $linkArticle->getUrl();
                }
            }
            
            if ($media || $title || $desc) {
                $attrs = ['type="image"'];
                
                if ($media) {
                    $attrs[] = 'src="' . $media->getUrl() . '"';
                }
                if ($title) {
                    $attrs[] = 'title="' . $title . '"';
                }
                if ($desc) {
                    $attrs[] = 'description="' . $desc . '"';
                }
                if ($linkUrl) {
                    $attrs[] = 'link="' . htmlspecialchars($linkUrl, ENT_QUOTES, 'UTF-8') . '"';
                    $attrs[] = 'link-target="' . $linkTarget . '"';
                }
                
                echo '<carousel-item ' . implode(' ', $attrs) . '></carousel-item>';
            }
        }
        echo '</glass-carousel>';
    }
}