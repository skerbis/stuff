<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Meine App">
    <link rel="apple-touch-icon" href="/assets/addons/push_it/icon.png">
    <link rel="manifest" href="/manifest.json">
</head>
<body>
    <div id="ios-install-prompt" class="ios-prompt" style="display: none;">
        <div class="ios-prompt-content">
            <h3>📱 Installation für iOS</h3>
            <p>Für Push-Benachrichtigungen auf iOS:</p>
            <ol>
                <li>Tippen Sie auf das <strong>Teilen-Symbol</strong> <span style="font-size: 1.2em;">⬆️</span></li>
                <li>Wählen Sie <strong>"Zum Home-Bildschirm"</strong></li>
                <li>Bestätigen Sie mit <strong>"Hinzufügen"</strong></li>
                <li>Öffnen Sie die App vom Home-Bildschirm</li>
                <li>Aktivieren Sie dann die Benachrichtigungen</li>
            </ol>
            <button ="hideIOSPrompt()">Verstanden</button>
        </div>
    </div>

    <div id="notification-controls">
        <button id="enable-notifications" ="enableNotifications()">
            🔔 Benachrichtigungen aktivieren
        </button>
        <button id="disable-notifications" ="disableNotifications()">
            🔕 Benachrichtigungen deaktivieren
        </button>
    </div>

    <script>
        // iOS-Erkennung und Installation
        function isIOS() {
            return /iPad|iPhone|iPod/.test(navigator.userAgent);
        }

        function isInStandaloneMode() {
            return window.navigator.standalone === true;
        }

        function isInstallable() {
            return isIOS() && !isInStandaloneMode();
        }

        // iOS-Installationsaufforderung anzeigen
        if (isInstallable()) {
            document.getElementById('ios-install-prompt').style.display = 'block';
            document.getElementById('notification-controls').style.display = 'none';
        }

        function hideIOSPrompt() {
            document.getElementById('ios-install-prompt').style.display = 'none';
            document.getElementById('notification-controls').style.display = 'block';
        }

        // Benachrichtigungen aktivieren
        async function enableNotifications() {
            // Prüfen ob iOS und nicht installiert
            if (isInstallable()) {
                alert('Bitte installieren Sie die App zuerst auf Ihrem Home-Bildschirm.');
                return;
            }

            try {
                await PushIt.subscribe('frontend', 'news,updates');
                alert('✅ Benachrichtigungen wurden aktiviert!');
                updateButtonStates();
            } catch (error) {
                console.error('Push-Fehler:', error);
                alert('❌ Fehler: ' + error.message);
            }
        }

        async function disableNotifications() {
            try {
                await PushIt.unsubscribe();
                alert('✅ Benachrichtigungen wurden deaktiviert!');
                updateButtonStates();
            } catch (error) {
                alert('❌ Fehler: ' + error.message);
            }
        }

        // Button-Status aktualisieren
        async function updateButtonStates() {
            const status = await PushIt.getStatus();
            const enableBtn = document.getElementById('enable-notifications');
            const disableBtn = document.getElementById('disable-notifications');

            if (status.isSubscribed) {
                enableBtn.style.display = 'none';
                disableBtn.style.display = 'inline-block';
            } else {
                enableBtn.style.display = 'inline-block';
                disableBtn.style.display = 'none';
            }
        }

        // Initial laden
        document.addEventListener('DOMContentLoaded', updateButtonStates);
    </script>
</body>
</html>