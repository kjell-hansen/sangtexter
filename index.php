<?php
declare (strict_types=1);

// Inkludera filer
require_once 'include/Settings.php';
require_once 'include/Menu.php';
require_once 'include/Content.php';
require_once 'routes.php';

$settings= Settings::getSettings();

$baseDir = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/"));

// Kontrollera settings
if (isset($settings->rotmapp) && is_dir($settings->rotmapp)) {
    $routeInfo = getRoutes($settings->rotmapp);
    $menu = new Menu($baseDir);
    $menuItems = $menu->getMenu($settings->rotmapp);
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
        <title>Sångtexter <?php isset($routeInfo['title']) == true ? print " - $routeInfo[title]" : print ''; ?></title>
        <link href="https://fonts.googleapis.com/css2?family=Monoton&display=swap" rel="stylesheet">   
        <link href="<?= $baseDir; ?>/css/main.css" rel="stylesheet" type="text/css"/>  
    </head>
    <body>
        <header>
            Sångtexter
        </header>
        <?php
        if (isset($menu)) {
            echo "<nav>\n";
            echo $menu->parseArray($menuItems);
            echo "\n</nav>";
        }
        ?>
        <main>
            <?= getContent($routeInfo['path']); ?>
        </main>
        <footer>
            &copy; Kjell Hansen 2021
        </footer>
    </body>
</html>
