<?php =x ?>

<!-- Push It Frontend Integration -->
<script src="/assets/addons/push_it/frontend.js"></script>
<script type="text/javascript" nonce="<?=rex_response::getNonce()?>">
// PushIt Konfiguration
window.PushItPublicKey = 'BE8mxSf98OjFyB19LTY335rgCxCfOij3uNdLPp7LRbaqdnfLoFLyC_iQrWEHocWTnwy15EsXaXCwPEUWep8jLJ0';
window.PushItLanguage = 'de'; // oder 'en' für Englisch

// Sprachdateien werden automatisch geladen - keine Inline-Übersetzungen mehr nötig

// Optional: Topics für Frontend-Nutzer
window.PushItTopics = 'news,admin,updates';
</script>

<!-- Buttons für Nutzer -->
<button onclick="PushIt.requestFrontend()">Benachrichtigungen aktivieren</button>
<button onclick="PushIt.disable()">Benachrichtigungen deaktivieren</button>
REX_ARTICLE[]
