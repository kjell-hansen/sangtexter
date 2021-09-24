<?php
declare (strict_types=1);

// Inkludera filer
require_once 'routes.php';
require_once 'include/Michelf/Markdown.inc.php';
$settings = include 'include/settings.php';

// Kontrollera settings
if (isset($settings['rotmapp']) && is_dir($settings['rotmapp'])) {
    $routeInfo = getRoutes();
} else {
    $routeInfo = ['path' => 'content/506.html', 'status' => 506, 'title' => 'Felaktig konfigurering'];
}

// Skicka statuskod (om inte ok!)
if ($routeInfo['status'] !== 200) {
    http_response_code($routeInfo['status']);
}

?>
<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="UTF-8">
        <title>Sångtexter <?php $routeInfo['title'] != '' ? print " - $routeInfo[title]" : print ''; ?></title>
        <link href="css/main.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header>
            Sångtexter
        </header>
        <nav>
            <a href="./">Hem</a>
        </nav>
        <main>
        <?php
        // Generera innehåll!
        $content = file_get_contents($routeInfo['path']);
        if (substr($routeInfo['path'], strrpos($routeInfo['path'], '.')) === '.md') {
            $parser=new Michelf\Markdown();
            echo $parser->transform($content);
        } else {
            echo $content;
        }
        ?>
        </main>
        <footer>
            &copy; Kjell Hansen 2021
        </footer>
    </body>
</html>
