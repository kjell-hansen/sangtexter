<?php
declare (strict_types=1);

// Inkludera filer
require_once 'routes.php';
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
    </head>
    <body>
        <?php
        // Generera innehåll!
        $content = file_get_contents($routeInfo['path']);
        if (substr($routeInfo['path'], strrpos($routeInfo['path'], '.')) === '.md') {
            echo "<pre>";
            echo $content;
            echo "</pre>";
        } else {
            echo $content;
        }
        ?>
    </body>
</html>
