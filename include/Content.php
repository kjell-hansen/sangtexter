<?php

declare (strict_types=1);
require_once 'Michelf/Markdown.inc.php';

/**
 * Läser innehållet i angiven fil och returnerar det
 * Transformerar md-filer till html
 * Returnerar i andra fall innehållet som html eller råtext
 * @param string sökväg till filen som ska läsas
 * @return string 
 */
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
