<?php
/**
 * KLXM Glassy Components - Kombiniertes Modul Ausgabe
 * Slider, Feature-Slider und Carousel in einem Modul
 */

use FriendsOfRedaxo\MBlock\MBlock;

if (!rex_addon::get('mblock')->isAvailable()) {
    return;
}

// ============================================================
// Einstellungen auslesen
// ============================================================
$settings = rex_var::toArray('REX_VALUE[1]')[0] ?? [];
$componentSettings = rex_var::toArray('REX_VALUE[2]')[0] ?? [];
$sectionSettings = rex_var::toArray('REX_VALUE[3]')[0] ?? [];

$componentType = $settings['componentType'] ?? 'slider';

// Komponenten-Einstellungen
$theme = $componentSettings['theme'] ?? 'dark';
$height = $componentSettings['height'] ?? '';
$maxHeight = $componentSettings['maxHeight'] ?? '';
$aspectRatio = $componentSettings['aspectRatio'] ?? '';
$navPosition = $componentSettings['navPosition'] ?? 'bottom-center';
$navVisibility = $componentSettings['navVisibility'] ?? 'visible';
$interval = $componentSettings['interval'] ?? '4000';
$options = $componentSettings['options'] ?? '';
$disableOptions = $componentSettings['disableOptions'] ?? '';
$behaviorDisable = $componentSettings['behaviorDisable'] ?? '';
$transition = $componentSettings['transition'] ?? 'scale';
$mediaFit = $componentSettings['mediaFit'] ?? 'contain';
$featureOptions = $componentSettings['featureOptions'] ?? [];

// Arrays normalisieren (MultiSelect gibt Arrays zurück)
$options = is_array($options) ? $options : [];
$disableOptions = is_array($disableOptions) ? $disableOptions : [];
$behaviorDisable = is_array($behaviorDisable) ? $behaviorDisable : [];
$featureOptions = is_array($featureOptions) ? $featureOptions : [];

// Optionen auswerten (in_array für Arrays)
$autoplay = in_array('autoplay', $options, true) ? 'true' : 'false';
$keyboard = in_array('keyboard', $options, true) ? 'true' : 'false';
$touch = in_array('touch', $options, true) ? 'true' : 'false';
$loop = in_array('noloop', $behaviorDisable, true) ? 'false' : 'true';
$rounded = in_array('norounded', $disableOptions, true) ? 'false' : 'true';

// Feature-Optionen
$scrollableContent = in_array('scrollableContent', $featureOptions, true) ? 'true' : 'false';
$hideIcons = in_array('hideIcons', $featureOptions, true) ? 'false' : 'true';

// Aspect Ratio Format konvertieren (16:9 -> 16 / 9)
if ($aspectRatio) {
    $aspectRatio = preg_replace('/\s*[:\/]\s*/', ' / ', $aspectRatio);
}

// Sektions-Einstellungen
$container = $sectionSettings['container'] ?? 'uk-container';
$bgImage = "REX_MEDIA[3]";
$bgColor = $sectionSettings['bgColor'] ?? '';
$padding = $sectionSettings['padding'] ?? '';
$margin = $sectionSettings['margin'] ?? '';
$customClass = $sectionSettings['customClass'] ?? '';
$sectionId = $sectionSettings['sectionId'] ?? '';

// ============================================================
// Sektion öffnen
// ============================================================
$sectionStyle = [];
if ($bgImage) {
    $sectionStyle[] = "background-image: url('" . rex_url::media($bgImage) . "')";
    $sectionStyle[] = "background-size: cover";
    $sectionStyle[] = "background-position: center";
}
if ($bgColor) {
    $sectionStyle[] = "background-color: {$bgColor}";
}

$sectionClasses = array_filter(['uk-section', $padding, $margin, $customClass]);
$sectionAttrs = [];
if ($sectionId) {
    $sectionAttrs[] = 'id="' . htmlspecialchars($sectionId, ENT_QUOTES, 'UTF-8') . '"';
}
if (!empty($sectionStyle)) {
    $sectionAttrs[] = 'style="' . implode('; ', $sectionStyle) . '"';
}

echo '<section class="' . implode(' ', $sectionClasses) . '" ' . implode(' ', $sectionAttrs) . '>' . "\n";
if ($container) {
    echo '<div class="' . htmlspecialchars($container, ENT_QUOTES, 'UTF-8') . '">' . "\n";
}

