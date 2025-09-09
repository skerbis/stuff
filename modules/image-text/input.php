<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="REX_MEDIA[1]">Bild</label>
            REX_MEDIA[type="widget" id="1" preview="1"]
        </div>
        
        <div class="form-group">
            <label for="REX_INPUT_VALUE[4]">Bild-Position</label>
            <select class="form-control" id="REX_INPUT_VALUE[4]" name="REX_INPUT_VALUE[4]">
                <option value="left"<?php if (REX_VALUE[4] == 'left') echo ' selected'; ?>>Links</option>
                <option value="right"<?php if (REX_VALUE[4] == 'right') echo ' selected'; ?>>Rechts</option>
                <option value="top"<?php if (REX_VALUE[4] == 'top') echo ' selected'; ?>>Oben</option>
            </select>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="REX_INPUT_VALUE[1]">Überschrift</label>
            <input type="text" class="form-control" id="REX_INPUT_VALUE[1]" name="REX_INPUT_VALUE[1]" value="REX_VALUE[1]" />
        </div>

        <div class="form-group">
            <label for="REX_INPUT_VALUE[2]">Text</label>
            <textarea class="form-control" id="REX_INPUT_VALUE[2]" name="REX_INPUT_VALUE[2]" rows="6">REX_VALUE[2]</textarea>
        </div>

        <div class="form-group">
            <label for="REX_INPUT_VALUE[3]">Link (optional)</label>
            <input type="url" class="form-control" id="REX_INPUT_VALUE[3]" name="REX_INPUT_VALUE[3]" value="REX_VALUE[3]" placeholder="https://..." />
        </div>
    </div>
</div>
