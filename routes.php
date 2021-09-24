<?php

declare (strict_types=1);

function getRoutes(): array {
    $request = $_SERVER['REQUEST_URI'];

    switch (subst($request, 8)) {
        case '/' :
        case '' :
            return ['path' => 'content/main.md', 'status' => 200, 'title' => 'Startsida'];
        case '/about' :
            return ['path' => 'content/about.md', 'status' => 200, 'title' => 'Om...'];
        default:
            return ['path' => 'content/404.md', 'status' => 404, 'title' => 'Ooops...'];
    }
}
