<!DOCTYPE html>
<html lang="<?= rex_clang::getCurrent()->getCode() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title><?= rex_escape($this->getValue('name')) ?><?php if (rex_article::getCurrent()->isStartArticle() == false): ?> - <?= rex_escape(rex_config::get('core', 'server')) ?><?php endif; ?></title>
    
    <?php if ($this->getValue('art_description')): ?>
    <meta name="description" content="<?= rex_escape($this->getValue('art_description')) ?>">
    <?php endif; ?>
    
    <!-- Bootstrap CSS (optional - durch eigenes CSS ersetzen) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= rex_url::assets('css/style.css') ?>">
</head>
<body class="<?= 'page-id-' . rex_article::getCurrentId() ?><?= rex_article::getCurrent()->isStartArticle() ? ' home' : '' ?>">

    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="site-title">
                        <a href="<?= rex_url::frontendController() ?>" title="Zur Startseite">
                            <?= rex_escape(rex_config::get('core', 'server')) ?>
                        </a>
                    </h1>
                </div>
                <div class="col-md-6">
                    <!-- Navigation -->
                    <nav class="main-navigation">
                        <?= rex_navigation::factory()->get(1, 2, TRUE, TRUE) ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="site-main">
        <div class="container">
            
            <!-- Seitentitel -->
            <div class="page-header">
                <h1 class="page-title"><?= rex_escape($this->getValue('name')) ?></h1>
            </div>
            
            <!-- Content Area -->
            <div class="page-content">
                <?= $this->getArticle() ?>
            </div>
            
        </div>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; <?= date('Y') ?> <?= rex_escape(rex_config::get('core', 'server')) ?>. Alle Rechte vorbehalten.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>Powered by <a href="https://redaxo.org" target="_blank">REDAXO CMS</a></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
