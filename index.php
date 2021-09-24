<?php
declare (strict_types=1);

require_once 'routes.php';
$settings = 'settings.php';

if (isset($settings['rotmapp']) && is_dir($settings['rotmapp'])) {
    $routeInfo = getRoutes();
} else {
    $routeInfo = ['path' => 'content/506.html', 'status' => 506, 'title' => 'Felaktig konfigurering'];
}

if ($routeInfo['status']!==200) {
    http_response_code($routeInfo['status']);
}

$routeInfo['path']='content/main.md';
?>
<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="UTF-8">
        <title>Sångtexter <?php $routeInfo['title']!='' ? print " - $routeInfo[title]" : print ''; ?></title>
    </head>
    <body>
        <?php
            $content= file_get_contents($routeInfo['path']);
            echo $content;
        ?>
    </body>
</html>
