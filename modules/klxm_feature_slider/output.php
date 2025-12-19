<?php
/**
 * KLXM Feature Slider - Modul Ausgabe
 * Generiert das HTML für den Glass Feature Slider aus den Backend-Daten
 */

// Einstellungen auslesen
$theme = REX_VALUE[1] ?: 'dark';
$height = REX_VALUE[2] ?: '';
$aspectRatio = REX_VALUE[3] ?: '';
// Multi-Select speichert mit | als Trenner
$optionsRaw = REX_VALUE[4] ?: '';
$options = $optionsRaw ? explode('|', $optionsRaw) : [];
$transition = REX_VALUE[5] ?: 'scale';
$maxHeight = REX_VALUE[6] ?: '';

$scrollableContent = in_array('scrollableContent', $options) ? 'true' : 'false';
$hideIcons = in_array('hideIcons', $options) ? 'false' : 'true';
$useRatioWrapper = in_array('useRatioWrapper', $options);
$rounded = in_array('norounded', $options) ? 'false' : 'true';

// Convert 16:9 or 16/9 to proper CSS format 16 / 9
if ($aspectRatio) {
    $aspectRatio = preg_replace('/\s*[:\/]\s*/', ' / ', $aspectRatio);
}

// MBlock Items auslesen
$items = rex_var::toArray('REX_VALUE[10]');

if (!empty($items)) {
    
    // Wrapper-Container für stabiles Aspect-Ratio
    if ($useRatioWrapper && $aspectRatio) {
        $wrapperStyles = 'aspect-ratio: ' . htmlspecialchars($aspectRatio, ENT_QUOTES, 'UTF-8') . ';';
        if ($maxHeight) {
            $wrapperStyles .= ' max-height: ' . htmlspecialchars($maxHeight, ENT_QUOTES, 'UTF-8') . ';';
        }
        if ($height) {
            $wrapperStyles .= ' height: ' . htmlspecialchars($height, ENT_QUOTES, 'UTF-8') . ';';
        }
        echo '<div class="glass-feature-slider-wrapper" style="' . $wrapperStyles . ' overflow: hidden; border-radius: 30px;">' . "\n";
    }
    
    // Attribute für glass-feature-slider
    $attrs = ['theme="' . htmlspecialchars($theme, ENT_QUOTES, 'UTF-8') . '"'];
    
    if ($height) {
        $attrs[] = 'height="' . htmlspecialchars($height, ENT_QUOTES, 'UTF-8') . '"';
    }
    
    if ($maxHeight) {
        $attrs[] = 'max-height="' . htmlspecialchars($maxHeight, ENT_QUOTES, 'UTF-8') . '"';
    }
    
    // Aspect-Ratio nur als Attribut setzen, wenn KEIN Wrapper verwendet wird
    if ($aspectRatio && !$useRatioWrapper) {
        $attrs[] = 'aspect-ratio="' . htmlspecialchars($aspectRatio, ENT_QUOTES, 'UTF-8') . '"';
    }
    
    if ($scrollableContent === 'true') {
        $attrs[] = 'scrollable-content="true"';
    }
    
    $attrs[] = 'show-icons="' . $hideIcons . '"';
    $attrs[] = 'rounded="' . $rounded . '"';
    
    if ($transition && $transition !== 'scale') {
        $attrs[] = 'transition="' . htmlspecialchars($transition, ENT_QUOTES, 'UTF-8') . '"';
    }
    
    echo '<glass-feature-slider ' . implode(' ', $attrs) . '>' . "\n";
    
    foreach ($items as $item) {
        $title = $item['title'] ?? '';
        $description = $item['description'] ?? '';
        $icon = $item['icon'] ?? '';
        $mediaType = $item['mediaType'] ?? 'content';
        $htmlContent = $item['content'] ?? '';
        $mediaId = $item['REX_MEDIA_1'] ?? '';
        $articleId = $item['REX_LINK_2'] ?? '';
        
        // Media URL
        $mediaSrc = '';
        if ($mediaId) {
            $media = rex_media::get($mediaId);
            if ($media) {
                $mediaSrc = rex_url::media($mediaId);
            }
        }
        
        // Artikel-Content laden wenn Typ = article
        $articleContent = '';
        if ($mediaType === 'article' && $articleId) {
            // Prüfen ob Artikel existiert und nicht der aktuelle Artikel ist
            if ($articleId != rex_article::getCurrentId()) {
                $art = rex_article::get($articleId);
                if ($art) {
                    $articleObj = new rex_article_content($art->getId(), rex_clang::getCurrentId());
                    $articleContent = $articleObj->getArticle(1); // ctype 1
                    
                    // Im Backend: Edit-Link anzeigen
                    if (rex::isBackend()) {
                        $editUrl = rex_url::backendPage('content/edit', [
                            'mode' => 'edit',
                            'clang' => rex_clang::getCurrentId(),
                            'article_id' => $art->getId()
                        ]);
                        $articleContent = '<div class="alert alert-info" style="margin-bottom: 1rem;">
                            <a href="' . $editUrl . '" class="alert-link">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                Eingebundener Artikel: ' . htmlspecialchars($art->getName()) . '
                            </a>
                        </div>' . $articleContent;
                    }
                }
            } elseif (rex::isBackend()) {
                $articleContent = '<div class="alert alert-warning">Selbstreferenzierung nicht möglich.</div>';
            }
        }
        
        // Für die Web-Component: article wird wie content behandelt
        $componentMediaType = ($mediaType === 'article') ? 'content' : $mediaType;
        
        // Attribute für feature-slide
        $slideAttrs = [
            'title="' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '"',
            'description="' . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . '"',
            'media-type="' . htmlspecialchars($componentMediaType, ENT_QUOTES, 'UTF-8') . '"'
        ];
        
        if ($icon) {
            $slideAttrs[] = 'icon="' . htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') . '"';
        }
        
        if ($mediaSrc && ($mediaType === 'image' || $mediaType === 'video')) {
            $slideAttrs[] = 'media-src="' . htmlspecialchars($mediaSrc, ENT_QUOTES, 'UTF-8') . '"';
        }
        
        echo '    <feature-slide ' . implode(' ', $slideAttrs) . '>';
        
        // Bei Content-Type wird HTML mit scrollbarem Wrapper ausgegeben
        if ($mediaType === 'content' && !empty($htmlContent)) {
            $wrapperStyle = 'width: 100%; height: 100%; overflow-y: auto; padding: 2rem; box-sizing: border-box; -webkit-overflow-scrolling: touch;';
            echo "\n        <div class=\"feature-content-wrapper\" style=\"{$wrapperStyle}\">" . $htmlContent . "</div>\n    ";
        }
        
        // Bei Article-Type wird Artikel-Inhalt ausgegeben
        if ($mediaType === 'article' && !empty($articleContent)) {
            $wrapperStyle = 'width: 100%; height: 100%; overflow-y: auto; padding: 2rem; box-sizing: border-box; -webkit-overflow-scrolling: touch;';
            echo "\n        <div class=\"feature-content-wrapper feature-article-content\" style=\"{$wrapperStyle}\">" . $articleContent . "</div>\n    ";
        }
        
        echo '</feature-slide>' . "\n";
    }
    
    echo '</glass-feature-slider>';
    
    // Wrapper-Container schließen
    if ($useRatioWrapper && $aspectRatio) {
        echo "\n</div>";
    }
}

