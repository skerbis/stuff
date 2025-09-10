<?php
/**
 * Artikel oder Slice einbinden - Input
 * 
 * Modernisierte Version des klassischen Slice-HiJacker Moduls
 * Ermöglicht das Einbinden kompletter Artikel oder einzelner Slices
 * 
 * @package REDAXO Module
 * @author Friends Of REDAXO
 * @version 2.0.0
 */

// Prüfen ob der ausgewählte Artikel noch existiert
$selectedArticleId = "REX_LINK_ID[1]";
$selectedSliceId = "REX_VALUE[2]";
$currentArticleId = rex_article::getCurrentId();

$hasArticleError = false;
$hasSliceError = false;

if ($selectedArticleId && !rex_article::get($selectedArticleId)) {
    $hasArticleError = true;
}

if ($selectedSliceId && $selectedSliceId !== 'complete_article' && $selectedSliceId !== '0' && !rex_article_slice::getArticleSliceById($selectedSliceId)) {
    $hasSliceError = true;
}
?>

<div class="alert alert-info">
    <strong>Artikel oder Slice einbinden</strong><br>
    Mit diesem Modul können Sie Inhalte anderer Artikel oder einzelne Slices einbinden. 
    Die Inhalte werden dynamisch geladen - Änderungen am Original werden automatisch übernommen.
</div>

<?php if ($hasArticleError): ?>
<div class="alert alert-danger">
    <strong>Fehler:</strong> Der zuvor ausgewählte Artikel existiert nicht mehr!<br>
    Bitte wählen Sie einen neuen Artikel aus.
</div>
<?php endif; ?>

<?php if ($hasSliceError): ?>
<div class="alert alert-danger">
    <strong>Fehler:</strong> Der zuvor ausgewählte Slice/Block existiert nicht mehr!<br>
    Bitte wählen Sie unten einen neuen Block aus.
</div>
<?php endif; ?>

<input type="hidden" name="REX_INPUT_VALUE[2]" value="0" />

<div class="form-group">
    <label>Artikel auswählen</label>
    REX_LINK[id=1 widget=1]
    <div class="help-block">
        Wählen Sie den Artikel aus, dessen Inhalt eingebunden werden soll.
    </div>
</div>

<?php
$selectedArticleId = "REX_LINK_ID[1]";

if (!$selectedArticleId) {
    echo '<div class="alert alert-warning">
        <i class="rex-icon rex-icon-info"></i>
        Bitte erst einen Artikel auswählen
    </div>';
} elseif ($selectedArticleId == $currentArticleId) {
    echo '<div class="alert alert-danger">
        <i class="rex-icon rex-icon-warning"></i>
        <strong>Fehler:</strong> Sie können nicht den aktuellen Artikel einbinden!<br>
        Bitte wählen Sie einen anderen Artikel aus.
    </div>';
} else {
    $targetArticle = rex_article::get($selectedArticleId);
    
    if (!$targetArticle) {
        echo '<div class="alert alert-danger">
            <i class="rex-icon rex-icon-warning"></i>
            <strong>Fehler:</strong> Der ausgewählte Artikel existiert nicht.
        </div>';
    } else {
        ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="rex-icon rex-icon-file-text"></i>
                    Ausgewählter Artikel: <?= rex_escape($targetArticle->getName()) ?>
                </h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="radio">
                        <label>
                            <input type="radio" name="REX_INPUT_VALUE[2]" value="complete_article" 
                                   <?= $selectedSliceId === 'complete_article' ? 'checked' : '' ?>>
                            <strong>Kompletten Artikel einbinden</strong>
                            <br><small class="text-muted">Bindet alle Inhalte des Artikels ein</small>
                        </label>
                    </div>
                </div>
                
                <h5><i class="rex-icon rex-icon-puzzle-piece"></i> Oder einzelnen Slice/Block auswählen:</h5>
                
                <?php
                $clang = rex_clang::getCurrentId();
                $slices = rex_article_slice::getSlicesForArticle($selectedArticleId, $clang);
                
                if (empty($slices)) {
                    echo '<div class="alert alert-warning">
                        <i class="rex-icon rex-icon-info"></i>
                        Der ausgewählte Artikel enthält keine Blöcke/Slices.
                    </div>';
                } else {
                    echo '<div class="slice-selection" style="max-height: 400px; overflow-y: auto;">';
                    
                    foreach ($slices as $slice) {
                        $sliceId = $slice->getId();
                        $moduleId = $slice->getModuleId();
                        $module = rex_sql::factory()->getArray('SELECT name FROM ' . rex::getTable('module') . ' WHERE id = ?', [$moduleId]);
                        $moduleName = $module ? $module[0]['name'] : 'Unbekanntes Modul';
                        
                        echo '<div class="slice-option panel panel-default" style="margin-bottom: 10px;">';
                        echo '<div class="panel-body" style="padding: 10px;">';
                        
                        echo '<div class="radio" style="margin: 0;">';
                        echo '<label style="font-weight: normal; width: 100%;">';
                        echo '<input type="radio" name="REX_INPUT_VALUE[2]" value="' . $sliceId . '" ';
                        echo $selectedSliceId == $sliceId ? 'checked' : '';
                        echo '>';
                        echo '<strong>Slice #' . $sliceId . '</strong> (' . rex_escape($moduleName) . ')';
                        echo '</label>';
                        echo '</div>';
                        
                        // Slice-Vorschau
                        echo '<div class="slice-preview" style="margin-top: 10px; padding: 10px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 3px; max-height: 200px; overflow: hidden;">';
                        
                        try {
                            $sliceContent = $slice->getSlice();
                            // HTML-Tags entfernen für Vorschau
                            $preview = strip_tags($sliceContent);
                            $preview = trim($preview);
                            
                            if (strlen($preview) > 200) {
                                $preview = substr($preview, 0, 200) . '...';
                            }
                            
                            if (empty($preview)) {
                                echo '<small class="text-muted"><i>Keine Textvorschau verfügbar</i></small>';
                            } else {
                                echo '<small>' . rex_escape($preview) . '</small>';
                            }
                        } catch (Exception $e) {
                            echo '<small class="text-muted"><i>Vorschau nicht verfügbar</i></small>';
                        }
                        
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        
        <script>
        $(document).ready(function() {
            // Slice-Auswahl hervorheben
            $('input[name="REX_INPUT_VALUE[2]"]').change(function() {
                $('.slice-option').removeClass('panel-primary').addClass('panel-default');
                $(this).closest('.slice-option').removeClass('panel-default').addClass('panel-primary');
            });
            
            // Initial ausgewählten Slice hervorheben
            $('input[name="REX_INPUT_VALUE[2]"]:checked').each(function() {
                $(this).closest('.slice-option').removeClass('panel-default').addClass('panel-primary');
            });
        });
        </script>
        
        <?php
    }
}
?>
