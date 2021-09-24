<?php

declare (strict_types=1);
/**
 * Hämtar rutter till sångtexter och/eller annat innehåll
 * @return array
 */
function getRoutes(): array {
    // Ta hand om adressen
    $request = $_SERVER['REQUEST_URI'];
    // Aktuell mapp ska filtreras bort
    $path = basename(__DIR__);
    
    switch (substr($request, mb_strlen($path)+1)) {
        case '/' :
        case '' :
            return ['path' => 'content/main.md', 'status' => 200, 'title' => 'Startsida'];
        case '/about' :
            return ['path' => 'content/about.md', 'status' => 200, 'title' => 'Om...'];
        default:
            return ['path' => 'content/404.md', 'status' => 404, 'title' => 'Ooops...'];
    }
}