echo "\n\n<!-- \n";
echo "===========================================\n";
echo "DEMO HTML ZUM VERGLEICH (aus feature-demo.html)\n";
echo "===========================================\n\n";
echo htmlspecialchars('<glass-feature-slider theme="light" max-height="550px" aspect-ratio="16/9" scrollable-content="true" show-icons="false">
    <feature-slide 
        title="Image Preview" 
        description="Beautiful product imagery in compact format."
        icon="🖼️"
        media-type="image"
        media-src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&q=80"
    ></feature-slide>
    
    <feature-slide 
        title="Detailed Description" 
        description="Scrollable content within fixed dimensions."
        icon="📝"
        media-type="content"
    >
        <div style="padding: 2rem; color: #333; width: 100%;">
            <h3>Product Overview</h3>
            <p>Discover our revolutionary new product...</p>
        </div>
    </feature-slide>

    <feature-slide 
        title="Video Demo" 
        description="See it in action."
        icon="🎥"
        media-type="video"
        media-src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4"
    ></feature-slide>
</glass-feature-slider>

WICHTIG: 
- Bei media-type="image" oder "video": feature-slide bleibt leer (selbstschließend)
- Bei media-type="content": HTML Content als Child-Element von feature-slide
- Attribute: theme, max-height, aspect-ratio, scrollable-content, show-icons
- Feature-Slide Attribute: title, description, icon, media-type, media-src
');
echo "\n-->\n";