// ============================================================
// Komponente rendern
// ============================================================
switch ($componentType) {
    case 'slider':
        $items = MBlock::getDataArray('REX_VALUE[10]');
        if ($items) {
            // CSS Custom Properties für Dimensionen
            $styleVars = [];
            if ($height !== '') { $styleVars[] = '--component-height: ' . $height; }
            if ($maxHeight !== '') { $styleVars[] = '--component-max-height: ' . $maxHeight; }
            if ($aspectRatio !== '') { $styleVars[] = '--component-aspect-ratio: ' . $aspectRatio; }
            $styleAttr = !empty($styleVars) ? ' style="' . implode('; ', $styleVars) . '"' : '';
            
            echo '<glass-slider 
                theme="' . $theme . '" 
                nav-position="' . $navPosition . '" 
                nav-visibility="' . $navVisibility . '" 
                autoplay="' . $autoplay . '" 
                interval="' . $interval . '" 
                loop="' . $loop . '" 
                rounded="' . $rounded . '" 
                keyboard="' . $keyboard . '" 
                touch="' . $touch . '"' . $styleAttr . '>' . "\n";
            
            foreach ($items as $item) {
                $mediaId = $item['REX_MEDIA_1'] ?? '';
                $media = $mediaId ? rex_media::get($mediaId) : null;
                $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8');
                $desc = htmlspecialchars($item['description'] ?? '', ENT_QUOTES, 'UTF-8');
                $contentPosition = $item['contentPosition'] ?? 'bottom-left';
                $linkId = $item['REX_LINK_2'] ?? '';
                $linkTarget = $item['linkTarget'] ?? '_self';
                
                $linkUrl = '';
                if ($linkId) {
                    $linkArticle = rex_article::get($linkId);
                    if ($linkArticle) {
                        $linkUrl = $linkArticle->getUrl();
                    }
                }
                
                $type = 'content';
                $src = '';
                if ($media) {
                    $ext = strtolower(rex_file::extension($media->getFileName()));
                    $type = in_array($ext, ['mp4', 'webm']) ? 'video' : 'image';
                    $src = $media->getUrl();
                }
                
                $attrs = ['type="' . $type . '"'];
                if ($src) { $attrs[] = 'src="' . $src . '"'; }
                if ($title) { $attrs[] = 'title="' . $title . '"'; }
                if ($desc) { $attrs[] = 'description="' . $desc . '"'; }
                $attrs[] = 'content-position="' . $contentPosition . '"';
                if ($linkUrl) {
                    $attrs[] = 'link="' . htmlspecialchars($linkUrl, ENT_QUOTES, 'UTF-8') . '"';
                    $attrs[] = 'link-target="' . $linkTarget . '"';
                }
                
                echo '<slider-item ' . implode(' ', $attrs) . '></slider-item>' . "\n";
            }
            
            echo '</glass-slider>' . "\n";
        }
        break;
        
    case 'feature':
        $items = rex_var::toArray('REX_VALUE[11]');
        if (!empty($items)) {
            $attrs = ['theme="' . htmlspecialchars($theme, ENT_QUOTES, 'UTF-8') . '"'];
            
            if ($height) { $attrs[] = 'height="' . htmlspecialchars($height, ENT_QUOTES, 'UTF-8') . '"'; }
            if ($maxHeight) { $attrs[] = 'max-height="' . htmlspecialchars($maxHeight, ENT_QUOTES, 'UTF-8') . '"'; }
            if ($aspectRatio) { $attrs[] = 'aspect-ratio="' . htmlspecialchars($aspectRatio, ENT_QUOTES, 'UTF-8') . '"'; }
            if ($scrollableContent === 'true') { $attrs[] = 'scrollable-content="true"'; }
            $attrs[] = 'show-icons="' . $hideIcons . '"';
            $attrs[] = 'rounded="' . $rounded . '"';
            if ($mediaFit && $mediaFit !== 'contain') { $attrs[] = 'media-fit="' . htmlspecialchars($mediaFit, ENT_QUOTES, 'UTF-8') . '"'; }
            if ($transition && $transition !== 'scale') { $attrs[] = 'transition="' . htmlspecialchars($transition, ENT_QUOTES, 'UTF-8') . '"'; }
            
            echo '<glass-feature-slider ' . implode(' ', $attrs) . '>' . "\n";
            
            foreach ($items as $item) {
                $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8');
                $description = htmlspecialchars($item['description'] ?? '', ENT_QUOTES, 'UTF-8');
                $icon = htmlspecialchars($item['icon'] ?? '', ENT_QUOTES, 'UTF-8');
                $mediaType = $item['mediaType'] ?? 'content';
                $htmlContent = $item['content'] ?? '';
                $mediaId = $item['REX_MEDIA_1'] ?? '';
                $articleId = $item['REX_LINK_2'] ?? '';
                
                $mediaUrl = '';
                if ($mediaId) {
                    $media = rex_media::get($mediaId);
                    if ($media) {
                        $mediaUrl = $media->getUrl();
                    }
                }
                
                // Für die Web-Component: article wird wie content behandelt
                $componentMediaType = ($mediaType === 'article') ? 'content' : $mediaType;
                
                $slideAttrs = [];
                if ($title) { $slideAttrs[] = 'title="' . $title . '"'; }
                if ($description) { $slideAttrs[] = 'description="' . $description . '"'; }
                if ($icon) { $slideAttrs[] = 'icon="' . $icon . '"'; }
                $slideAttrs[] = 'media-type="' . htmlspecialchars($componentMediaType, ENT_QUOTES, 'UTF-8') . '"';
                
                // Bei image/video: media-src als Attribut setzen (Komponente rendert selbst)
                if ($mediaUrl && ($mediaType === 'image' || $mediaType === 'video')) {
                    $slideAttrs[] = 'media-src="' . htmlspecialchars($mediaUrl, ENT_QUOTES, 'UTF-8') . '"';
                }
                
                echo '<feature-slide ' . implode(' ', $slideAttrs) . '>';
                
                // Nur bei content/article: HTML als Child-Element
                if ($mediaType === 'content' && $htmlContent) {
                    $wrapperStyle = 'width: 100%; height: 100%; overflow-y: auto; padding: 2rem; box-sizing: border-box; -webkit-overflow-scrolling: touch;';
                    echo "\n<div class=\"feature-content-wrapper\" style=\"{$wrapperStyle}\">" . $htmlContent . "</div>\n";
                } elseif ($mediaType === 'article' && $articleId) {
                    $article = rex_article::get($articleId);
                    if ($article && $articleId != rex_article::getCurrentId()) {
                        $articleObj = new rex_article_content($article->getId(), rex_clang::getCurrentId());
                        $articleContent = $articleObj->getArticle(1);
                        $wrapperStyle = 'width: 100%; height: 100%; overflow-y: auto; padding: 2rem; box-sizing: border-box; -webkit-overflow-scrolling: touch;';
                        echo "\n<div class=\"feature-content-wrapper feature-article-content\" style=\"{$wrapperStyle}\">" . $articleContent . "</div>\n";
                    }
                }
                
                echo '</feature-slide>' . "\n";
            }
            
            echo '</glass-feature-slider>' . "\n";
        }
        break;
        
    case 'carousel':
        $items = MBlock::getDataArray('REX_VALUE[12]');
        if ($items) {
            echo '<glass-carousel 
                theme="' . $theme . '" 
                nav-position="' . $navPosition . '" 
                nav-visibility="' . $navVisibility . '" 
                autoplay="' . $autoplay . '" 
                interval="' . $interval . '" 
                loop="' . $loop . '" 
                rounded="' . $rounded . '" 
                keyboard="' . $keyboard . '" 
                touch="' . $touch . '">' . "\n";
            
            foreach ($items as $item) {
                $mediaId = $item['REX_MEDIA_1'] ?? '';
                $media = $mediaId ? rex_media::get($mediaId) : null;
                $title = htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8');
                $desc = htmlspecialchars($item['description'] ?? '', ENT_QUOTES, 'UTF-8');
                $linkId = $item['REX_LINK_2'] ?? '';
                $linkTarget = $item['linkTarget'] ?? '_self';
                
                $linkUrl = '';
                if ($linkId) {
                    $linkArticle = rex_article::get($linkId);
                    if ($linkArticle) {
                        $linkUrl = $linkArticle->getUrl();
                    }
                }
                
                if ($media || $title || $desc) {
                    $src = $media ? $media->getUrl() : '';
                    $attrs = [];
                    if ($src) { $attrs[] = 'src="' . $src . '"'; }
                    if ($title) { $attrs[] = 'title="' . $title . '"'; }
                    if ($desc) { $attrs[] = 'description="' . $desc . '"'; }
                    if ($linkUrl) {
                        $attrs[] = 'link="' . htmlspecialchars($linkUrl, ENT_QUOTES, 'UTF-8') . '"';
                        $attrs[] = 'link-target="' . $linkTarget . '"';
                    }
                    
                    echo '<carousel-item ' . implode(' ', $attrs) . '></carousel-item>' . "\n";
                }
            }
            
            echo '</glass-carousel>' . "\n";
        }
        break;
}

// ============================================================
// Sektion schließen
// ============================================================
if ($container) {
    echo '</div>' . "\n";
}
echo '</section>' . "\n";
