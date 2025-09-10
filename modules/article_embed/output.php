<?php
/**
 * Artikel oder Slice einbinden - Output
 * 
 * Modernisierte Version des klassischen Slice-HiJacker Moduls
 * Gibt die ausgewählten Artikel- oder Slice-Inhalte aus
 * 
 * @package REDAXO Module
 * @author Friends Of REDAXO
 * @version 2.0.0
 */

$selectedArticleId = "REX_LINK[1]";
$selectedSliceOption = "REX_VALUE[2]";
$currentArticleId = rex_article::getCurrentId();

// Schutz vor Endlosschleifen
if ($selectedArticleId == $currentArticleId) {
    if (rex::isBackend()) {
        echo '<div class="alert alert-danger">
                <strong>Konfigurationsfehler:</strong> Der aktuelle Artikel kann nicht eingebunden werden (würde eine Endlosschleife verursachen).
              </div>';
    }
    return;
}

// Prüfen ob Artikel ausgewählt wurde
if (!$selectedArticleId) {
    if (rex::isBackend()) {
        echo '<div class="alert alert-warning">
                <strong>Konfiguration erforderlich:</strong> Bitte wählen Sie einen Artikel aus.
              </div>';
    }
    return;
}

// Prüfen ob der Artikel existiert
$targetArticle = rex_article::get($selectedArticleId);
if (!$targetArticle) {
    if (rex::isBackend()) {
        echo '<div class="alert alert-danger">
                <strong>Fehler:</strong> Der ausgewählte Artikel (ID: ' . $selectedArticleId . ') existiert nicht mehr.
              </div>';
    }
    return;
}

// Prüfen ob der Artikel online ist (nur im Frontend)
if (!rex::isBackend() && !$targetArticle->isOnline()) {
    // Im Frontend nichts ausgeben wenn Artikel offline
    return;
}

try {
    $clang = rex_clang::getCurrentId();
    
    // Kompletten Artikel einbinden
    if ($selectedSliceOption === 'complete_article' || $selectedSliceOption === '0' || empty($selectedSliceOption)) {
        
        if (rex::isBackend()) {
            echo '<div class="alert alert-info" style="margin-bottom: 15px;">
                    <strong>Embedded Article:</strong> ' . rex_escape($targetArticle->getName()) . ' (ID: ' . $selectedArticleId . ')
                  </div>';
        }
        
        // Artikel-Inhalt laden
        $articleContent = new rex_article_content($selectedArticleId, $clang);
        if ($articleContent->getArticle()) {
            echo $articleContent->getArticle();
        } else {
            if (rex::isBackend()) {
                echo '<div class="alert alert-warning">
                        <strong>Hinweis:</strong> Der Artikel enthält keine Inhalte.
                      </div>';
            }
        }
        
    } else {
        // Einzelnen Slice einbinden
        $sliceId = (int) $selectedSliceOption;
        
        if ($sliceId <= 0) {
            if (rex::isBackend()) {
                echo '<div class="alert alert-warning">
                        <strong>Konfiguration erforderlich:</strong> Bitte wählen Sie einen Block/Slice aus.
                      </div>';
            }
            return;
        }
        
        // Slice laden
        $slice = rex_article_slice::getArticleSliceById($sliceId);
        
        if (!$slice) {
            if (rex::isBackend()) {
                echo '<div class="alert alert-danger">
                        <strong>Fehler:</strong> Der ausgewählte Block/Slice (ID: ' . $sliceId . ') existiert nicht mehr.
                      </div>';
            }
            return;
        }
        
        // Prüfen ob der Slice zum ausgewählten Artikel gehört
        if ($slice->getArticleId() != $selectedArticleId) {
            if (rex::isBackend()) {
                echo '<div class="alert alert-danger">
                        <strong>Fehler:</strong> Der ausgewählte Block gehört nicht zum ausgewählten Artikel.
                      </div>';
            }
            return;
        }
        
        if (rex::isBackend()) {
            // Modul-Info für Backend
            $moduleId = $slice->getModuleId();
            $module = rex_sql::factory()->getArray('SELECT name FROM ' . rex::getTable('module') . ' WHERE id = ?', [$moduleId]);
            $moduleName = $module ? $module[0]['name'] : 'Unbekanntes Modul';
            
            echo '<div class="alert alert-info" style="margin-bottom: 15px;">
                    <strong>Embedded Slice:</strong> Block #' . $sliceId . ' aus "' . rex_escape($targetArticle->getName()) . '" 
                    <br><small>Modul: ' . rex_escape($moduleName) . '</small>
                  </div>';
        }
        
        // Slice-Inhalt ausgeben
        $sliceContent = $slice->getSlice();
        if (!empty($sliceContent)) {
            echo $sliceContent;
        } else {
            if (rex::isBackend()) {
                echo '<div class="alert alert-warning">
                        <strong>Hinweis:</strong> Der ausgewählte Block enthält keine Inhalte.
                      </div>';
            }
        }
    }
    
} catch (Exception $e) {
    if (rex::isBackend()) {
        echo '<div class="alert alert-danger">
                <strong>Fehler beim Laden der Inhalte:</strong><br>
                ' . rex_escape($e->getMessage()) . '
              </div>';
    }
    
    // Fehler loggen
    rex_logger::logException($e);
}
?>
