<?php

declare (strict_types=1);
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Det har postats något till sidan
    // För tillfället kan det bara vara sökvägen till sångtexterna
    $sokvag = filter_input(INPUT_POST, "rotmapp", FILTER_SANITIZE_URL);
    if (is_dir($sokvag )) {
        Settings::saveSettings('rotmapp', $sokvag);
    }
    $path=  ($_SERVER['REQUEST_URI']);
    header("Location: $path");
    exit();
}

/**
 * Hämtar rutter till sångtexter och/eller annat innehåll
 * @return array
 */
function getRoutes(string $textRot): array {
    // Ta hand om adressen
    $request = $_SERVER['REQUEST_URI'];

    // Aktuell mapp ska filtreras bort
    $path = basename(__DIR__);
    $file = urldecode(substr($request, mb_strlen($path) + 1));
    switch ($file) {
        case '/index.php' :
        case '/' :
        case '' :
            return ['path' => 'content/main.md', 'status' => 200, 'title' => 'Startsida'];
        case '/about' :
            return ['path' => 'content/about.md', 'status' => 200, 'title' => 'Om...'];
        default:
            if (is_file($textRot . $file)) {
                $suffixLen = mb_strlen($file) - strrpos($file, ".");
                $filename = substr($file, strrpos($file, "/") + 1, -($suffixLen + 2));
                return['path' => $textRot . $file, 'status' => 200, 'title' => $filename];
            } elseif (is_file("content/$file.md")) {
                return['path' => "content/$file.md", 'status' => 200, 'title' => substr($file, 1)];
            } else {
                return ['path' => 'content/404.md', 'status' => 404, 'title' => 'Ooops...'];
            }
    }
}
