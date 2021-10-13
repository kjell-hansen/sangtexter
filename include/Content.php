<?php

declare (strict_types=1);
require_once 'Michelf/Markdown.inc.php';

function getContent(string $path): string {
    $content = file_get_contents($path);
    if (substr($path, strrpos($path, '.')) === '.md') {
        $parser = new Michelf\Markdown();
        return $parser->transform($content);
    } elseif (substr($path, strrpos($path, '.')) === '.html') {
        return $content;
    } else {
        return "<pre>$content</pre>";
    }    
}