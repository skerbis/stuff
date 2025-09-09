<?php
/**
 * Galerie Slider - Input
 * 
 * @package REDAXO Module
 * @author Friends Of REDAXO  
 * @version 1.2.0
 */

// Medienpool-Integration für Galeriebilder
$medialist = "REX_MEDIALIST[1]";
$headline = "REX_VALUE[1]";
$description = "REX_VALUE[2]";  
$settings = "REX_VALUE[3]";

?>
<fieldset class="form-horizontal">
    <legend>Galerie Slider</legend>
    
    <div class="form-group">
        <label class="col-sm-2 control-label">Überschrift:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="REX_INPUT_VALUE[1]" value="<?= rex_escape($headline) ?>" placeholder="Galerie-Titel eingeben...">
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2 control-label">Beschreibung:</label>
        <div class="col-sm-10">
            <textarea class="form-control" name="REX_INPUT_VALUE[2]" rows="3" placeholder="Optionale Beschreibung..."><?= rex_escape($description) ?></textarea>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2 control-label">Galerie-Bilder:</label>
        <div class="col-sm-10">
            REX_MEDIA_WIDGET[id="1" widget="medialist"]
            <p class="help-block">
                <i class="rex-icon rex-icon-info"></i>
                Bilder per Drag & Drop sortieren. Erstes Bild wird als Hauptbild verwendet.
            </p>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2 control-label">Einstellungen:</label>
        <div class="col-sm-10">
            <?php 
            $settingsData = [];
            if ($settings) {
                $settingsData = json_decode($settings, true) ?: [];
            }
            
            $autoplay = $settingsData['autoplay'] ?? false;
            $speed = $settingsData['speed'] ?? 3000;
            $showDots = $settingsData['showDots'] ?? true;
            $showArrows = $settingsData['showArrows'] ?? true;
            ?>
            
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="settings[autoplay]" value="1" <?= $autoplay ? 'checked' : '' ?>>
                    Automatische Wiedergabe
                </label>
            </div>
            
            <div class="form-group">
                <label>Geschwindigkeit (ms):</label>
                <select name="settings[speed]" class="form-control">
                    <option value="2000" <?= $speed == 2000 ? 'selected' : '' ?>>Schnell (2s)</option>
                    <option value="3000" <?= $speed == 3000 ? 'selected' : '' ?>>Normal (3s)</option>
                    <option value="5000" <?= $speed == 5000 ? 'selected' : '' ?>>Langsam (5s)</option>
                </select>
            </div>
            
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="settings[showDots]" value="1" <?= $showDots ? 'checked' : '' ?>>
                    Navigationspunkte anzeigen
                </label>
            </div>
            
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="settings[showArrows]" value="1" <?= $showArrows ? 'checked' : '' ?>>
                    Pfeile anzeigen
                </label>
            </div>
            
            <input type="hidden" name="REX_INPUT_VALUE[3]" class="settings-json" value="<?= rex_escape($settings) ?>">
        </div>
    </div>
</fieldset>

<script>
// Settings als JSON speichern
$(document).ready(function() {
    function updateSettingsJson() {
        var settings = {
            autoplay: $('input[name="settings[autoplay]"]').is(':checked'),
            speed: parseInt($('select[name="settings[speed]"]').val()),
            showDots: $('input[name="settings[showDots]"]').is(':checked'),
            showArrows: $('input[name="settings[showArrows]"]').is(':checked')
        };
        $('.settings-json').val(JSON.stringify(settings));
    }
    
    $('input[name^="settings"], select[name^="settings"]').on('change', updateSettingsJson);
});
</script>
